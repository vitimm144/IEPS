'use strict';

angular.module('IEPSApp')
  .controller('ListarmembrosCtrl', function ($scope, Restangular, Membros) {
     
     //Definição de variáveis        
     $scope.membros = Membros;
     $scope.search="";
     
     //Listener para atualizar os dados da tabela de membros apos
     //cadastro ou atualização de um cadastro.
     $scope.$on('update', function(){
       Restangular.all('membros').getList().then(function(data){
         $scope.membros = data;
       });
     });
     
     
  });