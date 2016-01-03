var app = angular.module("homeApp", ['ui.tinymce','ngSanitize']);
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

app.value('uiTinymceConfig', {
	menubar:false,
	footer:false
});

app.directive('comments', ['$http', function($http){
    return{
        restrict: 'A',
        templateUrl: '../../templates/comments.html',
        link: function(scope, element, attrs){
            var articlePath = attrs.articlePath;
            scope.comment  = {};

            $http.get('../../scripts/comments.php?articlePath='+articlePath)
                .then(function(result){

                    scope.comments = result.data;
                });
            scope.update = function(comment){
                var ts = new Date();
                comment.timestamp = ts.toJSON();
                $http.post('../../scripts/comments.php?articlePath='+articlePath, comment)
                    .then(function(success){
                        console.log(success.data);
                        if (success.status == 200){
                             $http.get('../../scripts/comments.php?articlePath='+articlePath)
                            .then(function(result){
                                scope.comments = result.data;
                                scope.errorMessage = "";
                            });
                        }
                        else {
									scope.errorMessage = success.data;                        
                        }
                    },
                    function(error){
								scope.errorMessage = error.data;                    
                    });
            }
        }
    }
}]);
