app.controller('uploadCtrl', ng(function($scope, Upload, $timeout, $http) {

  $scope.uploadFiles = function(files) {
    if (files && files.length) {
      $scope.files = files;
      Upload.upload({
          url: './php/uploadphotos.php',
          method: 'POST',
          file: files,
          data: {
            galerie: $scope.galerie,
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
          $scope.progressP =
            Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    }
  };

  $scope.submit = function() {
    $scope.uploadFiles($scope.files)
  };


}));
