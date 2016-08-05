var underscore = angular.module('underscore', []);
underscore.factory('_', function() {
  return window._; //Underscore should be loaded on the page
});

var app = angular.module('mainApp', ['ngRoute', 'ngAnimate', 'ngFileUpload', 'underscore', 'angular-loading-bar', 'angularGrid'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/', {
      templateUrl: 'views/enterview.html',
      controller: 'mainCtrl',
    })
    .when('/photographe', {
      templateUrl: 'views/photo.html',
      controller: 'photoCtrl'
    })

    .when('/developper', {
      templateUrl: 'views/dev.html',
      controller: 'devCtrl'
    })
    .when('/projets', {
      templateUrl: 'views/projets.html',
      controller: 'devCtrl'
    })

    .when('/photo/:galerie', {
      templateUrl: 'views/galerie.html',
      controller: 'galCtrl'
    })
    .when('/admin/admin', {
      templateUrl: 'views/admin.html'
    })
    .when('/contact', {
      templateUrl: 'views/contact.html',
      controller: 'contactCtrl'
    })
    .otherwise({
      redirectTo: '/'
    })
}]);
