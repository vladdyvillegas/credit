@extends('layouts.blank')

@section('title', 'Cierre de periodo')

@section('main_container')

<!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Administración <small>Cierre de periodo</small></h3>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Cierre de periodo <small></small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
              <p>Este preceso permite cerrar una periodo (mes) comercial en una gestión dada, de tal forma que no será posible la creación y/o modificación de operaciones y amortizaciones que correspondan al periodo cerrado.</p>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Gestión</th>
                      <th>Periodo</th>
                      <th>Estado</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($periods as $period)
                    <tr>
                      <td scope="row">{{ $period->gestion }}</td>
                      <td scope="row">{{ $period->name }}</td>
                      <td>{{ $period->status }}</td>
                      <td>
                        @if ($period->status=="ABIERTO")
                          <a href="{{ url('period_close', $period->id) }}" class="btn btn-info btn-xs">Cerrar periodo </a>
                        @endif
                      </td>
                    </tr>
                  <?php //$min_gestion = $min_gestion+1; ?>
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
