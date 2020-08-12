<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Datos del cliente <small>datos genarales</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br />
            @include('partials.messages')
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-3 col-xs-3">Tipo de ciente</label>
                <div class="col-md-4 col-sm-9 col-xs-12">
                    @if($clients->type == "PROPIO")
                        <input type="radio" checked="checked" value="PROPIO" id="type" name="type" disabled> Cliente propio
                        <br />
                        <input type="radio" value="FINANCIAL" id="type" name="type" disabled> Cliente financial
                    @elseif($clients->type == "FINANCIAL")
                        <input type="radio" value="PROPIO" id="type" name="type" disabled> Cliente propio
                        <br />
                        <input type="radio" checked="checked" value="FINANCIAL" id="type" name="type" disabled> Cliente financial
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('name', $clients->name, ['id'=>'name', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Nombre completo']) }}
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12 form-group has-feedback">
                {{ Form::text('id_document', $clients->id_document, ['id'=>'id_document', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Cédula de identidad']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>

            {{ Form::hidden('type_id_document', 'CI', ['id'=>'type_id_document']) }}
            {{ Form::hidden('legal_personality', 'NATURAL', ['id'=>'legal_personality']) }}

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('birthdate', $clients->birthdate, ['id'=>'birthdate', 'class'=>'form-control has-feedback-right', 'readonly'=>'readonly', 'placeholder'=>'Fecha nacimiento']) }}
                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::email('email', $clients->email, ['id'=>'email', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Correo electrónico']) }}
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('mobile_phone', $clients->mobile_phone, ['id'=>'mobile_phone', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Teléfono móvil']) }}
                <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('phone', $clients->phone, ['id'=>'phone', 'class'=>'form-control has-feedback-right', 'readonly'=>'readonly', 'placeholder'=>'Teléfono fijo']) }}
                <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::textarea('address', $clients->address, ['id'=>'address', 'class'=>'form-control', 'size'=>'10x2', 'readonly'=>'readonly', 'placeholder'=>'Dirección de domicilio']) }}
            </div>
            <br />
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('profession', $clients->profession, ['id'=>'profession', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Profesión /Actividad']) }}
                <span class="fa fa-gavel form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Datos complementarios <small> </small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br />
            <p>Datos del cónyugue</p>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('spouse_name', $clients->spouse_name, ['id'=>'spouse_name', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Nombre completo']) }}
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('spouse_id_document', $clients->spouse_id_document, ['id'=>'spouse_id_document', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Cédula de identidad']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('spouse_phone', $clients->spouse_phone, ['id'=>'spouse_phone', 'class'=>'form-control has-feedback-right', 'readonly'=>'readonly', 'placeholder'=>'Teléfono móvil']) }}
                <span class="fa fa-mobile form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::email('spouse_email', $clients->spouse_email, ['id'=>'spouse_email', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Correo electrónico']) }}
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="x_content">
            <p>Datos del trabajo</p>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('work', $clients->work, ['id'=>'work', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Lugar de trabajo']) }}
                <span class="fa fa-map-pin form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_phone', $clients->work_phone, ['id'=>'work_phone', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Teléfono fijo']) }}
                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_fax', $clients->work_fax, ['id'=>'work_fax', 'class'=>'form-control has-feedback-right', 'readonly'=>'readonly', 'placeholder'=>'Telefax']) }}
                <span class="fa fa-fax form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_activity', $clients->work_activity, ['id'=>'work_activity', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Rubro']) }}
                <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::textarea('work_address', $clients->work_address, ['id'=>'work_address', 'class'=>'form-control', 'size'=>'10x2', 'readonly'=>'readonly', 'placeholder'=>'Dirección de trabajo']) }}
            </div>
        </div>
    </div>
</div>