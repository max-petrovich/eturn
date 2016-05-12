@extends('layouts.app')

@section('content')
    <style>
        .h4 {
            padding:0;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.steps_confirm') }}</div>
                    {{ Form::open(['class' => 'form-horizontal']) }}
                    <div class="panel-body" style="padding:15px 40px;">

                        <div class="row" style="padding:10px;">
                            <div class="col-md-3">
                                <img src="{{ $master->photoLink }}" alt="" class="img-thumbnail">
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <h4>{{ trans('booking.master') }}: {{ $master->fio }}</h4>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Услуга</th>
                                            <th>Продолжительность</th>
                                            <th>Цена</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ $procedureInfo['service']['title'] }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::createFromTime(0)->addMinutes($procedureInfo['service']['duration'])->format("H:i") }} {{ trans('all.abbreviation_hour') }}.
                                            </td>
                                            <td>
                                                {{ $procedureInfo['service']['price'] }} р.
                                            </td>
                                        </tr>
                                    @if(isset($procedureInfo['additionalServices']))
                                    <tr>
                                        <th colspan="3">
                                            Дополнительные услуги
                                        </th>
                                    </tr>
                                    @foreach($procedureInfo['additionalServices'] as $additionalServiceInfo)
                                    <tr>
                                        <td>{{ $additionalServiceInfo['title'] }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTime(0)->addMinutes($additionalServiceInfo['duration'])->format("H:i") }} {{ trans('all.abbreviation_hour') }}.</td>
                                        <td>{{ $additionalServiceInfo['price'] }} р.</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <tr>
                                        <th colspan="3">Итого:</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>{{ \Carbon\Carbon::createFromTime(0)->addMinutes($procedureInfo['all']['duration'])->format("H:i") }} {{ trans('all.abbreviation_hour') }}.</td>
                                        <td>{{ $procedureInfo['all']['price'] }} р.</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <h4>{{ trans('booking.date_of_visit') }}: {{ $visitDate }}</h4>
                                </div>
                                <div class="row">
                                    <h4>{{ trans('booking.payment_method') }}: {{ $paymentType->title }}</h4>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('client_name', trans('all.your_name')) !!}
                            {!! Form::text('client_name', Auth::user()->fio, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('client_phone', trans('all.your_phone_number')) !!}
                            {!! Form::text('client_phone', Auth::user()->phone, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('note', trans('all.note')) !!}
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>


                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="form-group text-center">
                                {!! Form::submit(trans('all.to_book'), ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection