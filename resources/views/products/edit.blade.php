@extends('layouts.blank')

@section('title', 'Edición de productos')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Administration <small>Edición de productos</small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--form-->
            <form id="product_edit" data-parsley-validate class="form-horizontal form-label-left input_mask" action="{{ url('product_update', $products->id) }}">

            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Datos del producto <small>datos genarales</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Tipo <span class="required">*</span></label>
                                <div class="col-md-3 col-sm-9 col-xs-12">
                                    <select id="type" name="type" class="form-control">
                                        <option>Elija una opción</option>
                                        @if ($products->type == "VEHICULO")
                                            <option value="VEHICULO" selected>VEHICULO</option>
                                            <option value="SEGURO">SEGURO</option>
                                        @elseif ($products->type == "SEGURO")
                                            <option value="VEHICULO">VEHICULO</option>
                                            <option value="SEGURO" selected>SEGURO</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre o descripción <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::text('name', $products->name, ['id'=>'name', 'class'=>'form-control col-md-7 col-xs-12', 'required'=>'required']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Precio ($USD)</label>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    {{ Form::number('price', $products->price, ['id'=>'price', 'step'=>'any', 'class'=>'form-control col-md-7 col-xs-12']) }}
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
