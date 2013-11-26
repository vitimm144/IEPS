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

//retorna um array contendo todos os usuários
//cadastrados no sistema

$r3->get('/membros', function(){
  $obj_conexao = new conexao();
  header('HTTP/1.1 200 Ok');
  $get_membros = $obj_conexao->query(
      'SELECT * FROM dados_pessoais'
  );
  $membros = array();
  while ( $aux = mysql_fetch_assoc($get_membros)){
    $membros[] = $aux; 
  }
  return json_encode($membros);
});


//********************************
//requisição de cadastro de membros
//********************************


$r3->post('/cadastro', function(){
  $obj_conexao = new conexao();
  
  if(!$obj_conexao){
    die ('Sem conexao com o banco');
  }
  $data = json_decode(file_get_contents('php://input'));
  header('HTTP/1.1 200 Ok');
  //TODO ver questao de codificação de caracteres no banco !!!!!!
  $errorInsertContato =  $obj_conexao->query(
          "INSERT INTO contato(residencial, celular1, celular2, email, facebook)
            VALUES('".$data->contato->residencial."','"
              .$data->contato->celular1."','"
              .$data->contato->celular2."','"
              .$data->contato->email."','"
              .$data->contato->facebook."');"
  );
  
  if( $errorInsertContato == false ) {
    echo 'erro em inserir contato';
  }
  $errorInsertEndereco = $obj_conexao->query(
          "INSERT INTO endereco(logradouro, numero, bairro, complemento, cep)
            VALUES('".$data->endereco->logradouro."','"
              .$data->endereco->numero."','"
              .$data->endereco->bairro."','"
              .$data->endereco->complemento."','"
              .$data->endereco->cep."');"
  );
  if( $errorInsertEndereco == false ) {
    echo 'erro em inserir endereco';
  }
  
  $errorInsertCargo = $obj_conexao->query(
          "INSERT INTO cargo(cargo, data_consagracao, igreja, cidade)
            VALUES('".$data->cargo->cargo."','"
              .$data->cargo->data_consagracao."','"
              .$data->cargo->igreja."','"
              .$data->cargo->cidade."');"
  );
  if( $errorInsertCargo == false ) {
    echo 'erro em inserir cargo';
  }
  //verificar estado civil
   
  //Tratamento campo boolean pois o mysql não aceita tipo boolean
  if ( $data->historico_familiar->filhos === true ) {
    $data->historico_familiar->filhos = 1;
  } else {
    $data->historico_familiar->filhos = 0;
  }
  
  $errorInsertHistFamiliar = $obj_conexao->query(
          "INSERT INTO historico_familiar(estado_civil, data_casamento, nome_conjuje, filhos, nr_filhos)
            VALUES('".$data->historico_familiar->estado_civil."','"
              .$data->historico_familiar->data_casamento."','"
              .$data->historico_familiar->nome_conjuje."',"
              //TODO tratamento do campo boolean armazenar no banco 0 ou 1
              .$data->historico_familiar->filhos.","
              .$data->historico_familiar->nr_filhos.");"
  );
  if( $errorInsertHistFamiliar == false ) {
    echo 'erro em inserir historico familiar';
  }
  $errorInsertTeologia = $obj_conexao->query(
          //TODO tratamento do tipo BLOB
          "INSERT INTO teologia(curso, instituicao, duracao)
            VALUES('".$data->teologia->curso."','"
              .$data->teologia->instituicao."','"
              .$data->teologia->duracao."');"
//              .$data->teologia->anexo.");"
  );
  if( $errorInsertTeologia == false ) {
    echo 'erro em inserir teologia';
  }
  
  
  try{
    
    $date = new DateTime( $data->cargo->data_consagracao );
    $id_cargo = $obj_conexao->query( 'SELECT id_cargo FROM cargo WHERE '
            . 'cargo="'.$data->cargo->cargo.'" AND '
            . 'data_consagracao ="'.$date->format( 'Y-m-d' ).'" AND '
            . 'igreja="'.$data->cargo->igreja.'"' );
    $array = mysql_fetch_assoc( $id_cargo );
    $id_cargo_1 = $array['id_cargo'];
    mysql_free_result($array);
  }  catch ( Exception $e ) {
    echo $e.'Erro em buscar chave estrangeira de cargo';
  }
  $errorInsertHistEcles = $obj_conexao->query(
    "INSERT INTO historico_eclesiastico(data_conversao, data_batismo, id_cargo)
      VALUES('".$data->historico_eclesiastico->data_conversao."','"
        .$data->historico_eclesiastico->data_batismo."',"
        .$id_cargo_1.");"
  );
  
  if( $errorInsertHistEcles == false || $id_cargo == false ) {
    echo 'erro em inserir historico eclesiastico';
  }
  //buscando ids para inserir dados pessoais
  try {
    
    $id_endereco = $obj_conexao->query(
      'SELECT id_endereco FROM endereco WHERE '
      . 'logradouro="'.$data->endereco->logradouro.'" AND '
      . 'numero ="'.$data->endereco->numero.'" AND '
      . 'bairro ="'.$data->endereco->bairro.'"'        
            
    );
    $endereco = mysql_fetch_assoc( $id_endereco );
    $id_endereco1 = $endereco['id_endereco'];
    mysql_free_result($endereco);
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
    mysql_free_result($teologia);
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
    mysql_free_result($contato);
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
    $historico_familiar = mysql_fetch_assoc( $id_historico_familiar );
    $id_historico_familiar1 = $historico_familiar['id_historico_familiar'];
    mysql_free_result($historico_familiar);
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  
  try {
    $data_batismo = new DateTime($data->historico_eclesiastico->data_batismo);
    $data_conversao = new DateTime($data->historico_eclesiastico->data_conversao);
    $id_hist_eclesiastico = $obj_conexao->query(
      'SELECT id_hist_eclesiastico FROM historico_eclesiastico WHERE '
      . 'data_conversao ="'.$data_conversao->format( 'Y-m-d' ).'" AND '
      . 'data_batismo ="'.$data_batismo->format( 'Y-m-d' ).'"'
    );
    $historico_eclesiastico = mysql_fetch_assoc( $id_hist_eclesiastico );
    $id_hist_eclesiastico1 = $historico_eclesiastico['id_hist_eclesiastico'];
    mysql_free_result($historico_eclesiastico);
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  $data_nascimento = new DateTime($data->dados_pessoais->data_nascimento);
  try {
    $errorInsertDadosPessoais = $obj_conexao->query(
      "INSERT INTO dados_pessoais(
        nome,
        rg,
        sexo,
        data_nascimento,
        tipo_sanguineo,
        nome_mae,
        profissao,
        nome_pai,
        id_historico_familiar,
        id_endereco,
        id_contato,
        id_hist_eclesiastico, 
        id_teologia
        ) VALUES( '"
        .$data->dados_pessoais->nome."','"
        .$data->dados_pessoais->rg."','"
        .$data->dados_pessoais->sexo."','"
        .$data_nascimento->format( 'Y-m-d' )."','"
        .$data->dados_pessoais->tipo_sanguineo."','"
        .$data->dados_pessoais->nome_mae."','"
        .$data->dados_pessoais->profissao."','"
        .$data->dados_pessoais->nome_pai."',"
        .$id_historico_familiar1.","
        .$id_endereco1.","
        .$id_contato1.","
        .$id_hist_eclesiastico1.","
        .$id_teologia1.");"      
    );
    
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  if( $errorInsertDadosPessoais == false ) {
    echo 'erro em inserir dados pessoais';
  }
  $obj_conexao->desconectar();

return;
});

print $r3->run();
