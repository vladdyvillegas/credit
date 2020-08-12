@extends('layouts.blank')

@section('title', 'Rescisión')

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
                    <h3>Rescisión <small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <!--form-->
            <form id="payment_plan" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('apply_rescission_prev', $operation->id) }}" method="post">
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
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Cliente</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('client_name', $operation->client->name, ['id'=>'client_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Producto</label>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                {{ Form::text('product_name', $operation->product->name, ['id'=>'product_name', 'class'=>'form-control input-sm', 'readonly'=>'readonly']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Fecha de rescisión</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('rescission_date', date("Y-m-d"), ['id'=>'rescission_date', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Total pagado</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('rescission_payments', number_format(($rescission_payments), 2, '.', ''), ['id'=>'next_variable_fee', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Descuento por uso</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::number('rescission_discount', 0, ['id'=>'rescission_discount', 'step'=>'any', 'min'=>'0', 'max'=>$rescission_payments, 'class'=>'form-control']) }}
                                {{ Form::hidden('rescission_fee', $rescission_fee, ['id'=>'rescission_fee', 'class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                    {!! Form::button('Volver', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                    {!! Form::submit('Aplicar Rescisión', ['id'=>'apply_rescission', 'name'=>'apply_rescission', 'class'=>'btn btn-success']) !!}
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
    $('#rescission_date').Zebra_DatePicker({
        show_select_today: false,
        show_clear_date: false,
        format: 'Y-m-d',
        view: 'days',
        days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],

    });
</script>
@endpush
