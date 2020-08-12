@extends('layouts.blank')

@section('title', 'Listado de clientes')

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
                    <h3>Administración <small>Clientes</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Clientes<small>Lista de clientes</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-plus-square"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="client_create/NATURAL">Natural</a>
                                        </li>
                                        <li><a href="client_create/JURIDICA">Jurídica</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        @include('partials.messages')

                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                                Interface para la creación, modificación y eliminación de clientes.
                            </p>
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Nombre cliente</th>
                                    <th>CI / NIT</th>
                                    <th>Teléfono móvil</th>
                                    <th>Teléfono fijo</th>
                                    <th>Email</th>
                                    <th>Tipo</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->id_document }}</td>
                                    <td>{{ $client->mobile_phone }}</td>
                                    <td>{{ $client->work_phone }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->type }}</td>
                                    <td>
                                        <a href="{{ url('client_show', $client->id) }}" class="btn btn-primary btn-xs" alt="Ver"><i class="fa fa-folder"></i></a>
                                        <a href="{{ url('client_edit', $client->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('client_delete', $client->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>&nbsp;
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
