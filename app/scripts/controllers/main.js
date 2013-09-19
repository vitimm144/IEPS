'use strict';

angular.module('IEPSApp')
  .controller('MainCtrl', function ($scope, $http) {
    
    $http.get('api/connect').success(function(){
        console.log('conectou');
    }).error(function(){
        console.log('nao conectou');
    });
    $http.get('api/login').success(function(){
        console.log('conectou');
    }).error(function(){
        console.log('nao conectou');
    });
  });
