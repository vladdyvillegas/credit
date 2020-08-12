@extends('layouts.blank')

@section('title', 'Edición de clientes')

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
                    <h3>Administración <small>Edición de clientes</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="client_edit" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('client_update', $clients->id) }}">
            <div cass="row">
                @if ($legal_pers == 'NATURAL')
                    @include('clients.partials.editNatural')
                @elseif ($legal_pers == 'JURIDICA')
                    @include('clients.partials.editJuridica')
                @endif
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                            {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                            {!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
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
<!-- Datapicker -->
<script src="{{ asset("js/zebra_datepicker.js") }}"></script>
<script>
    $('#birthdate').Zebra_DatePicker({
        show_select_today: false,
        show_clear_date: false,
        format: 'd-m-Y',
        view: 'days',
        days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
    });
</script>
@endpush
