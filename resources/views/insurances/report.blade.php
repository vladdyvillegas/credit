@extends('layouts.blank')

@section('title', 'Informe Seguro Automotor')

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
                    <h3>Informe Seguro Automotor<small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="insurance_expired" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('insurance_expired') }}">
            {{-- <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="form-group">
                            <br />
                            <label class="control-label col-md-1 col-sm-3 col-xs-3">Hasta</label>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {{ Form::text('date_report', $date_report, ['id'=>'date_report', 'class'=>'form-control', 'required'=>'required']) }}
                            </div>
                            <div class="col-md-2 col-sm-9 col-xs-12">
                                {!! Form::submit('Generar', ['id'=>'send_date', 'name'=>'send_date', 'class'=>'btn btn-success']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Operaiones<small>Lista de operaciones de crédito</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-share"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../pdf_report_insurance/{{ $type }}" target="_blank">Exportar a PDF</a>
                                        </li>
                                        <li><a href="#">Exportar a Excel</a>
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
                                    <th>Seguro Automotor</th>
                                    <th>Pagado 2018</th>
                                    <th>Total Pagado</th>
                                    <th>Vencido 2018</th>
                                    <th>Fecha vencimiento</th>
                                    <th>Gestión 2018</th>
                                    <th>Gestión 2019</th>
                                    <th>Gestión 2020</th>
                                    <th>Total Saldo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($insurances as $insurance)
                                    <tr>
                                        <td><a href="{{ url('insurance_register', $insurance->operation_id) }}"
                                            @if($insurance->paid!=0)
                                                class="btn btn-success btn-xs"
                                            @elseif ($insurance->expired==0)
                                                class="btn btn-info btn-xs"
                                            @else
                                                class="btn btn-danger btn-xs"
                                            @endif>
                                            <i class="fa fa-eye"> </i> {{ $insurance->operation }} </a></td>
                                        <td>{{ $insurance->name }}</td>
                                        <td>{{ number_format($insurance->service_2, 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->paid, 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->service_2-($insurance->expired+$insurance->year1+$insurance->year2+$insurance->year3), 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->expired, 2, '.', ',') }}</td>
                                        <td>{{ $insurance->expired_date }}</td>
                                        <td>{{ number_format($insurance->year1, 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->year2, 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->year3, 2, '.', ',') }}</td>
                                        <td>{{ number_format($insurance->expired+$insurance->year1+$insurance->year2+$insurance->year3, 2, '.', ',') }}</td>

                                        {{-- <td>
                                            @if ($insurance->payment_date <= date('Y-m-d'))
                                                @if ($insurance->status == 'PAGADO')
                                                    <a href="insurance_register/{{ $insurance->operation_id }}" class="btn btn-success btn-xs"><i class="fa fa-anchor"></i> Pagado</a>
                                                @else
                                                    <a href="insurance_register/{{ $insurance->operation_id }}" class="btn btn-danger btn-xs"><i class="fa fa-anchor"></i> Vencido</a>
                                                @endif
                                            @elseif ($insurance->status == 'VIGENTE')
                                                <a href="insurance_register/{{ $insurance->operation_id }}" class="btn btn-info btn-xs"><i class="fa fa-anchor"></i> Vigente</a>
                                            @endif
                                        </td> --}}
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
        $('#date_report').Zebra_DatePicker({
            show_select_today: false,
            show_clear_date: false,
            format: 'Y-m-d',
            view: 'days',
            days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
        });
    </script>
@endpush
