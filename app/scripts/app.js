'use strict';

angular.module('IEPSApp', ['restangular','ngRoute','ui.router'])
  .config(function ($stateProvider, $urlRouterProvider, RestangularProvider) {
    RestangularProvider.setBaseUrl('api');
    
    $urlRouterProvider.otherwise("/");
    $stateProvider
      .state('main', {
        url: '/',
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })

      .state('membros', {
        url:'/membros',
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
      .state('membros.new', {
        url: '/new',
        templateUrl: 'views/cadmembros.html',
        controller: 'CadmembrosCtrl'
      })
      .state('membros.edit', {
        url:'/:id',
        templateUrl: 'views/cadmembros.html',
        controller: 'CadmembrosCtrl'
      });
  });