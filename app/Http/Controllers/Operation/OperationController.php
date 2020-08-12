<?php

namespace Credit\Http\Controllers\Operation;

use DB;
use DateTime;
use Illuminate\Http\Request;
use Credit\Http\Controllers\Controller;
use Credit\Models\Client\Client;
use Credit\Models\Operation\Operation;
use Credit\Models\Product\Product;
use Credit\Models\Classif\Dealer;
use Credit\Models\Operation\PaymentPlan;
use Credit\Models\Insurance\Insurance;
use Credit\Models\Process\Gestion;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $operations = Operation::with('client')->get();
        return view('operations.index')->with('operations', $operations);
    }

    public function expired(Request $request)
    {
        //
        if($request->send_date) {
          $date_start = date('Y-m-d', strtotime($request->date_start));
          $date_end = date('Y-m-d', strtotime($request->date_end));
        }else{
          $date_start = new DateTime();
          $date_start->modify('first day of this month');
          $date_start = $date_start->format('Y-m-d');

          $date_end = new DateTime();
          $date_end->modify('last day of this month');
          $date_end = $date_end->format('Y-m-d');
        }
        $operations = Operation::whereBetween('next_payment_date', array($date_start, $date_end))->get();
        return view('operations.active')->with('operations', $operations)->with('date_start', $date_start)->with('date_end', $date_end);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        //
        $clients = Client::where('type', '=', $type)->orderBy('name', 'asc')->get();
        $dealers = Dealer::all('id', 'dealer');
        $products = Product::all('id', 'name');
        return view('operations.create')->with('clients', $clients)->with('type', $type)->with('dealers', $dealers)->with('products', $products);
    }

    public function find(Request $request)
    {
        if ($request->ajax()) {
            $data = $request;
            //dd($data["client"]);
            $clients = Client::FindOrFail($data["client_id"]);
            return json_encode($clients);
        }
        else {
            dd("No pasa na...");
        }
    }

    public function find_product(Request $request)
    {
        //dd($request->product_id);
        if ($request->ajax()) {
            $data = $request;
            //dd($data["product_id"]);
            $products = Product::FindOrFail($data["product_id"]);
            return json_encode($products);
        }
        else {
            dd("No pasa na...");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $ubicar = 230;  // Costo anual por el servicio de localización
        $seguro = $request->product_price*0.03; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
        $cargos = 2;    // Costo mensual por gastos administrativos
        if($request->service_1 == null && $request->service2 == null){
            $ubicar = 0;
            $seguro_rate = 0;
        }
        $balance = $request->product_price-$request->own_input+$ubicar+$seguro;
        $seguro_desgravamen = $balance*($request->disgrace_insurance_rate/100)*(360/$request->payment_term/30);

        $n = $request->payment_term;               // Número de periodos
        $i = $request->annual_interest_rate/100;   // Interés
        $a1 = $i/$n;                                  // Tipo de interés nominal anual
        $a2 = ((1+$i)**(1/$n))-1;                    // Tipo de interés efectivo

        $pmt = $this->PMT($a1, $request->monthly_term*$request->payment_term, $balance);
        //$pmt = $this->PMT($a2, $request->monthly_term*$request->payment_term, $balance);
        $first_capital = $pmt-($balance*$a1);
        //$first_capital = $pmt-($balance*$a2);

        $operation = new Operation();
            $operation->operation = $request->operation;
            $operation->request_date = $request->request_date;
            $operation->application_date = $request->application_date;
            $operation->client_id = $request->client_id;
            $operation->product_id = $request->product_id;
            $operation->dealer_id = $request->dealer_id;
            $operation->amount = $request->product_price-$request->own_input;
            $operation->product_price = $request->product_price;
            $operation->car_registration = $request->car_registration;
            $operation->own_input = $request->own_input;
            $operation->annual_interest_rate = $request->annual_interest_rate;
            $operation->delayed_interest_rate = $request->delayed_interest_rate;
            $operation->monthly_term = $request->monthly_term;
            $operation->payment_term = $request->payment_term;
            $operation->disgrace_insurance_rate = $request->disgrace_insurance_rate;
            $operation->service_1 = $ubicar;
            $operation->service_2 = $seguro;

            $operation->next_payment_date = $request->application_date;
            $operation->next_variable_fee = $pmt+$cargos+$seguro_desgravamen;
            $operation->next_payment = 1;
            $operation->last_balance = $balance;
            $operation->total_payment = $request->monthly_term*$request->payment_term;
        $operation->save();

        return redirect()->action('Operation\OperationController@index');
    }

    public function PMT($rate, $nper, $pv)
    {
      $constant_fee = ($rate*(1+$rate)**$nper)*$pv/(((1+$rate)**$nper)-1);
      return $constant_fee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $delete = "NO";
        $operations = Operation::FindOrFail($id);
        return view('operations.show')->with('operations', $operations)->with('delete', $delete);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $operations = Operation::FindOrFail($id);
        $client = Client::FindOrFail($operations->client_id);
        $clients = Client::where('type', '=', $client->type)->orderBy('name', 'asc')->get();
        $dealers = Dealer::all('id', 'dealer');
        $products = Product::all('id', 'name');
        //dd($products->name);
        return view('operations.edit')->with('operations', $operations)
                                        ->with('clients', $clients)
                                        ->with('dealers', $dealers)
                                        ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $ubicar = $request->service_1;    // Costo anual por el servicio de localización
        $seguro = $request->service_2;    // Porcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
        $cargos = 2;                      // Costo mensual por gastos administrativos

        $balance = $request->product_price-$request->own_input+$ubicar+$seguro;
        $seguro_desgravamen = $balance*($request->disgrace_insurance_rate/100)*(360/$request->payment_term/30);

        $n = $request->payment_term;                  // Número de periodos
        $i = $request->annual_interest_rate/100;      // Interés
        $a1 = $i/$n;                                  // Tipo de interés nominal anual
        $a2 = ((1+$i)**(1/$n))-1;                     // Tipo de interés efectivo

        $pmt = $this->PMT($a1, $request->monthly_term*$request->payment_term, $balance);
        //$pmt = $this->PMT($a2, $request->monthly_term*$request->payment_term, $balance);
        $first_capital = $pmt-($balance*$a1);
        //$first_capital = $pmt-($balance*$a2);

        $operation = Operation::FindOrFail($id);
            $operation->operation = $request->operation;
            $operation->request_date = $request->request_date;
            $operation->application_date = $request->application_date;
            $operation->client_id = $request->client_id;
            $operation->product_id = $request->product_id;
            $operation->dealer_id = $request->dealer_id;
            $operation->amount = $request->product_price-$request->own_input;
            $operation->product_price = $request->product_price;
            $operation->car_registration = $request->car_registration;
            $operation->own_input = $request->own_input;
            $operation->annual_interest_rate = $request->annual_interest_rate;
            $operation->delayed_interest_rate = $request->delayed_interest_rate;
            $operation->monthly_term = $request->monthly_term;
            $operation->payment_term = $request->payment_term;
            $operation->disgrace_insurance_rate = $request->disgrace_insurance_rate;
            $operation->service_1 = $ubicar;
            $operation->service_2 = $seguro;

            $operation->next_payment_date = $request->application_date;
            $operation->next_variable_fee = $pmt+$cargos+$seguro_desgravamen;
            $operation->next_payment = 1;
            $operation->last_balance = $balance;
            $operation->total_payment = $request->monthly_term*$request->payment_term;
        $operation->save();

        if ($seguro!=0) {
            $insurances = Insurance::where('operation_id', $id)->orderBy('payment_date')->get();
            if ($insurances->isEmpty()) {
                for ($k = 1; $k <= $request->monthly_term; $k++) {
                    if ($k == 1) {
                        $payment_insurance = $operation->product_price;
                        $payment_date = $operation->application_date;
                    } elseif ($k == 2) {
                        $payment_insurance = $payment_insurance*(1-0.13)*(1-0.2);
                        $payment_date = date('Y-m-d', strtotime('+1 year', strtotime($payment_date)));
                    } elseif ($k == 3) {
                        $payment_insurance = $payment_insurance*(1-0.1);
                        $payment_date = date('Y-m-d', strtotime('+1 year', strtotime($payment_date)));
                    }
                    $payment = $payment_insurance*0.03;
                    if ($payment < 300) {
                        $payment = 300;
                    }
                    $insurance = new Insurance();
                        $insurance->operation_id = $id;
                        $insurance->payment = $payment;
                        $insurance->payment_date = $payment_date;
                    $insurance->save();
                }
            }
            else {
                $k = 1;
                foreach ($insurances as $key => $ins) {
                    if ($k == 1) {
                        $payment_insurance = $operation->product_price;
                        $payment_date = $operation->application_date;
                    } elseif ($k == 2) {
                        $payment_insurance = $payment_insurance*(1-0.13)*(1-0.2);
                        $payment_date = date('Y-m-d', strtotime('+1 year', strtotime($payment_date)));
                    } elseif ($k == 3) {
                        $payment_insurance = $payment_insurance*(1-0.1);
                        $payment_date = date('Y-m-d', strtotime('+1 year', strtotime($payment_date)));
                    }
                    $payment = $payment_insurance*0.03;
                    if ($payment < 300) {
                        $payment = 300;
                    }
                    $insurance = Insurance::find($ins->id);
                        $insurance->payment = $payment;
                        $insurance->payment_date = $payment_date;
                    $insurance->save();
                    $k++;
                }
            }
        }

        return redirect()->action('Operation\OperationController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $delete = "YES";
        $operations = Operation::FindOrFail($id);
        return view('operations.show')->with('operations', $operations)->with('delete', $delete);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $operations = Operation::FindOrFail($id);
        $operations->delete();
        return redirect()->action('Operation\OperationController@index');
    }

    public function report(Request $request, $type)
    {
        //
        if ($request->send_date) {
            $date_report = date('Y-m-d', strtotime($request->date_report));
            $gestion = date('Y', strtotime($request->date_report));
            $period = date('m', strtotime($request->date_report));
        } else {
            $date_report = date('Y-m-d');
            $gestion = date('Y');
            $period = date('m');
        }

        $payments = Operation::query_report($gestion, $date_report, $type);

        return view('operations.report')->with('payments', $payments)->with('type', $type)->with('date_report', $date_report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate_plan($id)
    {
        //
        $operations = Operation::FindOrFail($id);
        return view('operations.plan_generate')->with('operations', $operations);
    }

    public function payment(Request $request, $id)
    {
        //
        $n = $request->payment_term;                                                // Número de periodos
        $i = floatval(str_replace(',', '', $request->annual_interest_rate))/100;    // Interés
        $a1 = $i/$n;                                                                // Tipo de interés nominal anual
        $a2 = ((1+$i)**(1/$n))-1;                                                   // Tipo de interés efectivo
        $b1 = intval($request->term);
        $c1 = floatval(str_replace(',', '', $request->capital));
        $cx = floatval(str_replace(',', '', $request->amount));

        $cuota = $this->PMT($a1, $b1, $c1);
        //$cuota = $this->PMT($a2, $b1, $c1);
        $cuotx = $this->PMT($a1, $b1, $cx);
        //$cuotx = $this->PMT($a2, $b1, $cx);

        $plazo = intval($request->term);
        $saldo = floatval(str_replace(',', '', $request->capital));
        $vence = date('Y-m-d', strtotime($request->application_date));
        $gestion = substr($vence, 0, 4);
        if($request->seguro != null || $request->ubicar != null){
            $cuota_seguro = ($cuota-$cuotx)*(floatval(str_replace(',', '', $request->seguro))/floatval(str_replace(',', '', $request->service)));
            $cuota_ubicar = ($cuota-$cuotx)*(floatval(str_replace(',', '', $request->ubicar))/floatval(str_replace(',', '', $request->service)));
        }else{
            $cuota_seguro = 0;
            $cuota_ubicar = 0;
        }
        $last_balance = $saldo;
        $seguro_desgravamen = $saldo * ($request->disgrace_insurance_rate/100)*($request->periodicity/30);

        for ($x = 1; $x <= $plazo; $x++) {
            $interest = $a1 * $saldo;
            //$interest = $a2 * $saldo;
            $capital = $cuota - $interest;

            $payment = new PaymentPlan();
                $payment->operation_id = $request->operation_id;
                $payment->gestion = $gestion;
                $payment->payment = $x;
                $payment->expiration_date = $vence;
                if ($x == 1) {
                  $payment->payment_date = ' ';
                }
                //$payment->payment_date = '';
                $payment->fixed_fee = $cuota;
                $payment->interest = $interest;
                $payment->capital = $capital;
                $payment->assure = $cuota_seguro;
                $payment->ubicar = $cuota_ubicar;
                $payment->charges = $request->cargos;
                $payment->disgrace = $seguro_desgravamen;
                $payment->variable_fee = $cuota + $request->cargos + $seguro_desgravamen;
                $payment->balance = $saldo - $capital;
            $payment->save();

            $saldo = $saldo-$capital;
            $seguro_desgravamen = $saldo*($request->disgrace_insurance_rate/100)*($request->periodicity/30);
            for ($y = 1; $y <= 12/$request->payment_term; $y++) {
              $num = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($vence)), date('Y', strtotime($vence)));
              $vence = date('Y-m-d', strtotime($vence.'+'.$num.' day'));
              $gestion = substr($vence, 0, 4);
            }
        }

        $operation = Operation::FindOrFail($id);
            $operation->status = "PPG";
        $operation->save();

        return redirect()->action('Operation\OperationController@index');
    }

    public function plan($id)
    {
        //
        $operation = Operation::FindOrFail($id);
        $payments = PaymentPlan::where('operation_id', $id)->get();
        return view('operations.plan')->with('operation', $operation)->with('payments', $payments);
    }

    public function amort($id)
    {
        //
        $operation = Operation::FindOrFail($id);
        $payments = PaymentPlan::where('operation_id', $id)->get();
        return view('operations.amort')->with('operation', $operation)->with('payments', $payments);
    }

    public function prev_amort(Request $request, $id)
    {
        //
        if ($request->amort_a) {
          $payment_voucher = PaymentPlan::FindOrFail($request->id_payment_a[0]);
          $payment_voucher->voucher_number = $request->voucher_number;
          $payment_voucher->save();
          for ($i=0; $i < count($request->id_payment_a); $i++) {
            $payments = PaymentPlan::FindOrFail($request->id_payment_a[$i]);
                if ($request->payment_date_a[$i]=='') {
                    $payments->payment_date = null;
                } else {
                    $payments->payment_date = $request->payment_date_a[$i];
                }
                $payments->fixed_fee = $request->fixed_fee_a[$i];
                $payments->capital = $request->capital_a[$i];
                $payments->interest = $request->interest_a[$i];
                $payments->interest_late = $request->interest_late_a[$i];
                $payments->charges = $request->charges_a[$i];
                $payments->disgrace = $request->disgrace_a[$i];
                $payments->variable_fee = $request->variable_fee_a[$i];
                $payments->balance = $request->balance_a[$i];
                $payments->amortization_fee = $request->amortization_fee_a[$i];
                $payments->interest_accrued = $request->interest_accrued_a[$i];
            $payments->save();
            $pivote = $request->payment_a[$i]+1;
          }
          for ($i=$pivote; $i <= $request->term; $i++) {
            $payments = PaymentPlan::where('operation_id', $id)->where('payment', $i)->delete();
          }
          $operation = Operation::FindOrFail($id);
              $operation->last_payment_date = $request->payment_date_a[0];
              $operation->next_payment_date = $request->expiration_date_a[1];
              $operation->last_variable_fee = $request->variable_fee_a[0];
              $operation->next_variable_fee = $request->variable_fee_a[1];
              $operation->next_payment = $request->payment_a[1];
              $operation->last_balance = $request->balance_a[0];
          $operation->save();
          return redirect()->action('Operation\OperationController@index');
        } elseif ($request->amort_b) {
          $payment_voucher = PaymentPlan::FindOrFail($request->id_payment_b[0]);
          $payment_voucher->voucher_number = $request->voucher_number;
          $payment_voucher->save();
          for ($i=0; $i < count($request->id_payment_b); $i++) {
            $payments = PaymentPlan::FindOrFail($request->id_payment_b[$i]);
                if ($request->payment_date_b[$i]=='') {
                    $payments->payment_date = null;
                } else {
                    $payments->payment_date = $request->payment_date_b[$i];
                }
                $payments->fixed_fee = $request->fixed_fee_b[$i];
                $payments->capital = $request->capital_b[$i];
                $payments->interest = $request->interest_b[$i];
                $payments->interest_late = $request->interest_late_b[$i];
                $payments->charges = $request->charges_b[$i];
                $payments->disgrace = $request->disgrace_b[$i];
                $payments->variable_fee = $request->variable_fee_b[$i];
                $payments->balance = $request->balance_b[$i];
                $payments->amortization_fee = $request->amortization_fee_b[$i];
                $payments->interest_accrued = $request->interest_accrued_b[$i];
            $payments->save();
          }
          $operation = Operation::FindOrFail($id);
              $operation->last_payment_date = $request->payment_date_b[0];
              $operation->next_payment_date = $request->expiration_date_b[1];
              $operation->last_variable_fee = $request->variable_fee_b[0];
              $operation->next_variable_fee = $request->variable_fee_b[1];
              $operation->next_payment = $request->payment_b[1];
              $operation->last_balance = $request->balance_b[0];
          $operation->save();
          return redirect()->action('Operation\OperationController@index');
        } elseif ($request->amort_c) {
          $payment_voucher = PaymentPlan::FindOrFail($request->id_payment_c[0]);
          $payment_voucher->voucher_number = $request->voucher_number;
          $payment_voucher->save();
          for ($i=0; $i < count($request->id_payment_c); $i++) {
            $payments = PaymentPlan::FindOrFail($request->id_payment_c[$i]);
                if ($request->payment_date_c[$i]=='') {
                    $payments->payment_date = null;
                } else {
                    $payments->payment_date = $request->payment_date_c[$i];
                }
                $payments->fixed_fee = $request->fixed_fee_c[$i];
                $payments->capital = $request->capital_c[$i];
                $payments->interest = $request->interest_c[$i];
                $payments->interest_late = $request->interest_late_c[$i];
                $payments->charges = $request->charges_c[$i];
                $payments->disgrace = $request->disgrace_c[$i];
                $payments->variable_fee = $request->variable_fee_c[$i];
                $payments->balance = $request->balance_c[$i];
                $payments->amortization_fee = $request->amortization_fee_c[$i];
                $payments->interest_accrued = $request->interest_accrued_c[$i];
            $payments->save();
            $pivote = $request->payment_c[$i]+1;
          }
          //dd($request->operation_id);
          for ($i=$pivote; $i <= $request->term; $i++) {
            $payments = PaymentPlan::where('operation_id', $id)->where('payment', $i)->delete();
            //$payments->delete();
          }
          $operation = Operation::FindOrFail($id);
              $operation->last_payment_date = $request->payment_date_c[0];
              $operation->next_payment_date = $request->expiration_date_c[1];
              $operation->last_variable_fee = $request->variable_fee_c[0];
              $operation->next_variable_fee = $request->variable_fee_c[1];
              $operation->next_payment = $request->payment_c[1];
              $operation->last_balance = $request->balance_c[0];
              $operation->total_payment = $pivote-1;
          $operation->save();
          return redirect()->action('Operation\OperationController@index');
        } elseif ($request->amort_d) {
          $payments = PaymentPlan::FindOrFail($request->id_payment_d[0]);
              $payments->voucher_number = $request->voucher_number;
              $payments->payment_date = $request->payment_date_d[0];
              $payments->fixed_fee = $request->fixed_fee_d[0];
              $payments->capital = $request->capital_d[0];
              $payments->interest = $request->interest_d[0];
              $payments->variable_fee = $request->variable_fee_d[0];
              $payments->balance = $request->balance_d[0];
          $payments->save();
          $pivote = $request->payment_d[0]+1;
          for ($i=$pivote; $i <= $request->term; $i++) {
            $payments = PaymentPlan::where('operation_id', $id)->where('payment', $i)->delete();
          }
          $operation = Operation::FindOrFail($id);
              $operation->last_payment_date = $request->payment_date_d[0];
              $operation->next_payment_date = null;
              $operation->last_variable_fee = $request->variable_fee_d[0];
              $operation->next_variable_fee = null;
              $operation->next_payment = null;
              $operation->last_balance = 0;
              $operation->total_payment = $pivote-1;
          $operation->save();
          return redirect()->action('Operation\OperationController@index');
        } elseif ($request->amort_e) {
          $operation = Operation::FindOrFail($id);
              $operation->status = "REC";
              $operation->next_payment = 0;
          $operation->save();
          return redirect()->action('Operation\OperationController@index');
        } else {
          if($request->normal){
            $amort_mode = "normal";
          } elseif($request->red_cuota) {
            $amort_mode = "red_cuota";
          } elseif($request->red_plazo) {
            $amort_mode = "red_plazo";
          } elseif($request->liquida) {
            $amort_mode = "liquida";
          } elseif($request->rec_mora) {
            $amort_mode = "rec_mora";
          } else {
            $amort_mode = "";
          }
          //dd($amort_mode);
          $amort_date = $request->amort_date;
          $capital_fee = $request->capital_fee;
          $interest_accrued = $request->interest_accrued;
          $days_late = $request->days_late;
          $interest_late = $request->interest_late;
          $voucher_number = $request->voucher_number;
          $operation = Operation::FindOrFail($id);
          $payments = PaymentPlan::where('operation_id', $id)->get();
          return view('operations.amort_prev')->with('operation', $operation)
                                          ->with('payments', $payments)
                                          ->with('amort_date', $amort_date)
                                          ->with('days_late', $days_late)
                                          ->with('capital_fee', $capital_fee)
                                          ->with('interest_accrued', $interest_accrued)
                                          ->with('interest_late', $interest_late)
                                          ->with('voucher_number', $voucher_number)
                                          ->with('amort_mode', $amort_mode);
        }
    }

    public function mora_amort($id)
    {
        //
        $payment = PaymentPlan::FindOrFail($id);
        $operation = Operation::FindOrFail($payment->operation_id);
        $open_gestion = Gestion::all()->where('status', 'ABIERTO')->min('gestion');
        return view('operations.amort_mora')->with('operation', $operation)
                                            ->with('payment', $payment)
                                            ->with('open_gestion', $open_gestion);
    }

    public function mora_pay_amort(Request $request, $id)
    {
        //
        //dd($request->gestion_pass);
        $payment = PaymentPlan::FindOrFail($id);
          if ($request->gestion_pass==1) {
            $payment->interest_accrued_past = $request->interest_accrued_past;
            $payment->accrued_past_payment_date = $request->accrued_past_payment_date;
            $payment->accrued_past_voucher = $request->accrued_past_voucher;
            $payment->interest_accrued = $payment->interest_accrued-$request->interest_accrued_past;
          }
          else {
            $payment->interest_late = $request->interest_late;
            $payment->interest_accrued = $payment->interest_accrued-$request->interest_late;
          }
        $payment->save();
        return redirect()->action('Operation\OperationController@index');
    }

    public function accrued_report(Request $request, $type)
    {
        //
        if ($request->send_date) {
            $date_report = date('Y-m-d', strtotime($request->date_report));
            $gestion = date('Y', strtotime($request->date_report));
            $period = date('m', strtotime($request->date_report));
        } else {
            $date_report = date('Y-m-d');
            $gestion = date('Y');
            $period = date('m');
        }

        $payments = Operation::query_accrued_report($gestion-1, $date_report, $type);

        return view('operations.accrued_report')->with('payments', $payments)
                                                ->with('type', $type)
                                                ->with('date_report', $date_report);
    }
}
