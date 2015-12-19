var app = angular.module("homeApp", []);
app.directive('weatherData', ['$http', function($http){
    return{
	restrict: 'A',
        link: function(scope, element, attrs){
            $http.get('data/weather.json')
                .then(function(result) {
                    scope.tempF = result.data.TempF;
                    scope.pressureMb = result.data.PressureMb;
                 });
        }
    }
}]);
