@extends('layouts.blank')

@section('title', 'Plan de pagos')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Operaciones <small>Plan de pagos</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
                $ubicar = $operations->service_1;  // Costo anual por el servicio de localización
                $seguro = $operations->service_2; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
                $cargos = 2;    // Costo mensual por gastos administrativos
                if($operations->service_1 == null && $operations->service_2 == null){
                    $ubicar = 0;
                    $seguro = 0;
                }
            ?>
            <!--form-->
            <form id="payment_generate" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_payment', $operations->id) }}">
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            {{ Form::hidden('operation_id', $operations->id, ['id'=>'operation_id']) }}
                            {{ Form::hidden('civil_status', $operations->client->civil_status, ['id'=>'civil_status']) }}
                            {{ Form::hidden('legal_personality', $operations->client->legal_personality, ['id'=>'legal_personality']) }}

                            {{ Form::hidden('cargos', $cargos, ['id'=>'cargos']) }}
                            <br />
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Número de operación </label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('operation', $operations->operation, ['id'=>'operation', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Fecha de aplicación</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('application_date', date('Y-m-d', strtotime($operations->application_date)), ['id'=>'application_date', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Cliente</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('client_name', $operations->client->name, ['id'=>'client_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">{{ $operations->client->type_id_document }}</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('client_id_document', $operations->client->id_document, ['id'=>'client_id_document', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Producto</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('product_name', $operations->product->name, ['id'=>'product_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Matrícula</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('car_registration', $operations->car_registration, ['id'=>'car_registration', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Interés anual (%)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('annual_interest_rate',$operations->annual_interest_rate, ['id'=>'annual_interest_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Plazo (meses)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('term', $operations->monthly_term*$operations->payment_term, ['id'=>'term', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Frecuencia (días)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('periodicity', 360/$operations->payment_term, ['id'=>'periodicity', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                                {{ Form::hidden('payment_term', $operations->payment_term, ['id'=>'payment_term', 'class'=>'form-control input-sm']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Precio producto</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('product_price', number_format($operations->product_price, 2, '.', ','), ['id'=>'product_price', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">Aporte</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('own_input',number_format($operations->own_input, 2, '.', ','), ['id'=>'own_input', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Saldo a financiar</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('amount',number_format($operations->amount, 2, '.', ','), ['id'=>'amount', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        @if($operations->service_1 != null || $operations->service_2 != null)
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">UBICAR</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('ubicar', number_format($ubicar, 2, '.', ','), ['id'=>'ubicar', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">SEGURO</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('seguro',number_format($seguro, 2, '.', ','), ['id'=>'seguro', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Total servicios</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('service',number_format($ubicar+$seguro, 2, '.', ','), ['id'=>'service', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-3">Indice del Seg. Desgravamen (%)</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('disgrace_insurance_rate', number_format($operations->disgrace_insurance_rate, 2, '.', ','), ['id'=>'disgrace_insurance_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Total a financiar</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('capital',number_format($operations->amount+$ubicar+$seguro, 2, '.', ','), ['id'=>'capital', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="x_panel">
                <div>
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">Vencimiento</th>
                            <th class="column-title">PPP</th>
                            <th class="column-title">Interés </th>
                            <th class="column-title">Capital </th>
                            <th class="column-title">Seguro</th>
                            <th class="column-title">UBICAR</th>
                            <th class="column-title">Cargos</th>
                            <th class="column-title">Seg.Desg.</th>
                            <th class="column-title">Cuota </th>
                            <th class="column-title">Saldo </th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            /*****************************************************************************************
                            TIPO DE INTERÉS NOMINAL ANUAL
                            In = i/n
                            donde:
                                  n -> número de periodos en el que se ha dividido el año para realizar los pagos
                                  i -> interés

                            TIPO DE INTERÉS EFECTIVO
                            In = ((1+i)^(1/n))-1
                            donde:
                                  n -> número de periodos en el que se ha dividido el año para realizar los pagos
                                  i -> interés
                            ******************************************************************************************/
                            $n = $operations->payment_term;               // Número de periodos
                            $i = $operations->annual_interest_rate/100;   // Interés
                            $a1 = $i/$n;                                  // Tipo de interés nominal anual
                            $a2 = ((1+$i)**(1/$n))-1;                    // Tipo de interés efectivo
                            $b1 = $operations->monthly_term*$operations->payment_term;  // Número de pagos total del préstamo
                            $c1 = $operations->amount+$ubicar+$seguro;                  // Monto total del préstamo
                            $cx = $operations->amount;

                            $cuota = ($a1*(1+$a1)**$b1)*$c1/(((1+$a1)**$b1)-1);
                            //$cuota = ($a2*(1+$a2)**$b1)*$c1/(((1+$a2)**$b1)-1);
                            $cuotx = ($a1*(1+$a1)**$b1)*$cx/(((1+$a1)**$b1)-1);
                            //$cuotx = ($a2*(1+$a2)**$b1)*$cx/(((1+$a2)**$b1)-1);

                            $plazo = $operations->monthly_term*$operations->payment_term;
                            $saldo = $operations->amount+$ubicar+$seguro;
                            $vence  = date('Y-m-d', strtotime($operations->application_date));
                            if($operations->service_1 != null || $operations->service_2 != null){
                                $cuota_seguro = ($cuota-$cuotx)*(($seguro)/($ubicar+$seguro));
                                $cuota_ubicar = ($cuota-$cuotx)*(($ubicar)/($ubicar+$seguro));
                            }else{
                                $cuota_seguro = 0;
                                $cuota_ubicar = 0;
                            }

                            for ($x = 0; $x <= $plazo; $x++) {
                                $interes = $a1*$saldo;
                                //$interes = $a2*$saldo;
                                $capital = $cuota-$interes;
                                if ($x==0){
                                    echo '<tr><td>'.$x.'</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'.number_format($saldo, 2, '.', ',').'</td></tr>';
                                    $seguro_desgravamen = $saldo*($operations->disgrace_insurance_rate/100)*(360/$operations->payment_term/30);
                                } else {
                                    echo '<tr>';
                                    echo '<td>'.$x.'</td>';
                                    echo '<td>'.$vence.'</td>';
                                    echo '<td>'.number_format($cuota, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($interes, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($capital, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($cuota_seguro, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($cuota_ubicar, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($cargos, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($seguro_desgravamen, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($cuota+$cargos+$seguro_desgravamen, 2, '.', ',').'</td>';
                                    echo '<td>'.number_format($saldo-$capital, 2, '.', ',').'</td>';
                                    echo '</tr>';
                                    $saldo = $saldo-$capital;
                                    $seguro_desgravamen = $saldo*($operations->disgrace_insurance_rate/100)*(360/$operations->payment_term/30);
                                    for ($y = 1; $y <= 12/$operations->payment_term; $y++) {
                                      $num = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($vence)), date('Y', strtotime($vence)));
                                      $vence = date('Y-m-d', strtotime($vence.'+'.$num.' day'));
                                    }
                                }

                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                    {!! Form::submit('Generar', ['class'=>'btn btn-success']) !!}
                </div>
            </div>
            </form>
            <!--/form-->
        </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Credit Portfolio Manager by <a href="https://www.paperplane.com.bo">PaperPlane</a>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

@endsection
