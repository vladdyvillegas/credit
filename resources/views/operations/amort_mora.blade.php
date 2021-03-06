@extends('layouts.blank')

@section('title', 'Pago de mora acumulada')

@push('stylesheets')
<!-- Datapicker -->
<link href="{{ asset("css/datepicker-metallic.css") }}" rel="stylesheet">
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Operaciones <small>Pago de mora acumulada</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
                $ubicar = $operation->service_1;  // Costo anual por el servicio de localización
                $seguro = $operation->service_2; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
                $cargos = 2;    // Costo mensual por gastos administrativos
                if($operation->service_1 == null && $operation->service_2 == null){
                    $ubicar = 0;
                    $seguro = 0;
                }
                $term = $operation->monthly_term*$operation->payment_term;
                $frequency = 360/$operation->payment_term;

                $days_late = (strtotime(date('Y-m-d'))-strtotime($operation->next_payment_date))/86400;
                $interest_late = $operation->last_balance*($days_late/360)*($operation->delayed_interest_rate/100);
                if ($days_late < 0) {
                  $days_late = 0;
                  $interest_late = 0;
                }
            ?>
            <!--form-->
            <form id="payment_mora" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_amort_mora_pay', $payment->id) }}" method="post">
            {{ csrf_field() }}
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <br />
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Número de operación </label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('operation', $operation->operation, ['id'=>'operation', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Fecha de aplicación</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('application_date', date('Y-m-d', strtotime($operation->application_date)), ['id'=>'application_date', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
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
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Interés anual (%)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('annual_interest_rate', $operation->annual_interest_rate, ['id'=>'annual_interest_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Interés anual por mora (%)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('delayed_interest_rate', $operation->delayed_interest_rate, ['id'=>'delayed_interest_rate', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Monto financiado</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('amount', number_format($operation->amount+$ubicar+$seguro, 2, '.', ','), ['id'=>'amount', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Plazo (meses)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('term', $term, ['id'=>'term', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Frecuencia (días)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('frequency', $frequency, ['id'=>'frequency', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">N° Cuota de la mora</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::text('payment', $payment->payment, ['id'=>'payment', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Monto mora acumulada</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('interest_accrued', number_format($payment->interest_accrued, 2, '.', ','), ['id'=>'interest_accrued', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                            <?php
                                if (date("Y", strtotime($payment->payment_date))>=$open_gestion) {
                            ?>
                                <label class="control-label col-md-2 col-sm-3 col-xs-3">Monto a pagar</label>
                                <div class="col-md-2 col-sm-9 col-xs-12">
                                    {{ Form::number('interest_late', 0, ['id'=>'interest_late', 'step'=>'any', 'min'=>'0', 'class'=>'form-control']) }}
                                </div>
                            <?php
                                }
                            ?>
                        </div>

                    </div>
                </div>
                <?php
                    if (date("Y", strtotime($payment->payment_date))<$open_gestion) {
                ?>
                      {{ Form::hidden('gestion_pass', '1', array('id' => 'gestion_pass')) }}
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                              <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Fecha de pago</label>
                                  <div class="col-md-2 col-sm-9 col-xs-12">
                                      {{ Form::text('accrued_past_payment_date', date("Y-m-d"), ['id'=>'accrued_past_payment_date', 'class'=>'form-control', 'required'=>'required']) }}
                                  </div>
                                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Monto a pagar</label>
                                  <div class="col-md-2 col-sm-9 col-xs-12">
                                      {{ Form::number('interest_accrued_past', 0, ['id'=>'interest_accrued_past', 'step'=>'any', 'min'=>'0', 'class'=>'form-control']) }}
                                  </div>
                                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Nro. comprobante</label>
                                  <div class="col-md-2 col-sm-9 col-xs-12">
                                      {{ Form::text('accrued_past_voucher', 0, ['id'=>'accrued_past_voucher', 'class'=>'form-control']) }}
                                  </div>
                              </div>
                          </div>
                      </div>
                <?php
                    }
                ?>
            </div>
            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    {!! Form::button('Volver', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                    {!! Form::submit('Pagar', ['id'=>'pagar', 'name'=>'pagar', 'class'=>'btn btn-success']) !!}
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

@push('scripts')
<!-- Datapicker -->
<script src="{{ asset("js/zebra_datepicker.js") }}"></script>
<script>
    $('#accrued_past_payment_date').Zebra_DatePicker({
        show_select_today: false,
        show_clear_date: false,
        format: 'Y-m-d',
        view: 'days',
        days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        //direction: ['{{ $operation->application_date }}', false],
        onSelect: function() {
          var d1 = new Date($('#amort_date').val());
          var d2 = new Date($('#next_payment_date').val());
          var time = d1.getTime() - d2.getTime();
          var dias = Math.floor(time / (1000 * 60 * 60 * 24));
          if (dias < 0) {
            $('#days_late').val(0);
          } else {
            $('#days_late').val(dias);
          }
        }
    });
</script>
@endpush
