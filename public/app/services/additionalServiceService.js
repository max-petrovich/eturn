angular.module('additionalServiceService', [API_URL])

    .factory('AdditionalService', function($http) {
        return {
            get : function() {
                return $http.get(API_URL + 'services');
            }
        }
    });