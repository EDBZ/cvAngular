app.controller('galCtrl', ['$scope', 'getjson', '$routeParams', function($scope, getjson, $routeParams) {
$scope.galerie = $routeParams.galerie;
$scope.s_categorie = $routeParams.s_categorie;
$scope.categorie = $routeParams.categorie

  getjson.recupdata('/../data/'+$scope.categorie+'/'+$scope.s_categorie+'/'+$scope.galerie+'.json')
    .success(function(data) {
      $scope.images = data;
    });
  $scope.reloadRoute = function() {
    $window.location.reload();
  }
}])
