app.controller('photoCtrl', ng(function($scope, getjson) {

  $scope.pageClass = 'pagePhoto';

  getjson.recupdata('../php/recupimages.php')
    .success(function(data) {

      $scope.images = data;
      $scope.images = _.indexBy($scope.images, 'galerie');
    });

}));
