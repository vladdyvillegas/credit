@extends('layouts.blank')

@section('title', 'Eliminacion de operaciones')

@push('stylesheets')
<!-- Select2 -->
<link href="{{ asset("select2/dist/css/select2.min.css") }}" rel="stylesheet">
<!-- Datapicker -->
<link href="{{ asset("css/datepicker-metallic.css") }}" rel="stylesheet">
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Operaciones <small>@if ($delete == "YES") Eliminación de operaciones de crédito @else Visualización de operaciones de crédito @endif</small></h3>
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
            <form id="operation_delete" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_destroy', $operations->id) }}">
              <div cass="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                          <div class="form-group">
                              <br />
                              <label class="control-label col-md-2 col-sm-3 col-xs-3">Número de operación </label>
                              <div class="col-md-2 col-sm-9 col-xs-12">
                                  {{ Form::text('operation', $operations->operation, ['id'=>'operation', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                              </div>
                              <label class="control-label col-md-2 col-sm-3 col-xs-12" for="type">Concesionario </label>
                              <div class="col-md-3 col-sm-9 col-xs-12">
                                  {{ Form::text('dealer', $operations->dealer->dealer, ['id'=>'dealer', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
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
                              <label class="control-label col-md-1 col-sm-3 col-xs-3">Matrícula</label>
                              <div class="col-md-2 col-sm-9 col-xs-12">
                                  {{ Form::text('car_registration', $operations->car_registration, ['id'=>'car_registration', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
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
                @if ($delete == "YES")
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                    {!! Form::submit('Borrar', ['class'=>'btn btn-success']) !!}
                </div>
                @else
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                </div>
                @endif
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
<!-- Select2 -->
<script src="{{ asset("select2/dist/js/select2.full.min.js") }}"></script>
<!-- Datapicker -->
<script src="{{ asset("js/zebra_datepicker.js") }}"></script>
@endpush
