@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('admin.services.index') }}">{{ trans('admin_service_user.services') }}</a> &laquo;
                        <a href="{{ route('admin.services.users.index', $service->id) }}">{{ trans('admin_service_user.masters') }}</a> &laquo;
                        {{ trans('admin_service_user.setting_parameters_service_for_user') }}
                        </div>

                    <div class="panel-body">
                        <h4>{{ trans('admin_service_user.master') }} : <span style="text-decoration: underline">{{ $master->fio }}</span></h4>
                        <div class="text-center">
                            <img src="{{ $master->photoLink }}" alt="{{ $master->fio }}" class="img-thumbnail">
                        </div>
                        <hr>
                        <h4>{{ trans('admin_service_user.service') }} : <a href="{{ route('admin.services.edit', $service->id) }}">{{ $service->title }}</a></h4>

                        {{ Form::model($serviceUser, ['route' => ['admin.services.users.update', $service->id, $master->id], 'method' => 'put']) }}
                        @include('admin.service.user.form')
                        {{ Form::close() }}

                        @if($additionalServices && $additionalServices->count())
                            <hr>
                            <h4>{{ trans('admin_service_user.additional_services') }}</h4>
                            <hr>
                            @foreach($additionalServices as $additionalService)
                                <h4>{{ trans('admin_service_user.service') }} : <a href="{{ route('admin.services.additionalServices.edit', [$service->id, $additionalService->id]) }}">{{ $additionalService->title }}</a></h4>
                                {{ Form::model($additionalServicesUser->get($additionalService->id), ['route' => ['admin.services.users.additionalService.update', $service->id, $master->id, $additionalService->id], 'method' => 'put']) }}
                                @include('admin.service.user.form')
                                {{ Form::close() }}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection