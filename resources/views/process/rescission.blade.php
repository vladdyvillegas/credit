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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($operations as $operation)
                                <?php
                                    $amount = $operation->amount+$operation->service_1+$operation->service_2;
                                ?>
                                    <tr>
                                        <td><a href="{{ url('operation_plan', $operation->id) }}" class="btn btn-success btn-xs"><i class="fa fa-eye"> </i> {{ $operation->operation }} </a></td>
                                        <td>{{ $operation->client->name }}</td>
                                        <td>{{ number_format($amount, 2, '.', ',') }}</td>
                                        <td>
                                            @if($operation->application_date!=null)
                                                @if($operation->status=="PPG")
                                                    @if($operation->last_balance>0)
                                                        <a href="{{ url('apply_rescission', $operation->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-anchor"></i> Rescindir</a>
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
