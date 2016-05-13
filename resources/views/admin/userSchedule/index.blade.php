@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_userSchedule.choose_master') }}</div>

                    <div class="panel-body">
                        @if ($masters && $masters->count())
                                @foreach($masters->chunk(4) as $masterChunk)
                                    <div class="row" style="padding:20px 20px 0 20px;">
                                        @foreach($masterChunk as $master)
                                            <div class="col-md-3">
                                                <a href="{{ route('admin.userSchedule.edit', [$master->id]) }}"><img src="{{ $master->photoLink }}" alt="{{ $master->fio }}" class="img-thumbnail"></a>
                                                <div class="text-center" style="margin-top:10px;">
                                                    <a href="{{ route('admin.userSchedule.edit', [$master->id]) }}">{{ $master->fio }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                        @else
                            <div class="alert alert-warning">
                                {{ trans('admin_userSchedule.masters_not_found') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection