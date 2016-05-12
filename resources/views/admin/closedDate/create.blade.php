@extends('layouts.admin')

@section('content')
    <div class="container" ng-controller="AdminClosedDatesController" ng-cloak>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin_closedDate.adding_date') }}</div>

                    {{ Form::open(['route' => 'admin.closedDates.store']) }}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <p class="input-group">
                                    <input name="closed_date" type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="datepicker.opened"
                                           datepicker-options="dateOptions" ng-required="true" close-text="{{ trans('all.close') }}" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openDatepicker()"><i class="fa fa-calendar"></i></button>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="row text-center">
                            {!! Form::submit(trans('all.add'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{ Html::script('assets/bower/moment/min/moment.min.js') }}
@endpush