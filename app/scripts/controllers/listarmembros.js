'use strict';

angular.module('IEPSApp')
  .controller('ListarmembrosCtrl', function ($scope, Restangular, Membros) {
     
     $scope.membros = Membros;
     $scope.search;
     
  });