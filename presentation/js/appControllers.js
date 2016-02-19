// create the controller and inject Angular's $scope
scotchApp.controller('mainController', function($scope,$http) {
    // create a message to display in our view
    //$scope.messages = [];
});
scotchApp.controller('singleOutputController', function($scope,$http,$routeParams) {
    $http.get("/controllers/singleIdController.php?id=" + $routeParams.id + "&single=true")
    .then(function(responce){
      $scope.messages = responce.data.records;
    });
});

scotchApp.controller('multipleOutputController', function($scope,$http) {
    $http.get("/controllers/multipleController.php")
    .then(function(responce){
      $scope.messages = responce.data.records;
    });
});


scotchApp.controller("filterController", function($scope,$location){
  $scope.slider = {
    min: 0,
    max: 50000,
    options: {
      floor: 0,
      ceil: 50000
    }
  };


  /*** Single ID Search *********/
  $scope.idSpecificSubmit = function(){
    $location.path("/repo/" + $scope.idSpecific);
  }
});
