'use strict';

angular.module('IEPSApp', [])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/hallmembros', {
        templateUrl: 'views/cadmembros.html',
        controller: 'CadmembrosCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
