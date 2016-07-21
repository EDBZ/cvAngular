var underscore = angular.module('underscore', []);
underscore.factory('_', function() {
  return window._; //Underscore should be loaded on the page
});

var app = angular.module('mainApp', ['ngRoute', 'ngAnimate', 'ngFileUpload', 'underscore', 'angular-loading-bar', 'angularGrid', 'angularModalService'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/', {
      templateUrl: 'views/main_gallery.html',
      controller: 'mainCtrl',
    })
    .when('/:categorie', {
      templateUrl: 'views/categorie.html',
      controller: 'catCtrl'
    })
    .when('/:categorie/:s_categorie/:galerie', {
      templateUrl: 'views/galerie.html',
      controller: 'galCtrl'
    })
    .when('/admin/admin', {
      templateUrl: 'views/admin.html'
    })
    .otherwise({
      redirectTo: '/'
    })
}]);
