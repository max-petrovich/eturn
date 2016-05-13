@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin.closed_date') }}</div>

                    <div class="panel-body">
                        <div class="text-center">
                            <p><a href="{{ route('admin.closedDates.create') }}" class="btn btn-primary">{{ trans('admin_closedDate.add_date') }}</a></p>
                        </div>
                        @if ($closedDates && $closedDates->count())
                            <div class="list-group">
                                @foreach($closedDates as $date)
                                    <li class="list-group-item clearfix">
                                        {{ $date->closed_date->format("d.m.Y") }}
                                        <div class="pull-right">
                                            {{ Form::open(['route' => ['admin.closedDates.destroy', $date->closed_date->toDateString()], 'method' => 'delete']) }}
                                            <button type="submit" class="btn btn-danger btn-xs" title="{{ trans('admin_closedDate.remove_date') }}"><i class="fa fa-remove"></i></button>
                                            {{ Form::close() }}
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