@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_additionalServices.editing_additional_serivce') }}</div>

                    <div class="panel-body">
                        @include('admin.additionalServices.main_serivce')
                        {{ Form::model($additionalSerivce, ['method' => 'PUT', 'route' => ['admin.services.additionalServices.update', $service->id, $additionalSerivce->id]]) }}
                        @include('admin.additionalServices.form')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection