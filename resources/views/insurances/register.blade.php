@extends('layouts.blank')

@section('title', 'Registro Seguro Automotor')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Seguro automotor <small></small></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
                $annual_interest_rate = 14;
                $delayed_interest_rate = 23.88;
             ?>
            <!--form-->
            {!! Form::open(['id'=>'insurance_update', 'class'=>'form-horizontal form-label-left input_mask','action'=>'Insurance\InsuranceController@update', 'method'=>'get']) !!}
            {{ Form::hidden('monthly_term', $operation->monthly_term, ['id'=>'monthly_term']) }}
            <div cass="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Registro de pagos anuales {{ $operation->operation }} <small></small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            @if ($insurances->isEmpty())
                                {{ Form::hidden('new', 1, ['id'=>'new']) }}
                                {{ Form::hidden('operation_id', $operation->id, ['id'=>'operation_id']) }}
                                {{ Form::hidden('application_date', $operation->application_date, ['id'=>'application_date']) }}
                                @for ($k = 1; $k <= $operation->monthly_term; $k++)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Año {{ $k }}</label>
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            {{ Form::number('payment'.$k, null, ['id'=>'payment'.$k, 'step'=>'any', 'class'=>'form-control col-md-7 col-xs-12']) }}
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{ Form::hidden('id'.$k, null, ['id'=>'id'.$k]) }}
                                            <p class="font-weight-bold"> {{ $operation->application_date }} </p>
                                        </div>
                                    </div>
                                    <?php $operation->application_date = date('Y-m-d', strtotime('+1 year', strtotime($operation->application_date))); ?>
                                @endfor
                            @else
                                <?php $k = 1; ?>
                                {{ Form::hidden('new', 0, ['id'=>'new']) }}
                                @foreach ($insurances as $insurance)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Año {{ $k }}</label>
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            @if ($insurance->status == 'PAGADO')
                                                {{ Form::number('payment'.$k, $insurance->payment, ['id'=>'payment'.$k, 'step'=>'any', 'readonly' => 'readonly', 'class'=>'form-control col-md-7 col-xs-12']) }}
                                            @else
                                                {{ Form::number('payment'.$k, $insurance->payment, ['id'=>'payment'.$k, 'step'=>'any', 'class'=>'form-control col-md-7 col-xs-12']) }}
                                            @endif

                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            {{ Form::hidden('id'.$k, $insurance->id, ['id'=>'id'.$k]) }}
                                            <p class="font-weight-bold"> {{ $insurance->expired_date }}
                                                @if ($insurance->payment > 0)
                                                    @if ($insurance->status == 'VIGENTE')
                                                        <span class="label label-info">Vigente</span>
                                                    @elseif ($insurance->status == 'VENCIDO')
                                                        <span class="label label-danger">Vencido</span>
                                                    @else
                                                        <span class="label label-success">Pagado</span>
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                        @if ($insurance->payment > 0 and $insurance->status == 'VENCIDO')
                                            <div class="col-md-2 col-sm-6 col-xs-12">
                                                <div class="col-md-2 col-sm-6 col-xs-12">
                                                    {!! Form::checkbox('pay'.$k, 1, false) !!}
                                                </div>
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Pagar </label>
                                            </div>
                                        @endif
                                    </div>
                                    <?php $k++; ?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
                            {!! Form::button('Cancelar', ['onclick'=>'history.back()', 'class'=>'btn btn-primary']) !!}
                            {!! Form::reset('Limpiar', ['class' => 'btn btn-primary']) !!}
                            {!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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
