<?php

namespace Credit\Http\Controllers\Process;

use DB;
use Illuminate\Http\Request;
use Credit\Http\Controllers\Controller;
use Credit\Models\Dim\DimCreditReport;
use Credit\Models\Operation\Operation;
use Credit\Models\Operation\PaymentPlan;
use Credit\Models\Process\Gestion;
use Credit\Models\Process\Period;

class ProcessController extends Controller
{
    //
    public function rescission()
    {
        //
        $operations = Operation::with('client')->where('status', 'PPG')->get();
        return view('process.rescission')->with('operations', $operations);
    }

    public function apply_rescission($id)
    {
        //
        $operation = Operation::FindOrFail($id);
        $rescission_payments = DB::table('payments')->where('operation_id', $operation->id)->where('payment_date', '<>', NULL)->sum('variable_fee');
        $rescission_fee = DB::table('payments')->where('operation_id', $operation->id)->where('payment_date', '<>', NULL)->count('variable_fee');
        return view('process.apply_rescission')->with('operation', $operation)
                                               ->with('rescission_fee', $rescission_fee)
                                               ->with('rescission_payments', $rescission_payments);
    }

    public function apply_rescission_prev(Request $request, $id)
    {
        if ($request->process_ok) {
            //dd($request->rescission_fee);
            $operation = Operation::FindOrFail($id);
              $operation->status = "RES";
              $operation->next_payment_date = NULL;
              $operation->next_variable_fee = NULL;
              $operation->last_balance = 0;
              $operation->rescission_date = $request->rescission_date;
              $operation->rescission_payments = $request->rescission_payments_apply;
              $operation->rescission_discount = $request->rescission_discount_apply;
            $operation->save();
            $payments = PaymentPlan::where('operation_id', $id)->where('payment', '>', $request->rescission_fee)->delete();
            return redirect()->action('Operation\OperationController@index');
        } else {
            $operation = Operation::FindOrFail($id);
            $rescission_payments = $request->rescission_payments;
            $rescission_fee = $request->rescission_fee;
            $rescission_date = $request->rescission_date;
            $rescission_discount = $request->rescission_discount;
            return view('process.apply_rescission_prev')->with('operation', $operation)
                                                   ->with('rescission_fee', $rescission_fee)
                                                   ->with('rescission_payments', $rescission_payments)
                                                   ->with('rescission_date', $rescission_date)
                                                   ->with('rescission_discount', $rescission_discount);
        }
    }

    public function close_period()
    {
        //
        $min_gestion = Gestion::all()->where('status', 'ABIERTO')->min('gestion');
        $periods = Period::all()->where('gestion', $min_gestion);
        return view('process.close_period')->with('periods', $periods);

    }

    public function period_close($id)
    {
        //
        $period = Period::FindOrFail($id);
        $date_report = date("Y-m-d", (mktime(0, 0, 0, $period->period+1, 1, $period->gestion)-1));

        $payments_prop = Operation::query_report($period->gestion, $date_report, "PROPIO");
        $this->create_dimCreditReport($payments_prop, $period->gestion, $period->period, $date_report);

        $payments_fin = Operation::query_report($period->gestion, $date_report, "FINANCIAL");
        $this->create_dimCreditReport($payments_fin, $period->gestion, $period->period, $date_report);

        Period::where('id',$id)->update(['status' => 'CERRADO']);
        return redirect()->action('Process\ProcessController@close_period');
    }

    public function create_dimCreditReport($payments, $gestion, $period, $date_report)
    {
        foreach ($payments as $payment) {
            $dimCreditReport = new DimCreditReport();
            if ($payment->request_date <= $date_report) {
                $dimCreditReport->gestion = $gestion;
                $dimCreditReport->period = $period;
                $dimCreditReport->operation_id = $payment->operation_id;
                $dimCreditReport->operation = $payment->operation;
                $dimCreditReport->client_id = $payment->client_id;
                $dimCreditReport->client = $payment->name;
                $dimCreditReport->client_type = $payment->type;
                $dimCreditReport->first_payment = $payment->application_date;
                $dimCreditReport->last_payment = $payment->payment_date;
                if ($payment->status == "REC" or $payment->status == "RES") {
                    $dimCreditReport->amount_credit = null;
                    $dimCreditReport->capital = null;
                    $dimCreditReport->interest = null;
                    $dimCreditReport->interest_late = null;
                    $dimCreditReport->ubicar = null;
                    $dimCreditReport->assure = null;
                    $dimCreditReport->charges = null;
                    $dimCreditReport->disgrace = null;
                    $dimCreditReport->last_balance = null;
                    $dimCreditReport->fee_delayed = null;
                } else {
                    $dimCreditReport->amount_credit = $payment->amount + $payment->service_1 + $payment->service_2;
                    if ($payment->last_payment_date <> '') { $dimCreditReport->capital = $payment->capital + $payment->amortization_fee; } else { $dimCreditReport->capital = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->interest = $payment->interest; } else { $dimCreditReport->interest = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->interest_late = $payment->interest_late; } else { $dimCreditReport->interest_late = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->ubicar = $payment->ubicar; } else { $dimCreditReport->ubicar = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->assure = $payment->assure; } else { $dimCreditReport->assure = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->charges = $payment->charges; } else { $dimCreditReport->charges = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->disgrace = $payment->disgrace; } else { $dimCreditReport->disgrace = 0; }
                    if ($payment->last_payment_date <> '') { $dimCreditReport->last_balance = $payment->last_balance; } else { $dimCreditReport->last_balance = $payment->amount + $payment->service_1 + $payment->service_2; }
                    $dimCreditReport->fee_delayed = $this->delayed($payment->payment_date, $payment->expiration_date, $date_report, $payment->payment_term, $payment->balance, $payment->total_payment, $payment->payment, $payment->next_payment);
                }
                if ($payment->next_payment <> '') { $dimCreditReport->fee_plan_num = $payment->next_payment - 1; } else { $dimCreditReport->fee_plan_num = $payment->total_payment; }
                $dimCreditReport->fee_plan_den = $payment->total_payment;
                switch ($payment->payment_term) {
                    case 12:  $dimCreditReport->pay_plan = "Mensual"; break;
                    case 6:   $dimCreditReport->pay_plan = "Bimestral"; break;
                    case 4:   $dimCreditReport->pay_plan = "Trimestral"; break;
                    case 2:   $dimCreditReport->pay_plan = "Semestral"; break;
                    case 1:   $dimCreditReport->pay_plan = "Anual"; break;
                }
                $dimCreditReport->save();
            }
        }

        return;
    }

    public function delayed($payment_date, $expiration_date, $date_report, $payment_term, $balance, $total_payment, $payment, $next_payment)
    {
        $delayed = 0;
        if($payment_date <> null) {
             $expiration = date('Y-m-d', strtotime($expiration_date));
        } else {
             $expiration = date('Y-m-d', strtotime($date_report));
        }
        while ($expiration <= $date_report) {
           for ($y = 1; $y <= 12/$payment_term; $y++) {
              $num = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($expiration)), date('Y', strtotime($expiration)));
              $expiration = date('Y-m-d', strtotime($expiration.'+'.$num.' day'));
           }
           $delayed++;
        }
        if ($balance == 0 or $delayed <= 0) {
            return 0;
        } else {
            if (($total_payment - $payment) > ($delayed - 1)) {
                if ($next_payment > $payment) {
                    return $delayed-1;
                } else {
                    return $delayed;
                }
            } else {
               return $total_payment - $payment;
            }
        }
    }

    public function close_gestion()
    {
        //
        $min_gestion = Gestion::all()->max('gestion');
        $max_gestion = PaymentPlan::all()->max('expiration_date');
        while ($min_gestion < date("Y", strtotime($max_gestion))) {
            $min_gestion = $min_gestion+1;
            $gest = new Gestion;
            $gest->gestion = $min_gestion;
            $gest->status = "ABIERTO";
            $gest->save();
        }
        $gestions = Gestion::all();

        return view('process.close_gestion')->with('gestions', $gestions);

    }

    public function gestion_close($gestion)
    {
        //
        $operations = Operation::where('last_balance', 0)->whereYear('last_payment_date', $gestion)->get();
        if (!$operations->isEmpty()) {
            $operations = Operation::where('last_balance', 0)->whereYear('last_payment_date', $gestion)->update(['status' => 'LIQ']);
            Gestion::where('gestion',$gestion)->update(['status' => 'CERRADO']);
        } else {
            $mssage = "Gestión no puede ser cerrada";
        }
        return redirect()->action('Process\ProcessController@close_gestion');
    }
}
