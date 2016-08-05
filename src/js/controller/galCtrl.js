app.controller('galCtrl', ng(function($scope, getjson, $routeParams) {
  $scope.galerie = $routeParams.galerie;

  $scope.pageClass = 'pageGal';

  getjson.recupdata('../php/recupimages.php')
    .success(function(data) {

      $scope.images = data;
      $scope.images = _.where($scope.images, {
        galerie: $scope.galerie
      })

    });
}));
