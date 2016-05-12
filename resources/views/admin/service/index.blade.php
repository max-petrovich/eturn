@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin.services') }}</div>

                    <div class="panel-body">
                        <div class="text-center">
                            <p><a href="{{ route('admin.services.create') }}" class="btn btn-primary">{{ trans('admin_services.add_service') }}</a></p>
                        </div>
                        @if ($services && $services->count())
                            <div class="list-group">
                                @foreach($services as $service)
                                    <li class="list-group-item clearfix">
                                        {{ $service->title }}
                                        <div class="pull-right">
                                            {{ Form::open(['route' => ['admin.services.destroy', $service->id], 'method' => 'delete']) }}
                                            <button type="submit" class="btn btn-danger btn-xs" title="{{ trans('all.delete') }}"><i class="fa fa-remove"></i></button>
                                            {{ Form::close() }}
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('admin.services.edit', [$service->id]) }}" class="btn btn-warning btn-xs" title="{{ trans('all.edit') }}"><i class="fa fa-edit"></i></a> &nbsp;
                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ trans('admin_closedDate.not_found') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection