'use strict';

angular.module('IEPSApp', ['restangular'])
  .config(function ($routeProvider, RestangularProvider) {
    RestangularProvider.setBaseUrl('api');
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/cadmembros', {
        templateUrl: 'views/cadmembros.html',
        controller: 'CadmembrosCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
