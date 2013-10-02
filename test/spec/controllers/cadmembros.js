'use strict';

describe('Controller: CadmembrosCtrl', function () {

  // load the controller's module
  beforeEach(module('IEPSApp'));

  var CadmembrosCtrl,   
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CadmembrosCtrl = $controller('CadmembrosCtrl', {
      $scope: scope
    });
  }));

  it('verificar definição da função salvar', function () {
    expect(scope.salvar).toBeDefined();
    
  });
  it('verificar definição do objeto cadastro', function () {
    expect(scope.cadastro).toBeDefined();
  });
});
