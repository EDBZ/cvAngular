app.controller('mainCtrl',ng(function($scope, $http, $route, getjson, $location) {

  $scope.go = function(path) {
    $location.path(path);
  };


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

  $scope.visiteurs = {
    name: "visiteurs.html",
    url: "../views/visiteurs.html"
  };

}));
