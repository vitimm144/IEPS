<?php

include ( 'conexao.php' );
require 'vendor/autoload.php';
    
ini_set("display_errors", 1);

session_start();
date_default_timezone_set('UTC');
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
          echo $data->teologia->anexo;
  $obj_conexao->query(
          //TODO tratamento do tipo BLOB
          "INSERT INTO teologia(curso, instituicao, duracao)
            VALUES('".$data->teologia->curso."','"
              .$data->teologia->instituicao."','"
              .$data->teologia->duracao."');"
//              .$data->teologia->anexo.");"
  );
  try{
    
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
  //buscando ids para inserir dados pessoais
  try {
    
    $id_endereco = $obj_conexao->query(
      'SELECT id_endereco FROM endereco WHERE '
      . 'logradouro="'.$data->endereco->logradouro.'" AND '
      . 'numero ="'.$data->endereco->numero.'" AND '
      . 'bairro ="'.$data->endereco->bairro.'"'        
            
    );
    $endereco = mysql_fetch_assoc( $id_endereco );
    $id_endereco = $endereco['id_endereco'];
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }

  try {
    $id_teologia = $obj_conexao->query(
      'SELECT id_teologia FROM teologia WHERE '
      . 'curso="'.$data->teologia->curso.'" AND '
      . 'instituicao ="'.$data->teologia->instituicao.'" AND '
      . 'duracao ="'.$data->teologia->duracao.'"'
    );
    $teologia = mysql_fetch_assoc( $id_teologia );
    $id_teologia1 = $teologia['id_teologia'];

  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  try {
    $id_contato = $obj_conexao->query(
      'SELECT id_contato FROM contato WHERE '
      . 'residencial="'.$data->contato->residencial.'" OR '
      . 'celular1="'.$data->contato->celular1.'"'
    );
    $contato = mysql_fetch_assoc( $id_contato );
    $id_contato1 = $contato['id_contato'];
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  
  try {
    $data_casamento = new DateTime( $data->historico_familiar->data_casamento );
    $id_historico_familiar = $obj_conexao->query(
      'SELECT id_historico_familiar FROM historico_familiar WHERE '
      . 'estado_civil="'.$data->historico_familiar->estado_civil.'" AND '
      . 'data_casamento ="'.$data_casamento->format( 'Y-m-d' ).'" AND '
      . 'nome_conjuje="'.$data->historico_familiar->nome_conjuje.'"'
    );
    $historico_familiar = mysql_fetch_assoc( $id_historico_familiar);
    $id_historico_familiar1 = $historico_familiar['id_historico_familiar'];
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }


  $obj_conexao->desconectar();
//  echo $data->teologia->anexo;
return json_encode($historico_familiar['id_historico_familiar']);
});


print $r3->run();
