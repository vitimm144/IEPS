'use strict';
/*camelcase : false*/
angular.module('IEPSApp')
  .controller('CadmembrosCtrl', function ($scope, $http, Restangular) {
    $scope.cadastro = {};
    var cadastro = Restangular.all('cadastro');
    $scope.cadastro.membro = {
      nome : '',
      rg : '',
      profissao : '',
      sexo : '',
      tipo_sanguineo : '',
      data_nascimento : new Date(),
      nome_pai : '',
      nome_mae : ''
      
    };
    $scope.cadastro.teologia = {
      curso : '',
      instituicao : '',
      duracao : '',
      anexo : ''
    };
    $scope.cadastro.historico_familiar = {
      estado_civil : '',
      nome_conjuje : '',
      data_casamento : new Date(),
      filhos : false,
      nr_filhos : 0
    };
    $scope.cadastro.contato = {
      residencial : '',
      celular1 : '',
      celular2 : '',
      email : '',
      facebook : ''
    };
    $scope.cadastro.endereco = {
      logradouro : '',
      numero : '',
      bairro : '',
      complemento : '',
      cep : ''
    };
    $scope.cadastro.historico_eclesiastico = {
      data_conversao : new Date(),
      data_batismo : new Date()
    };
    $scope.cadastro.cargo = {
      cargo : '',
      data_consagracao : new Date(),
      igreja : '',
      cidade : ''
    };
    $scope.salvar = function(){
      console.log('entrou em salvar');
      cadastro.post($scope.cadastro).then(function(){
        console.log('salvou');
        console.log(data);
      }, function(){
          console.log( 'nao salvou ');  
      });
    };
  });
