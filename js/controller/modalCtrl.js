app.controller('modalCtrl', [
  '$scope', '$element', 'close', '$location',
  function($scope, $element, close, $location) {
  var authname = 'bob';
  var authpass = 'plop';
  $scope.name = null;
  $scope.password = null;

  $scope.login = function (){
    // $('.modal-backdrop').css('display','block');

    if ($scope.name == authname && $scope.password == authpass) {
      $('.modal-backdrop').css('display','none');
      $location.path('/admin/admin');
      close();
    }else{
      alert('bad');
      $('.modal-backdrop').css('display','none');
      $element.modal('hide');
      $location.path('/');
    }
  };
  //  This close function doesn't need to use jQuery or bootstrap, because
  //  the button has the 'data-dismiss' attribute.
  $scope.close = function() {
 	  close({
      name: $scope.name,
      password: $scope.password
    }, 500); // close, but give 500ms for bootstrap to animate
  };

  //  This cancel function must use the bootstrap, 'modal' function because
  //  the doesn't have the 'data-dismiss' attribute.
  $scope.cancel = function() {

    //  Manually hide the modal.
    $element.modal('hide');

    //  Now call close, returning control to the caller.
    close({
      name: $scope.name,
      password: $scope.password
    }, 500); // close, but give 500ms for bootstrap to animate
  };

}]);
