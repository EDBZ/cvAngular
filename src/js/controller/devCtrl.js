app.controller('devCtrl', ng(function($scope, getjson) {

  $scope.pageClass = 'pageDev';

  getjson.recupdata('../php/recupprojet.php')
    .success(function(data) {
      $scope.projets = data;
    });

  getjson.recupdata('../php/recuplanguages.php')
    .success(function(data) {
      $scope.languages = data;
    });
}));
