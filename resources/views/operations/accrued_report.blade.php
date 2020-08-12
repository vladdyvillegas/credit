@extends('layouts.blank')

@section('title', 'Informe de cuotas en mora de gestiones cerradas')

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
                    <h3>Pagos en mora de gestiones cerradas <small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="operation_active" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('accrued_report', $type) }}">
                {{ csrf_field() }}
                <div class="row">
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
                </div>
            </form>
            <!--/form-->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Operaiones<small>Lista de operaciones de crédito</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-share"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../pdf_accrued_report/{{ $type }}/{{ $date_report }}" target="_blank">Exportar a PDF</a>
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
                                    <th>Fec. Vencimiento</th>
                                    <th>Fec. Pago</th>
                                    <th>Monto</th>
                                    <th>Comprobante</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                  @if($payment->accrued_past_payment_date != null)
                                    <tr>
                                      <td><a href="{{ url('operation_plan', $payment->operation_id) }}" class="btn btn-success btn-xs">{{ $payment->operation }}</a></td>
                                      <td>{{ $payment->name }}</td>
                                      <td>{{ $payment->expiration_date }}</td>
                                      <td>{{ $payment->accrued_past_payment_date }}</td>
                                      <td>{{ number_format($payment->interest_accrued_past, 2, '.', ',') }}</td>
                                      <td>{{ $payment->accrued_past_voucher }}</td>
                                    </tr>
                                  @endif
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
