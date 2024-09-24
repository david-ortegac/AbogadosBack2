@extends('layouts.app')

@section('template_title')
    Process
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Process') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('processes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Documenttype</th>
										<th>Documentnumber</th>
										<th>Name</th>
										<th>Lastname</th>
										<th>Nationality</th>
										<th>Applicationdate</th>
										<th>Pendingpayment</th>
										<th>Processstatus</th>
										<th>Status</th>
										<th>Validationkey</th>
										<th>Link</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($processes as $process)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $process->documentType }}</td>
											<td>{{ $process->documentNumber }}</td>
											<td>{{ $process->name }}</td>
											<td>{{ $process->lastName }}</td>
											<td>{{ $process->nationality }}</td>
											<td>{{ $process->applicationDate }}</td>
											<td>{{ $process->pendingPayment }}</td>
											<td>{{ $process->processStatus }}</td>
											<td>{{ $process->status }}</td>
											<td>{{ $process->validationKey }}</td>
											<td>{{ $process->Link }}</td>

                                            <td>
                                                <form action="{{ route('processes.destroy',$process->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('processes.show',$process->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('processes.edit',$process->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $processes->links() !!}
            </div>
        </div>
    </div>
@endsection
