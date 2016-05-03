@extends('layouts.app')

@section('content')
    <div class="container" ng-controller="BookingController">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('all.services_list') }}</div>

                    <div class="panel-body">
                        @if(count($services))
                            <div class="list-group">
                                @foreach($services as $service)
                                    <li class="list-group-item clearfix">
                                        {{ $service->title }}
                                        <div class="pull-right"><a href="{{ route('booking.show', $service->id) }}" class="btn btn-primary">{{ trans('all.to_book') }} <i class="fa fa-shopping-cart"></i></a></div>
                                    </li>
                                @endforeach
                            </div>
                        @else
                            {{ trans('all.services_not_found') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
