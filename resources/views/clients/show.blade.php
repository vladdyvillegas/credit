@extends('layouts.blank')

@section('title', 'Vista de clientes')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Administración <small>@if ($delete == "YES") Eliminación de clientes @else Visualización de clientes @endif</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="client_delete" data-parsley-validate class="form-horizontal form-label-left" action="{{ url('client_destroy', $clients->id) }}">
                <div cass="row">
                    @if ($legal_pers == 'NATURAL')
                        @include('clients.partials.showNatural')
                    @elseif ($legal_pers == 'JURIDICA')
                        @include('clients.partials.showJuridica')
                    @endif
                    @if ($delete == "YES")
                        <div class="col-md-12 col-xs-12">
                            <div class="x_panel">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                                    {!! Form::submit('Eliminar', ['class'=>'btn btn-success']) !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 col-xs-12">
                            <div class="x_panel">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                    {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                                </div>
                            </div>
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
