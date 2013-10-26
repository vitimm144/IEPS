<?php

include ( 'conexao.php' );
require 'vendor/autoload.php';
    
ini_set("display_errors", 1);

session_start();

use Respect\Rest\Router;

$r3 = new Router('/api');

$r3->any('/connect', function(){
  $obj_conexao = new conexao();
  if(!$obj_conexao){
    die ('Sem conexao com o banco');
  }
  $obj_conexao->desconectar();
});
$r3->post('/cadastro', function(){
  $obj_conexao = new conexao();
  
  if(!$obj_conexao){
    die ('Sem conexao com o banco');
  }
  $data = json_decode(file_get_contents('php://input'));
  header('HTTP/1.1 200 Ok');
  //TODO ver questao de codificação de caracteres no banco !!!!!!
  $obj_conexao->query(
          "INSERT INTO contato(residencial, celular1, celular2, email, facebook)
            VALUES('".$data->contato->residencial."','"
              .$data->contato->celular1."','"
              .$data->contato->celular2."','"
              .$data->contato->email."','"
              .$data->contato->facebook."');"
  );
  $obj_conexao->query(
          "INSERT INTO endereco(logradouro, numero, bairro, complemento, cep)
            VALUES('".$data->endereco->logradouro."','"
              .$data->endereco->numero."','"
              .$data->endereco->bairro."','"
              .$data->endereco->complemento."','"
              .$data->endereco->cep."');"
  );
  $obj_conexao->query(
          "INSERT INTO cargo(cargo, data_consagracao, igreja, cidade)
            VALUES('".$data->cargo->cargo."','"
              .$data->cargo->data_consagracao."','"
              .$data->cargo->igreja."','"
              .$data->cargo->cidade."');"
  );
  
  $obj_conexao->query(
          "INSERT INTO historico_familiar(estado_civil, data_casamento, nome_conjuje, filhos, nr_filhos)
            VALUES('".$data->historico_familiar->estado_civil."','"
              .$data->historico_familiar->data_casamento."','"
              .$data->historico_familiar->nome_conjuje."',"
              //TODO tratamento do campo boolean armazenar no banco 0 ou 1
              .$data->historico_familiar->filhos.","
              .$data->historico_familiar->nr_filhos.");"
  );
  $obj_conexao->query(
          //TODO tratamento do tipo BLOB
          "INSERT INTO teologia(curso, instituicao, duracao, anexos)
            VALUES('".$data->teologia->curso."','"
              .$data->teologia->instituicao."','"
              .$data->teologia->duracao."',"
              .$data->teologia->anexo.");"
  );
  try{
    date_default_timezone_set('UTC');
    $date = new DateTime( $data->cargo->data_consagracao );
    $id_cargo = $obj_conexao->query( 'SELECT id_cargo FROM cargo WHERE '
            . 'cargo="'.$data->cargo->cargo.'" AND '
            . 'data_consagracao ="'.$date->format( 'Y-m-d' ).'" AND '
            . 'igreja="'.$data->cargo->igreja.'"' );
    $array = mysql_fetch_assoc( $id_cargo );
    $nr_linhas = mysql_num_rows( $id_cargo );
    $id_cargo_1 = $array['id_cargo'];
  }  catch ( Exception $e ) {
    echo $e.'Erro em buscar chave estrangeira de cargo';
  }
  $obj_conexao->query(
    "INSERT INTO historico_eclesiastico(data_conversao, data_batismo, id_cargo)
      VALUES('".$data->historico_eclesiastico->data_conversao."','"
        .$data->historico_eclesiastico->data_batismo."',"
        .$id_cargo_1.");"
  );
  
  $obj_conexao->desconectar();
echo $data->teologia->anexo;
return json_encode( $array['id_cargo'] );
//  return $date;
});


print $r3->run();
