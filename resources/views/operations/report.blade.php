@extends('layouts.blank')

@section('title', 'Informe de operaciones')

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
                    <h3>Operaciones de crédito <small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="operation_active" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('operation_report', $type) }}">
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
                                        <li><a href="../pdf_report/{{ $type }}/{{ $date_report }}" target="_blank">Exportar a PDF</a>
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
                                    <th>Primer pago</th>
                                    <th>Último pago</th>
                                    <th>Monto crédito</th>
                                    <th>Capital</th>
                                    <th>Interés</th>
                                    <th>Mora</th>
                                    <th>UBICAR</th>
                                    <th>Seguro</th>
                                    <th>Cargos</th>
                                    <th>Seguro Desgrav.</th>
                                    <th>Saldo</th>
                                    <th>Cuotas mora</th>
                                    <th>Plan de cuotas</th>
                                    <th>Plan de pagos</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                  @if($payment->request_date<=$date_report)
                                    <tr>
                                      <td><a href="{{ url('operation_plan', $payment->operation_id) }}" class="btn btn-success btn-xs">{{ $payment->operation }}</a></td>
                                      <td>{{ $payment->name }} @if($payment->status=='LIT') (EN LITIGIO) @endif</td>
                                      <td>{{ $payment->application_date }}</td>
                                      <td>{{ $payment->payment_date }}</td>
                                      @if($payment->status=='REC')
                                          <td>RECUPERADO POR MORA</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                      @elseif($payment->status=='RES')
                                          <td>RESCINDIDO POR MUTUO ACUERDO</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                      @else
                                          <td>{{ number_format($payment->amount+$payment->service_1+$payment->service_2, 2, '.', ',') }}</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->capital+$payment->amortization_fee, 2, '.', ',') }} @else {{ number_format(0, 2, '.', ',') }} @endif </td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->interest, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->interest_late, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->ubicar, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->assure, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->charges, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->disgrace, 2, '.', ',') }}  @else {{ number_format(0, 2, '.', ',') }} @endif</td>
                                          <td>@if($payment->last_payment_date<>'') {{ number_format($payment->balance, 2, '.', ',') }}  @else {{ number_format($payment->amount+$payment->service_1+$payment->service_2, 2, '.', ',') }} @endif</td>
                                          <td>
                                            <?php
                                                $delayed = 0;
                                                if($payment->payment_date<>null){
                                                     $expiration = date('Y-m-d', strtotime($payment->expiration_date));
                                                } else {
                                                     $expiration = date('Y-m-d', strtotime($date_report));
                                                }
                                                while ($expiration <= $date_report) {
                                                   for ($y = 1; $y <= 12/$payment->payment_term; $y++) {
                                                     $num = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($expiration)), date('Y', strtotime($expiration)));
                                                     $expiration = date('Y-m-d', strtotime($expiration.'+'.$num.' day'));
                                                   }
                                                   $delayed++;
                                                }
                                                if ($payment->balance==0 or $delayed<=0) {
                                                    echo 0;
                                                } else {
                                                    if (($payment->total_payment-$payment->payment)>($delayed-1)) {
                                                        if ($payment->next_payment > $payment->payment) {
                                                            echo $delayed-1;
                                                        } else {
                                                            echo $delayed;
                                                        }
                                                    } else {
                                                       echo $payment->total_payment-$payment->payment;
                                                    }
                                                }
                                            ?>
                                          </td>
                                      @endif
                                      <td>@if($payment->next_payment<>'') {{ $payment->next_payment-1 }} / {{ $payment->total_payment }} @else {{ $payment->total_payment }} / {{ $payment->total_payment }} @endif </td>
                                      <td>
                                        <?php
                                          switch ($payment->payment_term) {
                                            case 12:  echo "MENSUAL"; break;
                                            case 6:   echo "BIMESTRAL"; break;
                                            case 4:   echo "TRIMESTRAL"; break;
                                            case 2:   echo "SEMESTRAL"; break;
                                            case 1:   echo "ANUAL"; break;
                                          }
                                        ?>
                                      </td>
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
