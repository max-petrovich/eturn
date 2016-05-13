@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_userSchedule.editing_user_schedule') }}</div>

                    <div class="panel-body">
                        <h4>{{ trans('admin_userSchedule.schedule') }}: {{ $master->fio }}</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ $master->photoLink }}" alt="{{ $master->fio }}" class="img-thumbnail">
                            </div>
                            <div class="col-md-9">
                                {{ Form::open(['route' => ['admin.userSchedule.update', $master->id], 'method' => 'put']) }}

                                @foreach($schedule as $scheduleItem)
                                    <div class="row"  style="margin:15px 0;">
                                        <div class="col-md-1"><a class="btn btn-default btn-sm">{{ trans('datetime.' . App\Entities\Weekdays::getNameById($scheduleItem->weekday)) }}</a></div>
                                        <div class="col-md-11">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    {!! Form::text('schedule['.$scheduleItem->weekday.'][time_start]', (!is_null($scheduleItem->time_start) ? Carbon\Carbon::parse($scheduleItem->time_start)->format('H:i') : ''), ['class' => 'form-control timepicker']) !!}
                                                </div>
                                                <div class="col-md-1">-</div>
                                                <div class="col-md-2">
                                                    {!! Form::text('schedule['.$scheduleItem->weekday.'][time_end]', (!is_null($scheduleItem->time_end) ? Carbon\Carbon::parse($scheduleItem->time_end)->format('H:i') : ''), ['class' => 'form-control timepicker']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        {!! Form::submit(trans('admin_userSchedule.save_schedule'), ['class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>

                        <hr>
                        <h4>{{ trans('admin_userSchedule.schedule_exceptions') }}
                            <div class="pull-right">
                                <a href="{{ route('admin.userSchedule.exceptions.create', [$master->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> {{ trans('admin_userScheduleException.add_exception') }}</a> &nbsp;
                            </div>
                        </h4>

                        @if($scheduleExceptions && count($scheduleExceptions))
                            @foreach($scheduleExceptions as $scheduleException)
                                <div class="alert alert-danger" style="padding:10px;">
                                    {{ $scheduleException->exception_date->format("d.m.Y") }}
                                    ( {{ is_null($scheduleException->time_start) ?
                                    trans('all.day_off') :
                                    Carbon\Carbon::parse($scheduleException->time_start)->format('H:i') . ' - ' . Carbon\Carbon::parse($scheduleException->time_end)->format('H:i') }}
                                    )
                                    <div class="pull-right">
                                        {{ Form::open(['route' => ['admin.userSchedule.exceptions.destroy', $master->id, $scheduleException->id], 'method' => 'delete']) }}
                                        <button type="submit" class="btn btn-danger btn-xs" title="{{ trans('admin_closedDate.remove_date') }}"><i class="fa fa-remove"></i></button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                {{ trans('admin_userSchedule.no_schedule_exceptions') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{{ Html::style('assets/bower/datetimepicker/jquery.datetimepicker.css') }}
{{ Html::script('assets/bower/datetimepicker/build/jquery.datetimepicker.full.min.js') }}
<script>
    $(document).ready(function() {
        jQuery('.timepicker').datetimepicker({
            datepicker:false,
            format: 'H:i',
            step: 30
        });
    });
</script>
@endpush