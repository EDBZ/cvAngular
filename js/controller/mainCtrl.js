app.controller('mainCtrl', function($scope, $http, $route, ModalService, getjson) {

  // modale=======================================================================
  $scope.showComplex = function() {

    ModalService.showModal({
        templateUrl: "views/modal-login.html",
        controller: "modalCtrl"
      })
      .then(function(modal) {
        modal.element.modal();
        modal.close.then(function(result) {
          $scope.complexResult = "Name: " + result.name + ", age: " + result.age;
        });
      });

  };

  // $scope globaux=================================================================
  $scope.categorieName = [{
    'human_name': 'ERG',
    'read_name': 'erg'
  }, {
    'human_name': 'CFE',
    'read_name': 'cfe'
  }, {
    'human_name': 'Customer Visit',
    'read_name': 'customer_visit'
  }, {
    'human_name': 'Charity',
    'read_name': 'charity'
  }, {
    'human_name': 'Internal',
    'read_name': 'internal'
  }];

  // includes==============================================

  $scope.header = {
    name: "header.html",
    url: "../views/header.html"
  };

  $scope.menu_gallery = {
    name: "menu_gallery.html",
    url: "../views/menu_gallery.html"
  };

  $scope.upload = {
    name: "upload.html",
    url: "../views/upload.html"
  };

  $scope.suppr = {
    name: "suppr.html",
    url: "../views/suppr.html"
  };

});
