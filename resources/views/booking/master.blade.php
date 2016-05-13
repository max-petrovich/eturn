@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.master_choice') }}</div>

                    <div style="padding-bottom: 20px;">
                    @foreach($masters->chunk(4) as $masterChunk)
                        <div class="row" style="padding:20px 20px 0 20px;">
                        @foreach($masterChunk as $master)
                            <div class="col-md-3">
                                <img src="{{ $master->photoLink }}" alt="{{ $master->fio }}" class="img-thumbnail">
                                <div class="text-center" style="margin-top:10px;">{{ link_to_route('booking.aservices.master.date.index', $master->fio, 
                                array_merge(array_values(Route::current()->parameters()), [$master->id])) }}</div>
                            </div>
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection