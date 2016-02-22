// script.js

    // create the module and name it githubLocal
        // also include ngRoute for all our routing needs
    var githubLocal = angular.module('githubLocal', ['ngRoute', 'rzModule', 'ngMessages']);

    // configure our routes
    githubLocal.config(function($routeProvider) {
        $routeProvider
            // route for the home page
            .when('/', {
                templateUrl : '/presentation/partials/searchFilters.html',
                controller  : 'filterController'
            })
            .when('/repo/:id', {
                templateUrl : '/presentation/partials/singleOutput.html',
                controller  : 'singleOutputController'
            })
            .when('/repos/', {
                templateUrl : '/presentation/partials/allOutput.html',
                controller  : 'multipleOutputController'
            })
            .when('/notfound/',{
              templateUrl : '/presentation/partials/notfound.html',
              controller  : ''
            })
    });
