'use strict';

angular.module('IEPSApp', ['restangular','ngRoute'])
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
      .when('/listarmembros', {
        templateUrl: 'views/listarmembros.html',
        controller: 'ListarmembrosCtrl',
        resolve:{
          Membros:[ 'Restangular', '$q', function(Restangular,$q){
            var deferred = $q.defer();
            Restangular.all('membros').getList().then(function(data){
              deferred.resolve(data);
            });
            return deferred.promise;
          }]
        }
      })
      .otherwise({
        redirectTo: '/'
      });
  });