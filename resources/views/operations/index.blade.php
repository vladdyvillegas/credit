@extends('layouts.blank')

@section('title', 'Listado de operaciones')

@push('stylesheets')
    <!-- Datatables -->
    <link href="{{ asset("datatables.net-bs/css/dataTables.bootstrap.min.css") }}" rel="stylesheet">
@endpush

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Operaciones de crédito <small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Operaiones<small>Lista de operaciones de crédito</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-plus-square"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="operation_create/PROPIO">Cartera propia</a>
                                        </li>
                                        <li><a href="operation_create/FINANCIAL">Financial</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Operación</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Matrícula</th>
                                    <th>Servicios</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($operations as $operation)
                                <?php
                                    //$ubicar = 230;  // Costo anual por el servicio de localización
                                    //$seguro_rate = 0.03; // Prcentaje sobre el valor del producto para calcular el costo anual del seguro automotor
                                    //$cargos = 2;    // Costo mensual por gastos administrativos
                                    // if($operation->service_1 == null && $operation->service_2 == null){
                                    //     $ubicar = 0;
                                    //     $seguro_rate = 0;
                                    // }
                                    $amount = $operation->amount+$operation->service_1+$operation->service_2;
                                ?>
                                    <tr>
                                        <!-- <td>{{ $operation->operation }}</td> -->
                                        <td><a href="{{ url('operation_plan', $operation->id) }}" class="btn btn-success btn-xs"><i class="fa fa-eye"> </i> {{ $operation->operation }} </a></td>
                                        <td>{{ $operation->client->name }}</td>
                                        <td>{{ number_format($amount, 2, '.', ',') }}</td>
                                        <td>
                                            @if($operation->application_date!=null)
                                                @if($operation->status=="PPG")
                                                    @if($operation->last_balance>0)
                                                        <a href="{{ url('operation_amort', $operation->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-anchor"></i> Amorizar</a>
                                                    @else
                                                        <span class="label label-info">Liquidado</span>
                                                    @endif
                                                @elseif($operation->status=="LIQ")
                                                    <span class="label label-info">Liquidado</span>
                                                @elseif($operation->status=="REC")
                                                    <span class="label label-danger">Recuperado por mora</span>
                                                @elseif($operation->status=="RES")
                                                    <span class="label label-danger">Rescindido por mutuo acuerdo</span>
                                                @else
                                                    <a href="{{ url('operation_plan_generate', $operation->id) }}" class="btn btn-success btn-xs"><i class="fa fa-sign-in"> </i> Generar PP </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $operation->car_registration }}</td>
                                        <td>
                                            @if($operation->service_1 != null)
                                                <a href="#" class="btn btn-link btn-xs"><i class="fa fa-map-pin"></i> {{ number_format($operation->service_1, 2, '.', ',') }}</a>
                                            @endif
                                            @if($operation->service_2 != null)
                                                <a href="insurance_register/{{ $operation->id }}" class="btn btn-link btn-xs"><i class="fa fa-car"></i> {{ number_format($operation->service_2, 2, '.', ',') }}</a>
                                            @endif
                                        </td>
                                        <td>
                                          @if($operation->status == null)
                                            <a href="{{ url('operation_show', $operation->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>  </a>
                                            <a href="{{ url('operation_edit', $operation->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>  </a>
                                            <a href="{{ url('operation_delete', $operation->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>  </a>&nbsp;
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
@endpush
