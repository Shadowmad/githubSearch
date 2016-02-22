// create the controller and inject Angular's $scope
scotchApp.controller('singleOutputController', function($scope,$http,$routeParams, $location) {
    $http.get("/controllers/singleIdController.php?id=" + $routeParams.id + "&single=true")
    .then(function(responce){
        if(responce.data.records == ""){
          $location.path("/notfound/");
        }else{
          $scope.messages = responce.data.records;
        }
      });
});

scotchApp.controller('multipleOutputController', function($scope,$location,getFullListByFilter) {
    /*$http.get("/controllers/multipleController.php?date")
    .then(function(responce){
      $scope.messages = responce.data.records;
    });*/
    $scope.messages = {};
    var scope = $scope;
    getFullListByFilter.get().then(function(data) {
      if(data.data.records == ""){
        $location.path("/notfound/");
      }else{
        scope.messages = data.data.records;
      }

    });

});

scotchApp.factory('getFilters', [function(){
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
scotchApp.factory('updateDataInDBFactory',['$http', function($http){
  var setupdateDataInDB = {};
  setupdateDataInDB.data = '';
  setupdateDataInDB.status = '';
  setupdateDataInDB.setProcessUpdate = function(){
    this.data = $http.put("/api/dataEntryConnector.php")
    .then(function(data){
      return data;
    });
    return this.data;
  }
  return setupdateDataInDB;
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
    console.log(this.filter);
    this.data = $http({
      method: "post",
      url: "/controllers/multipleController.php",
      data: this.filter,
      headers: {'Content-Type': 'application/json'}
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


scotchApp.controller("filterController", function($scope,$location, getFilters,updateDataInDBFactory, getFullListByFilter){
  $scope.itemsDateSelect =  [
                              {name: 'beforeDates', value:'Select dates before'},
                              {name: 'afterDates', value:'Select dates after'},
                              {name: 'rangeDates', value:'Select range of dates'},
                            ]
  $scope.itemsLangSelect =  [
                              {name: 'php', value:'PHP'}
                            ]


  $scope.filterData = {};
  $scope.filterData.slider = {
    minValue: 0,
    maxValue: 50000,
    options: {
      floor: 0,
      ceil: 50000,
      translate: function (value) {
        return value +' Stars ';
      }
    }
  };
  var scope = $scope;
  $scope.processForm = function() {
      getFilters.set($scope.filterData);
      getFullListByFilter.load();
      $location.path("/repos/");
  }
  /*** Single ID Search *********/
  $scope.idSpecificSubmit = function(){
    $location.path("/repo/" + $scope.idSpecific);
  }

  /**** Update data in db **/
  $scope.updateDataInDB = function(){
    updateDataInDBFactory.setProcessUpdate().then(function(data){
      if(data.statusText == "OK")
        $scope.updateResp = "Everything went well! Now you will get up-to-date info when you do your search! :)";
      else {
        $scope.updateResp = "Sorry, there was an error, please try again later.";
      }
    });
  }
});
