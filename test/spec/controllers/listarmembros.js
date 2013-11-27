'use strict';

describe('Controller: ListarmembrosCtrl', function () {

  // load the controller's module
  beforeEach(module('IEPSApp'));

  var ListarmembrosCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ListarmembrosCtrl = $controller('ListarmembrosCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
