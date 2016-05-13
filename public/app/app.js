// SERVICES
angular.module('closedDateService', [])

    .factory('ClosedDates', function($http, API_URL) {
        return {
            get : function() {
                return $http.get(API_URL + 'closedDate/all');
            }
        }
    });


angular.module('bookingService', [])

    .factory('Booking', function($http, API_URL) {
        return {
            getAvailableIntervals : function(date, master, service, additionalServices) {
                return $http.get(API_URL + 'booking/getAvailableIntervals/' + date + '/' + master + '/' + service + '/' + additionalServices);
            }
        }
    });

// app.js
// create our angular app and inject ngAnimate and ui-router
// ===========================================

var app = angular.module('booking', ['ui.bootstrap', 'closedDateService', 'bookingService'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .constant('API_URL', '/api/v1/');

// ALL CONTROLLERS

app.controller('BookingVisitDateController', function($scope, API_URL, ClosedDates, Booking){

    $scope.showNoIntervalsMsg = false;
    $scope.availableIntervals = undefined;

    // get closed dates
    ClosedDates.get()
        .success(function(response) {
            $scope.disabledDates = response.data;
        });

    $scope.inlineOptions = {
        minDate: new Date(),
        showWeeks: true
    };

    $scope.dateOptions = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date().setMonth(new Date().getMonth() + 3),
        minDate: new Date(),
        startingDay: 1
    };

    $scope.$watch("dt", function(newValue, oldValue) {

        if ($scope.dt == undefined) {
            $scope.availableIntervals = undefined;
            $scope.showNoIntervalsMsg = false;
        } else {
            $scope.availableIntervals = undefined;
            Booking.getAvailableIntervals(moment($scope.dt).format('YYYY-MM-DD'), $scope.master, $scope.service, $scope.aservices)
                .success(function(response) {
                    $scope.availableIntervals = response.data;
                    $scope.showNoIntervalsMsg = false;
                })
                .error(function(response, status) {
                    if (status == 404) {
                        $scope.showNoIntervalsMsg = true;
                    }
                });
        }
    });

    // Disable closed dates
    function disabled(data) {
        var date = data.date,
            mode = data.mode;

        if (mode === 'day' && $scope.disabledDates.length && $scope.disabledDates.indexOf(moment(date).format('YYYY-MM-DD')) !== -1) {
            return true;
        }
    }

    $scope.openVisitDate = function() {
        $scope.visitDate.opened = true;
    };

    $scope.visitDate = {
        opened: false
    };

});

app.controller('AdminClosedDatesController', function($scope, API_URL, ClosedDates){

    // get closed dates
    ClosedDates.get()
        .success(function(response) {
            $scope.disabledDates = response.data;
        });

    $scope.inlineOptions = {
        minDate: new Date(),
        showWeeks: true
    };

    $scope.dateOptions = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date().setMonth(new Date().getMonth() + 3),
        minDate: new Date(),
        startingDay: 1
    };

    // Disable closed dates
    function disabled(data) {
        var date = data.date,
            mode = data.mode;

        if (mode === 'day' && $scope.disabledDates.length && $scope.disabledDates.indexOf(moment(date).format('YYYY-MM-DD')) !== -1) {
            return true;
        }
    }

    $scope.openDatepicker = function() {
        $scope.datepicker.opened = true;
    };

    $scope.datepicker = {
        opened: false
    };

});

app.controller('DatepickerController', function($scope){


    $scope.inlineOptions = {
        minDate: new Date(),
        showWeeks: true
    };

    $scope.dateOptions = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date().setMonth(new Date().getMonth() + 3),
        minDate: new Date(),
        startingDay: 1
    };

    // Disable closed dates
    function disabled(data) {
        // var date = data.date,
        //     mode = data.mode;
        //
        // if (mode === 'day' && $scope.disabledDates.length && $scope.disabledDates.indexOf(moment(date).format('YYYY-MM-DD')) !== -1) {
        //     return true;
        // }
        return false;
    }

    $scope.openDatepicker = function() {
        $scope.datepicker.opened = true;
    };

    $scope.datepicker = {
        opened: false
    };

});