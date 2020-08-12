<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title"><i class="fa fa-paper-plane"></i> <span>PaperPlane Systems</span></a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3></h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-cubes"></i> Menú principal <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('operation_index') }}">Operaciones de crédito</a></li>
                            <li><a href="{{ url('operation_expired') }}">Vencimiento de cuotas</a></li>
                            <li><a href="{{ url('insurance_expired') }}">Vencimiento de seguro</a></li>

                        </ul>
                    </li>
                </ul>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-clone"></i>Informes <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a>Créditos directos<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu"><a href="{{ url('operation_report/PROPIO') }}">Cartera propia</a></li>
                                    <li><a href="{{ url('operation_report/FINANCIAL') }}">Financiera</a></li>
                                </ul>

                            </li>
                            <li>
                                <a>Seguro automotor<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{ url('insurance_report/PROPIO') }}">Cartera propia</a></li>
                                    <li><a href="{{ url('insurance_report/FINANCIAL') }}">Financiera</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Mora acumulada<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{ url('accrued_report/PROPIO') }}">Cartera propia</a></li>
                                    <li><a href="{{ url('accrued_report/FINANCIAL') }}">Financiera</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-gears"></i> Administración <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('client_index') }}">Clientes</a></li>
                            <li><a href="{{ url('product_index') }}">Productos</a></li>
                            <li>
                                <a>Clasificadores<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu">
                                        <a href="{{ url('dealer_index') }}">Concesionarios</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a>Procesos<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    {{-- <li class="sub_menu">
                                        <a href="{{ url('process_recovery_arrears') }}">Recuperación por mora</a>
                                    </li> --}}
                                    <li class="sub_menu">
                                        <a href="{{ url('process_rescission') }}">Rescisión por mutuo acuerdo</a>
                                    </li>
                                    <li class="sub_menu">
                                        <a href="{{ url('process_close_period') }}">Cierre de periodo</a>
                                    </li>
                                    <li class="sub_menu">
                                        <a href="{{ url('process_close_gestion') }}">Cierre de gestión</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
