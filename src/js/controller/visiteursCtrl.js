app.controller('visiteursCtrl',ng(function($scope, $http, getjson) {

  getjson.recupdata('../php/recupvisiteurs.php')
    .success(function(data) {
      $scope.visiteurs = data;
      console.log($scope.visiteurs);
      // $scope.Visiteurs = _.indexBy($scope.Visiteurs, 'date_ajout');
    });

}));
