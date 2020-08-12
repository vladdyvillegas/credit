@extends('layouts.blank')

@section('title', 'Edición de operaciones')

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
                    <h3>Operaciones <small>Creación de operaciones de crédito</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="operation_edit" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_update', $operations->id) }}">
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <br />
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Número de operación </label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('operation', $operations->operation, ['id'=>'operation', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="type">Concesionario </label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <select id="dealer_id" name="dealer_id" class="form-control" required="required">
                                    <option></option>
                                    @foreach($dealers as $dealer)
                                        <option value="{{$dealer->id}}" @if($operations->dealer_id == $dealer->id) selected @endif>{{$dealer->dealer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Fecha solicitud</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('request_date', $operations->request_date, ['id'=>'request_date', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Fecha 1ra. cuota</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('application_date', $operations->application_date, ['id'=>'application_date', 'class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Nombre</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                <select id="client_id" name="client_id" class="form-control" required="required">
                                    <option></option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" @if($operations->client_id == $client->id) selected @endif>{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Producto</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                <select id="product_id" name="product_id" class="form-control input-sm" required="required">
                                    <option></option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" @if($operations->product_id == $product->id) selected @endif>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Matrícula</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('car_registration', $operations->car_registration, ['id'=>'car_registration', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Monto solicitado ($USD)</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('amount', number_format($operations->amount, 2, '.', ',') , ['id'=>'amount', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Valor Producto ($USD)</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('product_price', $operations->product_price, ['id'=>'product_price', 'step'=>'any', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Aporte propio ($USD)</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('own_input', $operations->own_input, ['id'=>'own_input', 'step'=>'any', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Interés anual (%)</label>
                            <div class="col-md-1 col-sm-9 col-xs-12">
                                {{ Form::number('annual_interest_rate', $operations->annual_interest_rate, ['id'=>'annual_interest_rate', 'step'=>'any', 'class'=>'form-control', 'required'=>'required', 'min'=>'1', 'max'=>'100']) }}
                            </div>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Interés anual por mora (%)</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('delayed_interest_rate', $operations->delayed_interest_rate, ['id'=>'delayed_interest_rate', 'step'=>'any', 'class'=>'form-control', 'required'=>'required', 'min'=>'1', 'max'=>'100']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">Seg. Desgravamen</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                              <select id="disgrace_insurance_rate" name="disgrace_insurance_rate" class="form-control input-sm" required="required">
                                  <option value="0" @if($operations->disgrace_insurance_rate == "0") selected @endif>Sin seguro</option>
                                  <option value="0.05" @if($operations->disgrace_insurance_rate == "0.05") selected @endif>1 persona</option>
                                  <option value="0.08" @if($operations->disgrace_insurance_rate == "0.08") selected @endif>2 personas</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Plazo </label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <select id="monthly_term" name="monthly_term" class="form-control input-sm" required="required">
                                    <option value="1" @if($operations->monthly_term == "1") selected @endif>1 AÑO</option>
                                    <option value="2" @if($operations->monthly_term == "2") selected @endif>2 AÑOS</option>
                                    <option value="3" @if($operations->monthly_term == "3") selected @endif>3 AÑOS</option>
                                </select>
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Servicio de la deuda </label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <select id="payment_term" name="payment_term" class="form-control input-sm" required="required">
                                    <option value="12" @if($operations->payment_term == "12") selected @endif>Mensual</option>
                                    <option value="6" @if($operations->payment_term == "6") selected @endif>Bimestral</option>
                                    <option value="4" @if($operations->payment_term == "4") selected @endif>Trimestral</option>
                                    <option value="2" @if($operations->payment_term == "2") selected @endif>Semestral</option>
                                    <option value="1" @if($operations->payment_term == "1") selected @endif>Anual</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Servicios adicionales</label>
                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">UBICAR</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('service_1', $operations->service_1, ['id'=>'service_1', 'step'=>'any', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">SEGURO AUTOMOTOR</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('service_2', $operations->service_2, ['id'=>'service_2', 'step'=>'any', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                    {!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
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
<!-- Select2 -->
<script src="{{ asset("select2/dist/js/select2.full.min.js") }}"></script>
<!-- Datapicker -->
<script src="{{ asset("js/zebra_datepicker.js") }}"></script>
<script>
    $(document).ready(function(){
        $("#client_id").select2({
            placeholder:    "Seleccione un cliente"
        });
    });
</script>
<script>
    $(document).ready(function(){
        $("#product_id").select2({
            placeholder:    "Seleccione un producto"
        });
    });
</script>
<script>
    $('#request_date').Zebra_DatePicker({
        show_select_today: false,
        show_clear_date: false,
        format: 'Y-m-d',
        view: 'days',
        days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        pair: $('#application_date')
    });
    $('#application_date').Zebra_DatePicker({
        direction: 1,
        show_select_today: false,
        show_clear_date: false,
        format: 'Y-m-d',
        view: 'days',
        days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
    });
</script>
<script>
    $(document).ready(function(){
        $('#product_id').on('change',function(){
            var formu = $(this);
            $.ajax({
                type:       "GET",
                url :       "../product_find",
                dataType:   "json",
                data :      formu.serialize(),
                success :   function(res) {
                    $("#product_price").val(res.price);
                    $("#amount").val(res.price);
                    $("#own_input").val(0);
                    $("#annual_interest_rate").val(res.annual_interest_rate);
                    $("#delayed_interest_rate").val(res.delayed_interest_rate);
                },
                error : function(xhr, status) {
                    alert(status);
                }

            });
        })
    })
</script>
<script>
    $('#product_price, #own_input').change(function (e) {
        var can1 = $('#product_price').val();
        var can2 = $('#own_input').val();
        var resta = can1 - can2;
        $('#amount').val(resta);
    });
</script>
@endpush
