<?php

namespace Credit\Http\Controllers\Insurance;

use DB;
use DateTime;
use Illuminate\Http\Request;
use Credit\Http\Controllers\Controller;
use Credit\Models\Insurance\Insurance;
use Credit\Models\Operation\Operation;

class InsuranceController extends Controller
{
    public function register($id)
    {
        //
        $insurances = Insurance::where('operation_id', $id)->orderBy('expired_date')->get();
        foreach ($insurances as $key => $ins) {
            if ($ins->status == "VIGENTE" and $ins->expired_date < date('Y-m-d')) {
                $ins->status = 'VENCIDO';
                $ins->save();
            }
        }
        $operation = Operation::find($id);
        $operation_id = $operation->id;
        $monthly_term = $operation->monthly_term;
        $application_date = $operation->application_date;

        return view('insurances.register', compact('insurances', 'operation'));
    }

    public function update(Request $request)
    {
        $expired_date = $request->application_date;
        //dd($expired_date);
        for ($k=1; $k <= $request->monthly_term; $k++) {
            $payment = 'payment'.$k;
            $pay = 'pay'.$k;
            if ($request->new == 1) {
                $insurance = new Insurance();
                    $insurance->operation_id = $request->operation_id;
                    $insurance->payment = $request->$payment;
                    $insurance->expired_date = $expired_date;
                    $insurance->gestion = date('Y', strtotime($expired_date));
                $insurance->save();
                $expired_date = date('Y-m-d', strtotime('+1 year', strtotime($expired_date)));
            } else {
                $id = 'id'.$k;
                $insurance = Insurance::find($request->$id);
                    $insurance->payment = $request->$payment;
                    if ($request->$pay == 1) {
                        $insurance->status = 'PAGADO';
                        $insurance->payment_date = date('Y-m-d');
                    }
                $insurance->save();
            }
        }

        //return redirect()->action('Operation\OperationController@index');
        return redirect()->back();
    }

    public function expired(Request $request)
    {
        if ($request->send_date) {
            $date_report = date('Y-m-d', strtotime($request->date_report));
            $gestion = date('Y', strtotime($request->date_report));
        } else {
            $date_report = date('Y-m-d');
            $gestion = date('Y');
        }

        $insurances = DB::table('operations')
                        ->join('insurances', 'operations.id', '=', 'insurances.operation_id')
                        ->join('clients', 'operations.client_id', '=', 'clients.id')
                        ->select('operations.id as operation_id',
                                'operations.operation',
                                'clients.name',
                                'operations.service_2',
                                'insurances.payment',
                                'insurances.expired_date',
                                'insurances.status',
                                DB::raw('date_format(expired_date, "%Y") as gestion'))
                        ->where('insurances.expired_date', '<=', $date_report)
                        ->where(DB::raw('date_format(expired_date, "%Y")'), '=', $gestion)
                        ->where('insurances.payment', '>', 0)
                        ->orderBy('operations.operation', 'insurances.expired_date')
                        ->get();

        return view('insurances.active')->with('insurances', $insurances)->with('date_report', $date_report);

    }

    public function report($type)
    {
        $insurances = DB::table('operations')
                      ->join('insurances', 'operations.id', '=', 'insurances.operation_id')
                      ->join('clients', 'operations.client_id', '=', 'clients.id')
                      ->select('operations.id as operation_id',
                              'operations.operation',
                              'clients.name',
                              'clients.type as type',
                              'operations.service_2',
                              DB::raw('sum(insurances.payment) as insure'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "PAGADO", insurances.payment, 0)) as paid'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "VENCIDO", insurances.payment, 0)) as expired'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "VIGENTE", insurances.payment, 0)) as year1'),
                              DB::raw('sum(if(insurances.gestion = "2019" and insurances.status = "VIGENTE", insurances.payment, 0)) as year2'),
                              DB::raw('sum(if(insurances.gestion = "2020" and insurances.status = "VIGENTE", insurances.payment, 0)) as year3'),
                              'insurances.expired_date')
                      ->where(DB::raw('date_format(expired_date, "%Y")'), '>=', '2018')
                      ->groupBy('operations.id')
                      ->having('insure', '>', '0')
                      ->having('clients.type', $type)
                      ->orderBy('operations.operation')
                      ->get();
        //dd($insurances);
        return view('insurances.report', compact('insurances', 'type'));
    }
}
