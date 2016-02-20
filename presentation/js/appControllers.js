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


scotchApp.controller("filterController", function($scope,$location,$http){
  $scope.slider = {
    min: 0,
    max: 50000,
    options: {
      floor: 0,
      ceil: 50000
    }
  };
  $scope.processForm = function() {
    $scope.formData = {};
    $http({
    method  : 'POST',
    url     : '/controllers/multipleController.php',
    data    : $.param($scope.formData),  // pass in data as strings
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
   })
    .success(function(data) {
      console.log(data);

      if (!data.success) {
        // if not successful, bind errors to error variables
        $scope.errorName = data.errors.name;
        $scope.errorSuperhero = data.errors.superheroAlias;
      } else {
        // if successful, bind success message to message
        $scope.message = data.message;
      }
    });
  };
  $scope.getLangs = function(){
    $http.get("/controllers/populateController.php")
    .then(function(responce){
      $scope.data = responce.data.records;
    });
  }
  /*** Single ID Search *********/
  $scope.idSpecificSubmit = function(){
    $location.path("/repo/" + $scope.idSpecific);
  }
});
