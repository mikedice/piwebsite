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

app.directive('pressureGraph', ['$http', function($http){
    return{
        restrict: 'A',
        templateUrl: 'templates/pressureGraph.html',
        link: function(scope, element, attrs){
            $http.get('data/barometerGraphViewModel.json')
                .then(function(result){
                    scope.graphSegments = result.data.graphSegments;
                    scope.max = result.data.max;
                    scope.min = result.data.min;
                    scope.median = result.data.median;
                });
        }
    }
}]);
