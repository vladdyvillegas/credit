<div class="col-md-6 col-xs-12" id="clientJuridica_left">
    <div class="x_panel">
        <div class="x_title">
            <h2>Datos del cliente <small>datos genarales</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                {{ Form::text('id_document', null, ['id'=>'id_document2', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Númeror de Identificación Tributaria']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_phone', null, ['id'=>'work_phone2', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Teléfono fijo']) }}
                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_fax', null, ['id'=>'work_fax2', 'class'=>'form-control', 'readonly'=>'readonly', 'placeholder'=>'Telefax']) }}
                <span class="fa fa-fax form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('work_activity', null, ['id'=>'work_activity2', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Rubro']) }}
                <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('work_address', null, ['id'=>'work_address2', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Dirección de domicilio']) }}
                <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xs-12" id="clientJuridica_right">
    <div class="x_panel">
        <div class="x_title">
            <h2>Datos complementarios <small> </small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p>Datos del representante legal</p>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_name', null, ['id'=>'representative_name', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Nombre completo']) }}
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_id_document', null, ['id'=>'representative_id_document', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Cédula de identidad']) }}
                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::text('representative_phone', null, ['id'=>'representative_phone', 'class'=>'form-control has-feedback-right', 'readonly'=>'readonly', 'placeholder'=>'Teléfono móvil']) }}
                <span class="fa fa-mobile form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                {{ Form::email('representative_email', null, ['id'=>'representative_email', 'class'=>'form-control has-feedback-left', 'readonly'=>'readonly', 'placeholder'=>'Correo electrónico']) }}
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>