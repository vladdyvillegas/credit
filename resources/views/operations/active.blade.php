@extends('layouts.blank')

@section('title', 'Vencimiento de operaciones')

@push('stylesheets')
    <!-- Datatables -->
    <link href="{{ asset("datatables.net-bs/css/dataTables.bootstrap.min.css") }}" rel="stylesheet">
    <!-- Datapicker -->
    <link href="{{ asset("css/datepicker-metallic.css") }}" rel="stylesheet">
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Operaciones vencidas o por vencer<small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="operation_active" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_expired') }}">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <br />
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">Desde</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('date_start', $date_start, ['id'=>'date_start', 'class'=>'form-control', 'readonly'=>'readonly']) }}
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">Hasta</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('date_end', $date_end, ['id'=>'date_end', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {!! Form::submit('Enviar', ['id'=>'send_date', 'name'=>'send_date', 'class'=>'btn btn-success']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Operación</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>N° Cuota</th>
                                    <th>Cuota</th>
                                    <th>Saldo</th>
                                    <th>Fecha pago</th>
                                    <th>Contactos</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($operations as $operation)
                                <?php
                                    $ubicar = 230;  // Costo anual por el servicio de localización
                                    $seguro_rate = 0.03; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
                                    //$cargos = 2;    // Costo mensual por gastos administrativos
                                    if($operation->service_1 == null && $operation->service_2 == null){
                                        $ubicar = 0;
                                        $seguro_rate = 0;
                                    }
                                    $amount = $operation->amount+$ubicar+$operation->product_price*$seguro_rate;
                                ?>
                                    <tr>
                                        <td>
                                            @if($operation->next_payment_date<date('Y-m-d'))
                                              <span class="label label-danger"><i class="fa fa-bell"></i></span>
                                            @else
                                              <span class="label label-info"><i class="fa fa-hourglass"></i></span>
                                            @endif
                                            {{ $operation->operation }}
                                        </td>
                                        <td>{{ $operation->client->name }}</td>
                                        <td>{{ number_format($amount, 2, '.', ',') }}</td>
                                        <td>{{ $operation->next_payment }} / {{ $operation->monthly_term*$operation->payment_term }}</td>
                                        <td>{{ number_format($operation->next_variable_fee, 2, '.', ',') }}</td>
                                        <td>{{ number_format($operation->last_balance, 2, '.', ',') }}</td>
                                        <td>{{ $operation->next_payment_date }}</td>
                                        <td>{{ $operation->client->mobile_phone }}<br />{{ $operation->client->phone }}<br />{{ $operation->client->email }}</td>
                                        <td>
                                            @if($operation->application_date!=null)
                                                @if($operation->status=="PPG")
                                                    <a href="{{ url('operation_plan', $operation->id) }}" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Ver </a><br />
                                                    <a href="{{ url('operation_amort', $operation->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-anchor"></i> Amorizar</a>
                                                @else
                                                    <a href="{{ url('operation_plan_generate', $operation->id) }}" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Generar PP </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    <!-- Datatables -->
    <script src="{{ asset("datatables.net/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("datatables.net-bs/js/dataTables.bootstrap.min.js") }}"></script>
    <!-- Datapicker -->
    <script src="{{ asset("js/zebra_datepicker.js") }}"></script>
    <script>
        $('#date_start').Zebra_DatePicker({
            show_select_today: false,
            show_clear_date: false,
            format: 'Y-m-d',
            view: 'days',
            days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            pair: $('#date_end')
        });
        $('#date_end').Zebra_DatePicker({
            show_select_today: false,
            show_clear_date: false,
            format: 'Y-m-d',
            view: 'days',
            days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            direction: 1
        });
    </script>
@endpush
