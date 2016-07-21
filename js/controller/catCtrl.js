app.controller('catCtrl', ['$scope', 'getjson', '$routeParams', function($scope, getjson, $routeParams) {

  $scope.name = $routeParams.categorie;
  getjson.recupdata('/../data/'+$scope.name+'.json')
    .success(function(data) {
      $scope.categorie = data;
      s_path = getjson.recupPathJson($scope.categorie);
      $scope.s_categorie = [];
      for (var prop in s_path) {
        getjson.recupdata(s_path[prop])
          .success(function(data) {
            s_cat = data;
            g_path = getjson.recupPathJson(s_cat);
            $scope.s_categorie.push(g_path);
          })
      }
    });
  $scope.reloadRoute = function() {
    $window.location.reload();
  }

  $scope.divanim = function(path) {
    $('#galeries')
      .addClass('anim');
    getjson.recupdata(path)
      .success(function(data) {
        $scope.galeries = getjson.last_imgs(data);

      })
  }
}]);
