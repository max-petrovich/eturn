// SERVICES
angular.module('additionalServiceService', [])

    .factory('AdditionalService', function($http, API_URL) {
        return {
            get : function() {
                return $http.get(API_URL + 'services');
            }
        }
    });

// app.js
// create our angular app and inject ngAnimate and ui-router
// ===========================================

var app = angular.module('booking', ['additionalServiceService'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .constant('API_URL', '/api/v1/');

// ALL CONTROLLERS

app.controller('BookingController', function($scope,$http, API_URL, AdditionalService){
    $scope.data = [];
    $scope.additionalServices = [];

    AdditionalService.get()
        .success(function(response) {
            $scope.additionalServices = response.data;
        });
    /* Get all services */
    // $http.get(API_URL + "services")
    //     .success(function(response) {
    //         $scope.services = response.data;
    //     });
});