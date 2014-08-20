'use strict';

describe('Controller: CadmembrosCtrl', function () {

  // load the controller's module
  beforeEach(module('IEPSApp'));
  
  var CadmembrosCtrl,   
    Restangular,
    cadastro,
    $httpBackend,
    $q,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope,
  _Restangular_, _$httpBackend_,_$q_,$templateCache) {
    scope = $rootScope.$new();
    Restangular = _Restangular_;
    $httpBackend = _$httpBackend_;
    $q = _$q_;
    $templateCache.put('view/main.html', 'app/view/main.html');
    cadastro = Restangular.all('cadastro');
    CadmembrosCtrl = $controller('CadmembrosCtrl', {
      $scope: scope 
    });
    $httpBackend.whenGET('views/main.html')
            .respond($templateCache.get('view/main.html'));
    $httpBackend.flush();
  }));
  afterEach(function() {
        $httpBackend.verifyNoOutstandingExpectation();
        $httpBackend.verifyNoOutstandingRequest();
  });

  it('verificar definição do objeto cadastro', function () {
    
    expect(scope.cadastro).toBeDefined();
    expect(scope.cadastro.membro).toBeDefined();
    expect(scope.cadastro.teologia).toBeDefined();
    expect(scope.cadastro.historico_familiar).toBeDefined();
    expect(scope.cadastro.contato).toBeDefined();
    expect(scope.cadastro.endereco).toBeDefined();
    expect(scope.cadastro.historico_eclesiastico).toBeDefined();
    expect(scope.cadastro.cargo).toBeDefined();
  });
  it('verificar se cadastro.membro possui os atributos corretos', function(){
    expect(scope.cadastro.membro.nome).toBeDefined();
    expect(scope.cadastro.membro.rg).toBeDefined();
    expect(scope.cadastro.membro.profissao).toBeDefined();
    expect(scope.cadastro.membro.sexo).toBeDefined();
    expect(scope.cadastro.membro.tipo_sanguineo).toBeDefined();
    expect(scope.cadastro.membro.data_nascimento).toBeDefined();
    expect(scope.cadastro.membro.nome_pai).toBeDefined();
    expect(scope.cadastro.membro.nome_mae).toBeDefined();
  });
  //TODO consertar teste
  xit('verificar se cadastro.teologia possui os atributos corretos', function () {
    expect(scope.cadastro.teologia.curso).toBeDefined();
    expect(scope.cadastro.teologia.instituicao).toBeDefined();
    expect(scope.cadastro.teologia.duracao).toBeDefined();
    expect(scope.cadastro.teologia.anexo).toBeDefined();
  });
  it('verificar se cadastro.historico_familiar possui os atributos corretos', function () {
    expect(scope.cadastro.historico_familiar.estado_civil).toBeDefined();
    expect(scope.cadastro.historico_familiar.nome_conjuje).toBeDefined();
    expect(scope.cadastro.historico_familiar.data_casamento).toBeDefined();
    expect(scope.cadastro.historico_familiar.filhos).toBeDefined();
    expect(scope.cadastro.historico_familiar.nr_filhos).toBeDefined();
  });
  it('verificar se cadastro.contato possui os atributos corretos', function () {
    expect(scope.cadastro.contato.residencial).toBeDefined();
    expect(scope.cadastro.contato.celular1).toBeDefined();
    expect(scope.cadastro.contato.celular2).toBeDefined();
    expect(scope.cadastro.contato.email).toBeDefined();
    expect(scope.cadastro.contato.facebook).toBeDefined();
  });
  it('verificar se cadastro.endereco possui os atributos corretos', function () {
    expect(scope.cadastro.endereco.logradouro).toBeDefined();
    expect(scope.cadastro.endereco.numero).toBeDefined();
    expect(scope.cadastro.endereco.bairro).toBeDefined();
    expect(scope.cadastro.endereco.complemento).toBeDefined();
    expect(scope.cadastro.endereco.cep).toBeDefined();
  });
  it('verificar se cadastro.historico_eclesiastico', function () {
    expect(scope.cadastro.historico_eclesiastico.data_conversao).toBeDefined();
    expect(scope.cadastro.historico_eclesiastico.data_batismo).toBeDefined();
  });
  it('verificar se cadastro.cargo', function () {
    expect(scope.cadastro.cargo.cargo).toBeDefined();
    expect(scope.cadastro.cargo.data_consagracao).toBeDefined();
    expect(scope.cadastro.cargo.igreja).toBeDefined();
    expect(scope.cadastro.cargo.cidade).toBeDefined();
  });
  it('verificar definição da função salvar', function () {
    expect(scope.salvar).toBeDefined();
  });
  xit('verificar se função salvar está fazendo requisição quando chamada', function () {
    spyOn(cadastro, 'post');
    spyOn(scope, 'salvar').andCallThrough();
    scope.cadastro = {abc:123};
    $httpBackend.expectPOST('api/cadastro').respond('ok');
    scope.salvar();
    $httpBackend.flush();
    expect(cadastro.post.calls.length).toBe(1);
  });
  
});
