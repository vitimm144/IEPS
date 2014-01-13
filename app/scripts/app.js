'use strict';

angular.module('IEPSApp', ['restangular','ui.router'])
  .config(function ($stateProvider, $urlRouterProvider, RestangularProvider) {
    //configurações do restangular
    RestangularProvider.setBaseUrl('api');
    RestangularProvider.setRequestSuffix('\/');
    //#######################################

    $urlRouterProvider.otherwise('/');
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
  })
  //ui-router definitions
  .run(function ($rootScope, $state, $stateParams) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
  });