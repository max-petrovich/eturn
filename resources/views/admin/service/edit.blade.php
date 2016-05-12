@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('all.editing') }}</div>

                    <div class="panel-body">
                        {{ Form::model($service, ['method' => 'PUT', 'route' => ['admin.services.update', $service->id]]) }}
                        @include('admin.service.form')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection