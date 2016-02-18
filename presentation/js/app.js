// script.js

    // create the module and name it scotchApp
        // also include ngRoute for all our routing needs
    var scotchApp = angular.module('scotchApp', ['ngRoute']);

    // configure our routes
    scotchApp.config(function($routeProvider) {
        $routeProvider
            // route for the home page
            .when('/', {
                templateUrl : '/presentation/partials/allOutput.html',
                controller  : 'mainController'
            })
            .when('/repo/:id', {
                templateUrl : '/presentation/partials/singleOutput.html',
                controller  : 'singleOutputController'
            })
    });

    // create the controller and inject Angular's $scope
    scotchApp.controller('mainController', function($scope,$http) {
        // create a message to display in our view
        //$scope.messages = [];
        $http.get("/controllers/singleIdController.php")
        .then(function(responce){
          $scope.messages = responce.data.records;
        });
    });
    scotchApp.controller('singleOutputController', function($scope,$http,$routeParams) {
        $http.get("/controllers/singleIdController.php?id=" + $routeParams.id + "&single=true")
        .then(function(responce){
          $scope.messages = responce.data.records;
        });
    });
