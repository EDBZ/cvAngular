app.controller('supprCtrl', ng(function($scope, $http, getjson) {
  $scope.angularGridOptions = {
    gridWidth: 100,
    gutterSize: 5,
    refreshOnImgLoad: true
  };
  getjson.recupdata('../php/recupimages.php')
    .success(function(data) {
      $scope.images = data;
      $scope.galerie = _.uniq(_.pluck($scope.images, 'galerie'));
      console.log($scope.galerie);
    });
  getjson.recupdata('../php/recuplanguages.php')
    .success(function(data) {
      $scope.languages = data;
    });
  getjson.recupdata('../php/recupprojet.php')
    .success(function(data) {
      $scope.projets = data;
    });


  $scope.get_photos = function() {
    $('#pht')
      .css('visibility', 'invisible');

    var gal = $('input[type=radio][name=choix_gal]:checked')
      .attr('value');
    $scope.photos = _.where($scope.images, {
      galerie: gal
    });
    console.log($scope.photos);
    $('#pht')
      .css('visibility', 'visible')
      .addClass('anim');
  };




  $scope.suppr_photo = function() {

    var retVal = confirm("Do you want to continue ?");
    if (retVal == true) {

      return true;
    } else {
      return false;
    }
  }
}));
