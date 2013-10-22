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
//  $obj_conexao->query(
//          //TODO tratamento do tipo BLOB
//          "INSERT INTO teologia(curso, instituicao, duracao, anexos)
//            VALUES('".$data->teologia->curso."','"
//              .$data->teologia->instituicao."','"
//              .$data->teologia->duracao."',"
//              .$data->teologia->anexos.");"
//  );
  try{
    $date = date_create_from_format('Y-m-d', $data->cargo->data_consagracao );
    $id_cargo = $obj_conexao->query('SELECT id_cargo FROM cargo WHERE '
            . 'cargo="'.$data->cargo->cargo.'" AND '
//            .'data_consagracao ="'.$date->format('Y-m-d').'" AND '
            . 'igreja="'.$data->cargo->igreja.'"');
    
    $array = mysql_fetch_assoc($id_cargo);
    $nr_linhas = mysql_num_rows($id_cargo);
  }  catch (Exception $e ) {
    echo $e.'Erro em adicionar chave estrangeira de cargo';
  }
  $obj_conexao->desconectar();
//  echo  $nr_linhas;
  echo  $date;
  return json_encode($array);
//  return $id_cargo;
});


print $r3->run();
