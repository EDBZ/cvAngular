app.controller('main_gal_Ctrl', [
  '$scope', '$element',  '$location', 'getjson','ModalService',
  function($scope, $element,  $location, getjson, ModalService) {

  $scope.modalgallery = function() {

    ModalService.showModal({
        templateUrl: "views/modalgallery.html",
        controller: "modalgalCtrl"
      })
      .then(function(modal) {
        modal.element.modal();
        modal.close.then(function(result) {
          $scope.complexResult = "Name: " + result.name + ", age: " + result.age;
        });
      });

  };

// recup des dernières images de chaque galerie===============================================================
  $scope.last_img_gal = [];

  for (var i = 0; i < $scope.categorieName.length; i++) { //pour chaque categorie...
    var cat = $scope.categorieName[i].read_name
    getjson.recupdata('/../data/' + cat + '.json')
      .success(function(data) {
        categorie = data; //...on recupère les données json
        s_path = getjson.recupPathJson(categorie);
        // console.log(s_path);
        s_categorie = [];
        for (var prop in s_path) {
          getjson.recupdata(s_path[prop])
            .success(function(data) {
              gal = data;
              // console.log(s_cat);
              g_path = getjson.recupPathJson(gal);
              getjson.recupdata(g_path[0])
                .success(function(data) {
                  photo = data;
                  // console.log(photo);
                  $scope.last_img_gal.push({
                    date: photo[0].date_ajout_photo,
                    path: photo[0].info_photo.path,
                    photographe: photo[0].info_photo.photographe,
                    categorie: photo[0].info_photo.categorie,
                    s_categorie: photo[0].info_photo.s_categorie,
                    galerie: photo[0].info_photo.galerie
                  });
                  $scope.last_img_gal = _.sortBy($scope.last_img_gal, 'date');
                  $scope.last_img_gal.reverse();
                  // if ($scope.last_img_gal.length > 20) {
                  //   $scope.last_img_gal.splice(20, 1)
                  // }
                })
            })
        }
      });
  };
}]);
