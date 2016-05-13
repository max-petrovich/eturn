@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_services.editing_service') }} : {{ $service->title }}</div>

                    <div class="panel-body">
                        <h4>{{ trans('admin_services.main_service') }}</h4>
                        <hr>
                        {{ Form::model($service, ['method' => 'PUT', 'route' => ['admin.services.update', $service->id]]) }}
                        @include('admin.service.form')
                        {{ Form::close() }}

                        <hr>
                        <h4>{{ trans('admin_services.additional_services') }}
                            <div class="pull-right">
                                <a href="{{ route('admin.services.additionalServices.create', [$service->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> {{ trans('admin_services.add_additional_service') }}</a> &nbsp;
                            </div>
                        </h4>
                        <hr>
                        <!-- Additional Services -->
                        @if($additionalServices && $additionalServices->count())

                            <div class="list-group">
                                @foreach($additionalServices as $additionalService)
                                    <li class="list-group-item clearfix">
                                        {{ $additionalService->title }}
                                        <div class="pull-right">
                                            <a href="{{ route('admin.services.additionalServices.edit', [$service->id, $additionalService]) }}" class="btn btn-warning btn-xs" title="{{ trans('all.edit') }}"><i class="fa fa-edit"></i></a> &nbsp;
                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ trans('admin_services.additional_services_not_found') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection