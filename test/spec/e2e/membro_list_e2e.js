'use strict';

describe('Testes da view de listagem de membros', function(){
  beforeEach(function(){
    browser.get('http://localhost:9000/#/membros');
  });
  
  it('Deve mostrar listagem de membros', function(){
    element.all(by.repeater('membro in membros | filter:search'))
      .then(function(array){
        expect(array.length).toEqual(8);
      });
  });
});


