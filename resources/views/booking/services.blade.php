@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.service_choice') }}</div>

                    <div class="panel-body">
                        @if(count($services))
                            <div class="list-group">
                                @foreach($services as $service)
                                    <li class="list-group-item clearfix">
                                        {{ $service->title }}
                                        <div class="pull-right"><a href="{{ route('booking.aservices.index', $service->id) }}" class="btn btn-primary btn-sm">{{ trans('all.to_book') }} <i class="fa fa-shopping-cart"></i></a></div>
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
