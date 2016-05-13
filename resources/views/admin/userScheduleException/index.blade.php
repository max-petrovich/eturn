@extends('layouts.admin')

@section('content')
    <div class="container" ng-controller="DatepickerController" ng-cloak>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_userScheduleException.adding_user_schedule_exception') }}</div>

                    <div class="panel-body">
                        <h4>{{ $master->fio }}</h4>
                        <hr>
                        {{ Form::open(['route' => ['admin.userSchedule.exceptions.store', $master->id]]) }}
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <p class="input-group">
                                    <input name="date" type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="datepicker.opened"
                                           datepicker-options="dateOptions" ng-required="true" close-text="{{ trans('all.close') }}" placeholder="{{ trans('all.date') }}" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openDatepicker()"><i class="fa fa-calendar"></i></button>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::radio('exception_type', 0, ['class' => 'form-control']) !!}
                                    {!! Form::label('exception_type', trans('admin_userScheduleException.make_day_off'), ['class' => 'control-label']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::radio('exception_type', 1, ['class' => 'form-control']) !!}
                                    {!! Form::label('exception_type', trans('admin_userScheduleException.change_schedule'), ['class' => 'control-label']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="form-group">
                                    {!! Form::label('time_start', trans('admin_userScheduleException.work_day_time_start'), ['class' => 'control-label']) !!}
                                    {!! Form::text('time_start', null, ['class' => 'form-control timepicker']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('time_end', trans('admin_userScheduleException.work_day_time_end'), ['class' => 'control-label']) !!}
                                    {!! Form::text('time_end', null, ['class' => 'form-control timepicker']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            {!! Form::submit(trans('admin_userScheduleException.add_exception'), ['class' => 'btn btn-primary']) !!}
                        </div>
                        {{ Form::close() }}
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