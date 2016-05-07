@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.additional_services_choice') }}</div>
                    <div class="row">
                        <div class="col-md-12" style="padding:20px 40px;">
                            {{ Form::open(['route' => ['booking.aservices.store', Route::current()->getParameter('booking')]]) }}
                            @foreach($additionalServices as $aService)
                                <div class="checkbox">
                                    <label><input name="additionalService[]" type="checkbox" value="{{ $aService->id }}"><strong>{{ $aService->title }}</strong><br/>{{ $aService->description }}</label>
                                </div>
                            @endforeach
                            <div class="pull-right">{{ Form::submit(trans('all.continue'), ['class' => 'btn btn-primary']) }}</div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection