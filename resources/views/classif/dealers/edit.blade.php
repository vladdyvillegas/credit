@extends('layouts.blank')

@section('title', 'Edición de concesionarios')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Administration <small>Edición de concesionario</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="dealer_edit" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('dealer_update', $dealers->id) }}">
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Datos del concesionario <small>datos genarales</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Prefijo <span class="required">*</span></label>
                              <div class="col-md-1 col-sm-9 col-xs-12">
                                  {{ Form::text('abbrev', $dealers->abbrev, ['id'=>'abbrev', 'maxlength'=>'1', 'class'=>'form-control col-md-7 col-xs-12', 'required'=>'required']) }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre o descripción <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  {{ Form::text('dealer', $dealers->dealer, ['id'=>'dealer', 'maxlength'=>'60', 'class'=>'form-control col-md-7 col-xs-12', 'required'=>'required']) }}
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
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
