angular.module('additionalServiceService', [API_URL])

    .factory('AdditionalServiceController', function($http) {
        return {
            get : function() {
                return $http.get(API_URL + 'services');
            }
        }
    });