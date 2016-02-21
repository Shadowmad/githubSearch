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

scotchApp.controller('multipleOutputController', function($scope,getFullListByFilter) {
    /*$http.get("/controllers/multipleController.php?date")
    .then(function(responce){
      $scope.messages = responce.data.records;
    });*/
    $scope.messages = {};
    var scope = $scope;
    getFullListByFilter.get().then(function(data) {
      scope.messages = data.data.records;
    });

});

scotchApp.factory('getFilters', ['$http', function($http){
  var getFiltersFactory = {};
  getFiltersFactory.data = '';

  getFiltersFactory.set = function(sendingVar){
    this.data = sendingVar;
    return this.data;
  }
  getFiltersFactory.get = function(){
    return this.data;
  }
  return getFiltersFactory;

}]);

scotchApp.factory('getFullListByFilter', ['$http','getFilters', function($http, getFilters) {
  var getFullListByFilterFactory = {};

  getFullListByFilterFactory.data = '';
  getFullListByFilterFactory.filter = '';

  getFullListByFilterFactory.getFilter = function(){
    this.filter = getFilters.get();
    return this.filter;
  }
  getFullListByFilterFactory.load = function() {
    this.getFilter();
    /*this.data = $http.get('/controllers/multipleController.php').then(function(data) {
      return data;
    });*/
    this.data = $http({
      method: "post",
      url: "/controllers/multipleController.php",
      data: this.filter,
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function(data){
      return data;
    });
    return this.data;
  };

  getFullListByFilterFactory.get = function() {
    return this.data === '' ? this.load() : this.data;
  };

  return getFullListByFilterFactory;
}]);


scotchApp.controller("filterController", function($scope,$http,$location, getFilters){
  $scope.itemsDateSelect =  [
                              {name: 'allDates', value:'Select all dates'},
                              {name: 'beforeDates', value:'Select dates before'},
                              {name: 'afterDates', value:'Select dates after'},
                              {name: 'rangeDates', value:'Select range of dates'},
                            ]


  $scope.filterData = {};
  $scope.filterData.slider = {
    minValue: 0,
    maxValue: 50000,
    options: {
      floor: 0,
      ceil: 50000
    }
  };

  var scope = $scope;
  $scope.processForm = function() {
      getFilters.set($scope.filterData);
      $location.path("/repos/");
  }


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
