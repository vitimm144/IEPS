'use strict';

describe('Controller: HallmenbrosCtrl', function () {

  // load the controller's module
  beforeEach(module('IEPSApp'));

  var HallmenbrosCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    HallmenbrosCtrl = $controller('HallmenbrosCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
