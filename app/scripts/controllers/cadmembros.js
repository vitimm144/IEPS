'use strict';
/*camelcase : false*/
angular.module('IEPSApp')
  .controller('CadmembrosCtrl', function (
  $scope,
  $rootScope,
  $state,
  Restangular,
  $stateParams
  ) {

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
      duracao : ''
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

    //caso o controller for usado pela tela de edição será feita uma
    //requisição ao servidor para pegar os dados do membro para serem
    //editados
    if($stateParams.id){
      Restangular.one('membros', $stateParams.id ).get().then(function(data){
        $scope.cadastro = data;
      });
    }

    $scope.salvar = function(){
      if($stateParams.id){
        $scope.cadastro.put().then(function(){
          $state.go('^');
          $rootScope.$broadcast('update');
        }, function(){
          console.error('Erro ao cadastrar');
        });
      }else{
        cadastro.post($scope.cadastro).then(function(data){
          $state.go('^');
          $rootScope.$broadcast('update');
          
        }, function(){
            console.error( 'nao salvou!');  
        });
      }
    };
  });
