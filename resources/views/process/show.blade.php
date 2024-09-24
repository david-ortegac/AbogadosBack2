@extends('layouts.app')

@section('template_title')
    {{ $process->name ?? "{{ __('Show') Process" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Process</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('processes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Documenttype:</strong>
                            {{ $process->documentType }}
                        </div>
                        <div class="form-group">
                            <strong>Documentnumber:</strong>
                            {{ $process->documentNumber }}
                        </div>
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $process->name }}
                        </div>
                        <div class="form-group">
                            <strong>Lastname:</strong>
                            {{ $process->lastName }}
                        </div>
                        <div class="form-group">
                            <strong>Nationality:</strong>
                            {{ $process->nationality }}
                        </div>
                        <div class="form-group">
                            <strong>Applicationdate:</strong>
                            {{ $process->applicationDate }}
                        </div>
                        <div class="form-group">
                            <strong>Pendingpayment:</strong>
                            {{ $process->pendingPayment }}
                        </div>
                        <div class="form-group">
                            <strong>Processstatus:</strong>
                            {{ $process->processStatus }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $process->status }}
                        </div>
                        <div class="form-group">
                            <strong>Validationkey:</strong>
                            {{ $process->validationKey }}
                        </div>
                        <div class="form-group">
                            <strong>Link:</strong>
                            {{ $process->Link }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
