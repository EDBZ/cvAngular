app.controller('supprCtrl', ['$scope', '$http', 'getjson', function($scope, $http, getjson) {
  $scope.angularGridOptions = {
      gridWidth: 200,
      gutterSize: 10,
      refreshOnImgLoad: false
    }


    // recup info suppr==============================================================
  $scope.get_s_cat1 = function() {
    var cat1 = $('input[type=radio][name=choix1]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat1 + '.json')
      .success(function(data) {
        $scope.s_categorie1 = data;
      });
    $('#s_cat1')
      .css('visibility', 'visible')
      .addClass('anim');;
  };
  $scope.get_s_cat2 = function() {
    var cat2 = $('input[type=radio][name=choix2]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat2 + '.json')
      .success(function(data) {
        $scope.s_categorie2 = data;
      });
    $('#s_cat2')
      .css('visibility', 'visible')
      .addClass('anim');
    $('#gal2')
      .css('visibility', 'hidden')
      .removeClass('anim');;
  };

  $scope.get_gal2 = function() {
    var cat2 = $('input[type=radio][name=choix2]:checked')
      .attr('value');
    var s_cat2 = $('input[type=radio][name=choix_s_cat2]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat2 + '/' + s_cat2 + '.json')
      .success(function(data) {
        $scope.galerie2 = data;
      });
    $('#gal2')
      .css('visibility', 'visible')
      .addClass('anim');;
  }

  $scope.get_s_cat3 = function() {
    var cat3 = $('input[type=radio][name=choix3]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat3 + '.json')
      .success(function(data) {
        $scope.s_categorie3 = data;
      });
    $('#s_cat3')
      .css('visibility', 'visible')
      .addClass('anim');
    $('#gal3')
      .css('visibility', 'hidden')
      .removeClass('anim');
    $('#pht3')
      .css('visibility', 'hidden');
  };

  $scope.get_gal3 = function() {
    var cat3 = $('input[type=radio][name=choix3]:checked')
      .attr('value');
    var s_cat3 = $('input[type=radio][name=choix_s_cat3]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat3 + '/' + s_cat3 + '.json')
      .success(function(data) {
        $scope.galerie3 = data;
      });
    $('#gal3')
      .css('visibility', 'visible')
      .addClass('anim');
    $('#pht3')
      .css('visibility', 'hidden');

  };

  $scope.get_photos = function() {
    var cat3 = $('input[type=radio][name=choix3]:checked')
      .attr('value');
    var s_cat3 = $('input[type=radio][name=choix_s_cat3]:checked')
      .attr('value');
    var gal3 = $('input[type=radio][name=choix_gal3]:checked')
      .attr('value');
    getjson.recupdata('/../data/' + cat3 + '/' + s_cat3 + '/' + gal3 + '.json')
      .success(function(data) {
        $scope.photos3 = data;
      });
    $('#pht3')
      .css('visibility', 'visible');
  };




  // fonctions de suppressions=====================================================
  $scope.suppr_s_cat = function() {

    var retVal = confirm("Do you want to continue ?");
    if (retVal == true) {

  return true;
} else {
  return false;
}
};
}]);
