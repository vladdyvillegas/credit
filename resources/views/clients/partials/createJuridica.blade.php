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
                    <input type="radio" checked="" value="PROPIO" id="type" name="type"> Cliente propio
                    <br />
                    <input type="radio" value="FINANCIAL" id="type" name="type"> Cliente financial
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control has-feedback-left', 'required'=>'required', 'placeholder'=>'Razón social']) }}
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                {{ Form::text('id_document', null, ['id'=>'id_document', 'class'=>'form-control has-feedback-left', 'required'=>'required', 'placeholder'=>'Númeror de Identificación Tributaria']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>

            {{ Form::hidden('type_id_document', 'NIT', ['id'=>'type_id_document']) }}
            {{ Form::hidden('legal_personality', 'JURIDICA', ['id'=>'legal_personality']) }}

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_phone', null, ['id'=>'work_phone', 'class'=>'form-control has-feedback-left', 'placeholder'=>'Teléfono fijo']) }}
                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_fax', null, ['id'=>'work_fax', 'class'=>'form-control', 'placeholder'=>'Telefax']) }}
                <span class="fa fa-fax form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_activity', null, ['id'=>'work_activity', 'class'=>'form-control has-feedback-left', 'placeholder'=>'Rubro']) }}
                <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::textarea('work_address', null, ['id'=>'work_address', 'class'=>'form-control', 'size'=>'10x2', 'placeholder'=>'Dirección']) }}
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
            <p>Datos del representante legal</p>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_name', null, ['id'=>'representative_name', 'class'=>'form-control has-feedback-left', 'placeholder'=>'Nombre completo']) }}
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_id_document', null, ['id'=>'representative_id_document', 'class'=>'form-control has-feedback-left', 'placeholder'=>'Cédula de identidad']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_phone', null, ['id'=>'representative_phone', 'class'=>'form-control has-feedback-right', 'placeholder'=>'Teléfono móvil']) }}
                <span class="fa fa-mobile form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::email('representative_email', null, ['id'=>'representative_email', 'class'=>'form-control has-feedback-left', 'placeholder'=>'Correo electrónico']) }}
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>