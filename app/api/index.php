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
  $data = file_get_contents('php://input');
  header('HTTP/1.1 200 Ok');
  $obj_conexao->desconectar();
  return $data;
});


print $r3->run();
