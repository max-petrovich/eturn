@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_services.adding_service') }}</div>

                    <div class="panel-body">
                        {{ Form::open(['route' => 'admin.services.store']) }}
                        @include('admin.service.form')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection