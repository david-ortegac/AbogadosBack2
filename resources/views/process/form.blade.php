<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('documentType') }}
            {{ Form::text('documentType', $process->documentType, ['class' => 'form-control' . ($errors->has('documentType') ? ' is-invalid' : ''), 'placeholder' => 'Documenttype']) }}
            {!! $errors->first('documentType', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('documentNumber') }}
            {{ Form::text('documentNumber', $process->documentNumber, ['class' => 'form-control' . ($errors->has('documentNumber') ? ' is-invalid' : ''), 'placeholder' => 'Documentnumber']) }}
            {!! $errors->first('documentNumber', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $process->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lastName') }}
            {{ Form::text('lastName', $process->lastName, ['class' => 'form-control' . ($errors->has('lastName') ? ' is-invalid' : ''), 'placeholder' => 'Lastname']) }}
            {!! $errors->first('lastName', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nationality') }}
            {{ Form::text('nationality', $process->nationality, ['class' => 'form-control' . ($errors->has('nationality') ? ' is-invalid' : ''), 'placeholder' => 'Nationality']) }}
            {!! $errors->first('nationality', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('applicationDate') }}
            {{ Form::text('applicationDate', $process->applicationDate, ['class' => 'form-control' . ($errors->has('applicationDate') ? ' is-invalid' : ''), 'placeholder' => 'Applicationdate']) }}
            {!! $errors->first('applicationDate', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pendingPayment') }}
            {{ Form::text('pendingPayment', $process->pendingPayment, ['class' => 'form-control' . ($errors->has('pendingPayment') ? ' is-invalid' : ''), 'placeholder' => 'Pendingpayment']) }}
            {!! $errors->first('pendingPayment', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('processStatus') }}
            {{ Form::text('processStatus', $process->processStatus, ['class' => 'form-control' . ($errors->has('processStatus') ? ' is-invalid' : ''), 'placeholder' => 'Processstatus']) }}
            {!! $errors->first('processStatus', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $process->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('validationKey') }}
            {{ Form::text('validationKey', $process->validationKey, ['class' => 'form-control' . ($errors->has('validationKey') ? ' is-invalid' : ''), 'placeholder' => 'Validationkey']) }}
            {!! $errors->first('validationKey', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Link') }}
            {{ Form::text('Link', $process->Link, ['class' => 'form-control' . ($errors->has('Link') ? ' is-invalid' : ''), 'placeholder' => 'Link']) }}
            {!! $errors->first('Link', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>