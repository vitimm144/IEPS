<?php

include ( 'conexao.php' );
require 'vendor/autoload.php';
    
ini_set("display_errors", 1);

session_start();
date_default_timezone_set('UTC');
use Respect\Rest\Router;

$r3 = new Router('/api');

/*
 *Tratamento campo boolean pois o mysql não aceita tipo boolean 
 */
function boolean_to_int ( $value ){
  $value ? $value = 1 : $value = 0;
  return $value;
}


//**************************************************
//Retorna um membro cadastrado recebendo como 
//parametro a matricula do membro
//**************************************************

$r3->get('/membros/*', function($id){
  header('HTTP/1.1 200 Ok');
  $cadastro;
  $obj_conexao = new conexao();
  if(!$obj_conexao){
    die ('sem conexao com o banco em resposta para requisição com ID');
  }
  try{
    
    $membro = $obj_conexao->query( 'SELECT * FROM dados_pessoais WHERE '
            . 'matricula="'.$id.'"' );
    $cadastro['membro'] = mysql_fetch_assoc( $membro );
    
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar membro com matrícula '.$id;
  }
  try{
    $hist_familiar = $obj_conexao->query( 'SELECT * FROM historico_familiar WHERE '
            . 'id_historico_familiar="'.$cadastro['membro']['id_historico_familiar'].'"' );
    $cadastro['historico_familiar'] = mysql_fetch_assoc( $hist_familiar );
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar historico familiar com o id'.$cadastro['membro']['id_historico_familiar'];
  }
  try{
    $endereco = $obj_conexao->query( 'SELECT * FROM endereco WHERE '
            . 'id_endereco="'.$cadastro['membro']['id_endereco'].'"' );
    $cadastro['endereco'] = mysql_fetch_assoc( $endereco );
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar endereco com o id'.$cadastro['membro']['id_endereco'];
  }
  try{
    $contato = $obj_conexao->query( 'SELECT * FROM contato WHERE '
            . 'id_contato="'.$cadastro['membro']['id_contato'].'"' );
    $cadastro['contato'] = mysql_fetch_assoc( $contato );
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar contato com o id'.$cadastro['membro']['id_contato'];
  }
  try{
    $historico_eclesiastico = $obj_conexao->query( 'SELECT * FROM historico_eclesiastico WHERE '
            . 'id_hist_eclesiastico="'.$cadastro['membro']['id_hist_eclesiastico'].'"' );
    $cadastro['historico_eclesiastico'] = mysql_fetch_assoc( $historico_eclesiastico );
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar historico_eclesiastico com o id'.$cadastro['membro']['id_hist_eclesiastico'];
  }
  try{
    $cargo = $obj_conexao->query( 'SELECT * FROM cargo WHERE '
            . 'id_cargo="'.$cadastro['historico_eclesiastico']['id_cargo'].'"' );
    $cadastro['cargo'] = mysql_fetch_assoc( $cargo);
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar cargo com o id'.$cadastro['historico_eclesiastico']['id_cargo'];
  }
  try{
    $teologia = $obj_conexao->query( 'SELECT * FROM teologia WHERE '
            . 'id_teologia="'.$cadastro['membro']['id_teologia'].'"' );
    $cadastro['teologia'] = mysql_fetch_assoc( $teologia );
  } catch ( Exception $e ) {
    echo $e.'Erro em buscar historico_eclesiastico com o id'.$cadastro['membro']['id_teologia'];
  }
  return json_encode( $cadastro );
});
//***********************************
//requisição para deletar um cadastro
//***********************************
$r3->delete('/membros', function(){
  $obj_conexao = new conexao();
  
  if(!$obj_conexao){
    die ('Sem conexao com o banco');
  }
  $data = json_decode(file_get_contents('php://input'));
  header('HTTP/1.1 200 Ok');

  $result_del['contato'] = $obj_conexao->query(
    "DELETE from contato WHERE id_contato=".(int)$data->id_contato.";"
  );

  $result_del['endereco'] = $obj_conexao->query(
    "DELETE from endereco WHERE id_endereco=".(int)$data->id_endereco.";"
  );

  $result_del['historico_familiar'] = $obj_conexao->query(
    "DELETE from historico_familiar WHERE id_historico_familiar="
      .(int)$data->id_historico_familiar.";"
  );

  $result_del['cargo']= $obj_conexao->query(
    "DELETE from cargo WHERE id_cargo="
      .(int)$data->historico_eclesiastico->id_cargo.";"
  );

  $result_del['historico_eclesiastico'] = $obj_conexao->query(
    "DELETE from historico_eclesiastico WHERE id_hist_eclesiastico="
      .(int)$data->id_hist_eclesiastico.";"
  );

  $result_del['teologia'] = $obj_conexao->query(
    "DELETE from teologia WHERE id_teologia="
      .(int)$data->id_teologia.";"
  );

  $result_del['membro'] = $obj_conexao->query(
    "DELETE from dados_pessoais WHERE matricula="
      .(int)$data->matricula.";"
  );
  echo json_encode($data->id_hist_eclesiastico).PHP_EOL;
  echo json_encode($result_del).PHP_EOL;
  return;
});

$r3->put('/membros', function(){
  $obj_conexao = new conexao();
  
  if(!$obj_conexao){
    die ('Sem conexao com o banco');
  }
  $data = json_decode(file_get_contents('php://input'));
  header('HTTP/1.1 200 Ok');
  
  $update_dados_pessoais = sprintf( "UPDATE dados_pessoais SET nome='%s', "
    . "rg='%s', sexo='%s', data_nascimento='%s', "
    . "tipo_sanguineo='%s', nome_mae='%s', profissao='%s', "
    . "nome_pai='%s' WHERE matricula=".$data->membro->matricula.";",
    mysql_real_escape_string($data->membro->nome),
    mysql_real_escape_string($data->membro->rg),
    mysql_real_escape_string($data->membro->sexo),
    mysql_real_escape_string($data->membro->data_nascimento),
    mysql_real_escape_string($data->membro->tipo_sanguineo),
    mysql_real_escape_string($data->membro->nome_mae),
    mysql_real_escape_string($data->membro->profissao),
    mysql_real_escape_string($data->membro->nome_pai)
  );
  
  $update_result['membro'] = $obj_conexao->query($update_dados_pessoais);
  
  
  $update_historico_familiar = sprintf(
    "UPDATE historico familiar SET estado_civil='%s', "
    . "nome_conjuje='%s', data_casamento='%s',"
    . " filhos=".boolean_to_int($data->historico_familiar->filhos).","
    . " nr_filhos=".$data->historico_familiar->nr_filhos." WHERE "
    . "id_historico_familiar=". $data->membro->id_historico_familiar.";",
    mysql_real_escape_string($data->historico_familiar->estado_civil),
    mysql_real_escape_string($data->historico_familiar->nome_conjuje),
    mysql_real_escape_string($data->historico_familiar->data_casamento)
  );
  $update_result['historico_familiar'] = $obj_conexao->query($update_historico_familiar);
  
  $update_endereco = sprintf(
    "UPDATE endereco SET logradouro='%s', numero='%s', bairro='%s',"
    . " complemento='%s', cep='%s' WHERE id_endereco="
    .$data->membro->id_endereco.";",
    mysql_real_escape_string($data->endereco->logradouro),
    mysql_real_escape_string($data->endereco->numero),
    mysql_real_escape_string($data->endereco->bairro),
    mysql_real_escape_string($data->endereco->complemento),
    mysql_real_escape_string($data->endereco->cep)
  );
  
  $update_result['endereco'] = $obj_conexao->query($update_endereco);
  
  $update_contato = sprintf(
    "UPDATE contato SET residencial='%s', celular1='%s', celular2='%s',"
    . " email='%s', facebook='%s' WHERE id_contato="
    .$data->membro->id_contato.";",
    mysql_real_escape_string($data->contato->residencial),      
    mysql_real_escape_string($data->contato->celular1),      
    mysql_real_escape_string($data->contato->celular2),      
    mysql_real_escape_string($data->contato->email),      
    mysql_real_escape_string($data->contato->facebook)      
  );
  
  $update_result['contato'] = $obj_conexao->query($update_contato);
  
  $update_cargo = sprintf(
    "UPDATE cargo SET cargo='%s', data_consagracao='%s', igreja='%s', "
    . "cidade='%s' WHERE id_cargo=".$data->historico_eclesiastico->id_cargo.";",
    mysql_real_escape_string($data->cargo->cargo),      
    mysql_real_escape_string($data->cargo->data_consagracao),      
    mysql_real_escape_string($data->cargo->igreja),      
    mysql_real_escape_string($data->cargo->cidade)      
  );
  
  $update_result['cargo'] = $obj_conexao->query($update_cargo);
  
  $update_historico_eclesiastico = sprintf(
    "UPDATE historico_eclesiastico SET data_conversao='%s', data_batismo='%s'"
    . " WHERE id_hist_eclesiastico="
    .$data->membro->id_hist_eclesiastico.";",
    mysql_real_escape_string($data->historico_eclesiastico->data_conversao),
    mysql_real_escape_string($data->historico_eclesiastico->data_batismo)
  );
  
  $update_result['historico_eclesiastico'] = $obj_conexao->query($update_historico_eclesiastico);
  
  $update_teologia = sprintf(
    "UPDATE teologia SET curso='%s', instituicao='%s', duracao='%s' "
    . "WHERE id_teologia=".$data->membro->id_teologia.";",
    mysql_real_escape_string($data->teologia->curso),
    mysql_real_escape_string($data->teologia->instituicao),
    mysql_real_escape_string($data->teologia->duracao)
  );
  
  $update_result['teologia'] = $obj_conexao->query($update_teologia);
  echo json_encode($update_result).PHP_EOL;
  echo $update_teologia.PHP_EOL;
  
  return $data;
});

//********************************
//retorna um array contendo todos os usuários
//cadastrados no sistema
//********************************

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
  
  $errorInsertHistFamiliar = $obj_conexao->query(
          "INSERT INTO historico_familiar(estado_civil, data_casamento, nome_conjuje, filhos, nr_filhos)
            VALUES('".$data->historico_familiar->estado_civil."','"
              .$data->historico_familiar->data_casamento."','"
              .$data->historico_familiar->nome_conjuje."',"
              //TODO tratamento do campo boolean armazenar no banco 0 ou 1
              .boolean_to_int($data->historico_familiar->filhos).","
              .$data->historico_familiar->nr_filhos.");"
  );
  if( $errorInsertHistFamiliar == false ) {
    echo 'erro em inserir historico familiar'.PHP_EOL;
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
    $historico_familiar = mysql_fetch_assoc( $id_historico_familiar );
    $id_historico_familiar1 = $historico_familiar['id_historico_familiar'];
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
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  $data_nascimento = new DateTime($data->membro->data_nascimento);
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
        .$data->membro->nome."','"
        .$data->membro->rg."','"
        .$data->membro->sexo."','"
        .$data_nascimento->format( 'Y-m-d' )."','"
        .$data->membro->tipo_sanguineo."','"
        .$data->membro->nome_mae."','"
        .$data->membro->profissao."','"
        .$data->membro->nome_pai."',"
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
