@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_additionalServices.adding_additional_service') }}</div>

                    <div class="panel-body">
                        @include('admin.additionalServices.main_serivce')
                        {{ Form::open(['route' => ['admin.services.additionalServices.store', $service->id]]) }}
                        @include('admin.additionalServices.form')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection