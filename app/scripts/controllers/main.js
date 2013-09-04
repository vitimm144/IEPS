'use strict';

angular.module('IEPSApp')
  .controller('MainCtrl', function ($scope, $http) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
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
