@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.payment_choice') }}</div>

                    <div class="panel-body">
                        <div class="list-group">
                            @foreach($paymentTypes as $paymentType)
                                <a href="{{ Request::url() }}/{{ $paymentType->id }}/confirm" class="list-group-item">{{ $paymentType->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection