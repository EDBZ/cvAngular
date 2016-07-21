app.controller('uploadCtrl', ['$scope', 'Upload', '$timeout', '$http', function($scope, Upload, $timeout, $http) {

  // recup EXIF =====================================================================
  $scope.getExif = function(files) {
    $scope.files = files;
    $scope.exif = new Array();
    angular.forEach(files, function(file) {
      EXIF.getData(file, function() {
        var tags = EXIF.getAllTags(this);
        $scope.exif.push({
          'marque': tags.Make,
          'modele': tags.Model,
          'iso': tags.ISOSpeedRatings,
          'fnumber': tags.FNumber,
          'vit_obt': '1/' + Math.pow(tags.ExposureTime, -1),
          'datePDV': tags.DateTimeOriginal
        });
      });
    });
    return $scope.exif;
  };

  //titres=====================================================
  // $scope.titres = new Array();
  // $scope.getTitres = function(files) {
  //   $scope.files = files;
  //   return $scope.titres;
  // };

  // upload=======================================================
  $scope.uploadFiles = function(files) {
    if (files && files.length) {
      $scope.files = files;
      Upload.upload({
          url: './php/upload.php',
          method: 'POST',
          file: files,
          data: {
            categorie: $scope.lcategorie,
            s_categorie: $scope.s_categorie,
            galerie: $scope.galerie,
            user: $scope.user,
            exif: $scope.exif,
            // titre: $scope.titres
          }
        })
        .then(function(response) {
          $timeout(function() {
            $scope.result = response.data;
          });
        }, function(response) {
          if (response.status > 0) {
            $scope.errorMsg = response.status + ': ' + response.data;
          }
        }, function(evt) {
          $scope.progress =
            Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    }
  };

  // envoie des données par SUBMIT ================================================
  $scope.submit = function() {
    // $scope.getTitres($scope.files);
    $scope.uploadFiles($scope.files)
  };

}]);
