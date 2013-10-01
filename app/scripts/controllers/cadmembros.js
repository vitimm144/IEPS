'use strict';

angular.module('IEPSApp')
  .controller('CadmembrosCtrl', function ($scope) {
    $scope.membro = {
      nome : '',
      rg : '',
      profissao : '',
      sexo : '',
      tipo_sanguineo : '',
      data_nascimento : new Date(),
      nome_pai : '',
      nome_mae : ''
      
    };
    $scope.teologia = {
      curso : '',
      instituicao : '',
      duracao : '',
      anexo : ''
    };
    $scope.historico_familiar = {
      estado_civil : '',
      nome_conjuje : '',
      data_casamento : new Date(),
      filhos : false,
      nr_filhos : 0
    };
    $scope.contato = {
      residencial : '',
      celular1 : '',
      celular2 : '',
      email : '',
      facebook : ''
    };
    $scope.endereco = {
      logradouro : '',
      numero : '',
      bairro : '',
      complemento : '',
      cep : ''
    };
    $scope.historico_eclesiastico = {
      data_conversao : new Date(),
      data_batismo : new Date()
    };
    $scope.cargo = {
      cargo : '',
      data_consagracao : new Date(),
      igreja : '',
      cidade : ''
    };
  });
