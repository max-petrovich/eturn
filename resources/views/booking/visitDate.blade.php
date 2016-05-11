@extends('layouts.app')

@section('content')

<style>
    h4 {
        margin:5px 0 ;
    }
</style>

<div ng-controller="BookingVisitDateController" ng-cloak ng-init="service={{ $inputData['service_id'] }};aservices='{{ $inputData['additionalServices'] }}';master={{ $inputData['master_id'] }}">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('booking.select_the_date_of_the_visit') }}</div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-4">
                            <br/>
                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="visitDate.opened"
                                       datepicker-options="dateOptions" ng-required="true" close-text="{{ trans('all.close') }}" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openVisitDate()"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div ng-repeat="intervals in availableIntervals" class="row" style="padding:20px;">
                        <div class="col-md-3">
                            <img ng-src="<% intervals.master.photo %>" alt="<% intervals.master.fio %>" class="img-thumbnail">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <h4 class="col-md-9"><% intervals.master.fio %></h4>
                                <h4 class="col-md-3 text-right"><% intervals.price %> р.</h4>
                            </div>
                            <div ng-repeat="interval in intervals.intervals" class="row">
                                <h4><a ng-href="booking/<% service %>/aservices/<% aservices %>/master/<% intervals.master.id %>/date/<% dt | date:'yyyy-MM-dd' %>,<% interval[0] %>/payment"><% interval[0] %> - <% interval[1] %></a></h4>
                            </div>
                        </div>
                    </div>
                    <div ng-show="showNoIntervalsMsg" style="margin:0 20px;">
                        <div class="alert alert-warning" role="alert">Нет доступных интервалов</div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>
@endsection
@push('scripts')
    {{ Html::script('assets/bower/moment/min/moment.min.js') }}
@endpush