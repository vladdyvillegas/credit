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
                $ubicar = $operation->service_1;  // Costo anual por el servicio de localización
                $seguro = $operation->service_2;  // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
                $cargos = 2;    // Costo mensual por gastos administrativos
                if($operation->service_1 == null && $operation->service_2 == null){
                    $ubicar = 0;
                    $seguro = 0;
                }
            ?>
            <!--form-->
            <form id="payment_plan" data-parsley-validate class="form-horizontal form-label-left input_mask">
            {{ csrf_field() }}
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-share"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../pdf_plan/{{ $operation->id }}" target="_blank">Exportar a PDF</a>
                                        </li>
                                        <li><a href="#">Exportar a Excel</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <br />
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Número de operación </label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('operation', $operation->operation, ['id'=>'operation', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Fecha de aplicación</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('application_date', $operation->application_date, ['id'=>'application_date', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Cliente</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('client_name', $operation->client->name, ['id'=>'client_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">{{ $operation->client->type_id_document }}</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('client_id_document', $operation->client->id_document, ['id'=>'client_id_document', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Producto</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('product_name', $operation->product->name, ['id'=>'product_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Matrícula</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('car_registration', $operation->car_registration, ['id'=>'car_registration', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Interés anual (%)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('annual_interest_rate', $operation->annual_interest_rate, ['id'=>'annual_interest_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Plazo (meses)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('term', $operation->monthly_term*$operation->payment_term, ['id'=>'term', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Frecuencia (días)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('periodicity', 360/$operation->payment_term, ['id'=>'periodicity', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Precio producto</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('product_price', number_format($operation->product_price, 2, '.', ','), ['id'=>'product_price', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">Aporte</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('own_input',number_format($operation->own_input, 2, '.', ','), ['id'=>'own_input', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Saldo a financiar</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('amount',number_format($operation->amount, 2, '.', ','), ['id'=>'amount', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        @if($operation->service_1 != null || $operation->service_2 != null)
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
                              {{ Form::text('disgrace_insurance_rate', number_format($operation->disgrace_insurance_rate, 2, '.', ','), ['id'=>'disgrace_insurance_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                          </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Total a financiar</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('capital',number_format($operation->amount+$ubicar+$seguro, 2, '.', ','), ['id'=>'capital', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
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
                            <th class="column-title"></th>
                            <th class="column-title"># </th>
                            <th class="column-title">Vencimiento </th>
                            <th class="column-title">Fecha pago </th>
                            <th class="column-title">PPP </th>
                            <th class="column-title">Capital </th>
                            <th class="column-title">Cap.Amort. </th>
                            <th class="column-title">Interés </th>
                            <th class="column-title">Int.Mora</th>
                            <th class="column-title">Int.Acum</th>
                            {{-- <th class="column-title">UBICAR</th>
                            <th class="column-title">Seguro</th> --}}
                            <th class="column-title">Cargos </th>
                            <th class="column-title">Seg.Desg. </th>
                            <th class="column-title">Cuota </th>
                            <th class="column-title">Saldo </th>
                            <th class="column-title">Comprobante </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $sum_fixed_fee = 0;
                            $sum_capital = 0;
                            $sum_amortization_fee = 0;
                            $sum_interest = 0;
                            $sum_interest_late = 0;
                            $sum_interest_accrued = 0;
                            $sum_ubicar = 0;
                            $sum_assure = 0;
                            $sum_charges = 0;
                            $sum_disgrace = 0;
                            $sum_variable_fee = 0;
                            $sum_balance = 0;
                        ?>
                        <tr><td></td><td>0</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>{{--<td></td><td></td>--}}<td></td><td></td><td>{{ number_format($operation->amount+$ubicar+$seguro, 2, '.', ',') }}</td><td></td></tr>
                        @foreach($payments as $payment)
                          <tr>
                            <td>
                                @if($payment->payment_date!==null)
                                    <?php $interest_late = 0; ?>
                                    <span class="label label-success"><i class="fa fa-check"></i></span>
                                @else
                                    <?php $days_late = (strtotime(date('Y-m-d'))-strtotime($payment->expiration_date))/86400; ?>
                                    @if($days_late>0)
                                        <?php
                                            $balance = $operation->last_balance;
                                            $interest_late = $balance*($days_late/360)*($operation->delayed_interest_rate/100);
                                        ?>
                                        <span class="label label-danger"><i class="fa fa-bell"></i></span>
                                    @else
                                        <?php $interest_late = 0; ?>
                                        <span class="label label-info"><i class="fa fa-hourglass"></i></span>
                                    @endif
                                @endif
                                @if($payment->payment==$operation->next_payment and $operation->last_balance!=0)
                                    <a href="{{ url('operation_amort', $operation->id) }}" class="label label-warning"><i class="fa fa-anchor"></i></a>
                                @endif
                            </td>
                            <td>{{ $payment->payment }}</td>
                            <td>{{ $payment->expiration_date }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>{{ number_format($payment->fixed_fee, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->capital, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->amortization_fee, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->interest, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->interest_late+$interest_late, 2, '.', ',') }} </td>
                            <td>{{ number_format($payment->interest_accrued, 2, '.', ',') }} @if($payment->interest_accrued>0) <a href="{{ url('operation_amort_mora', $payment->id) }}" class="label label-danger"><i class="fa fa-anchor"></i></a> @endif</td>
                            {{-- <td>{{ number_format($payment->ubicar, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->assure, 2, '.', ',') }}</td> --}}
                            <td>{{ number_format($payment->charges, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->disgrace, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->variable_fee+$interest_late, 2, '.', ',') }}</td>
                            <td>{{ number_format($payment->balance, 2, '.', ',') }}</td>
                            <td>{{ $payment->voucher_number }}</td>
                          </tr>
                          <?php
                              $sum_fixed_fee = $sum_fixed_fee + $payment->fixed_fee;
                              $sum_capital = $sum_capital + $payment->capital;
                              $sum_amortization_fee = $sum_amortization_fee + $payment->amortization_fee;
                              $sum_interest = $sum_interest + $payment->interest;
                              $sum_interest_late = $sum_interest_late + $payment->interest_late+$interest_late;
                              $sum_interest_accrued = $sum_interest_accrued + $payment->interest_accrued;
                              $sum_ubicar = $sum_ubicar + $payment->ubicar;
                              $sum_assure = $sum_assure + $payment->assure;
                              $sum_charges = $sum_charges + $payment->charges;
                              $sum_disgrace = $sum_disgrace + $payment->disgrace;
                              $sum_variable_fee = $sum_variable_fee + $payment->variable_fee;
                              $sum_balance = $sum_balance + $payment->balance;
                          ?>
                        @endforeach
                        <tr class="headings">
                          <td colspan="4"><strong>TOTAL</strong></td>
                          <td><strong>{{ number_format($sum_fixed_fee, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_capital, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_amortization_fee, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_interest, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_interest_late, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_interest_accrued, 2, '.', ',') }}</strong></td>
                          {{-- <td><strong>{{ number_format($sum_ubicar, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_assure, 2, '.', ',') }}</strong></td> --}}
                          <td><strong>{{ number_format($sum_charges, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_disgrace, 2, '.', ',') }}</strong></td>
                          <td><strong>{{ number_format($sum_variable_fee, 2, '.', ',') }}</strong></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                  </table>
                </div>
            </div>
            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-6">
                    {!! Form::button('Volver', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
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
