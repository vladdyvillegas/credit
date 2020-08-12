@extends('layouts.blank')

@section('title', 'Lista de concesionarios')

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
                    <h3>Administración <small>Concesionarios</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Concesionarios<small>Lista de concesionarios</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a href="dealer_create"><i class="fa fa-plus-square"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                                Interface para la creación, modificación y eliminación de concesionarios.
                            </p>
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Prefijo</th>
                                    <th>Nombre del concesionario</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($dealers as $dealer)
                                <tr>
                                    <td>{{ $dealer->abbrev }}</td>
                                    <td>{{ $dealer->dealer }}</td>
                                    <td>
                                      <a href="{{ url('dealer_show', $dealer->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> </a>
                                      <a href="{{ url('dealer_edit', $dealer->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
                                      <a href="{{ url('dealer_delete', $dealer->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a>
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
