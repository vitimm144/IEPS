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
//$r3->any('/login', function() {
//          $data = json_decode(file_get_contents('php://input'), true);
//          
//          $arq = fopen('shadow.txt', 'r');
//          $cmp = $data['login'].':'.$data['senha'];
//          
//          while(!feof($arq)){
//            $linha = fgets($arq);
//            
//            if (trim($cmp) == trim($linha) ){
//                //file_put_contents("/tmp/teste", $cmp. " | ".$linha, FILE_APPEND);
//                $_SESSION['logado'] = true;
//
//                header('HTTP/1.1 200');
//                break;
//            } else {
//                //file_put_contents("/tmp/teste", $cmp. " || ".$linha, FILE_APPEND);
//                header('HTTP/1.1 401 Unauthorized');
//            }    
//            
//          };
//          fclose($arq);
////          if (($data['login'] == 'vh' && $data['senha'] == '202cb962ac59075b964b07152d234b70') || ($data['login'] == 'silva' && $data['senha'] == 'caf1a3dfb505ffed0d024130f58c5cfa')) {
////            $_SESSION['logado'] = true;
////            
////            header('HTTP/1.1 200');
////            echo "200";
////          } else {
////            header('HTTP/1.1 401 Unauthorized');
////            echo "401";
////          }
//          return; //json_encode($data.status);
//        });
////
//$r3->any('/logout', function() {
//
//          $_SESSION['logado'] = false;
//          session_destroy();
//        });
//
//$r3->get('/who', function() {
//
//          if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
//            header("Content-Type: application/json");
//            $result = [];
//            
//            exec('who', $result);
//            
//            return json_encode($result);
//          } else {
//            header('HTTP/1.1 401 Unauthorized');
//          }
//        });
//        
//$r3->get('/history/*', function($usuario) {
//          if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
//            header("Content-Type: application/json");
//            if($usuario == 'root'){
//              $history = file('/root/.bash_history', FILE_IGNORE_NEW_LINES);
//          }else{
//              $caminho = '/home/'.$usuario.'/.bash_history';
//              
//              $history = file($caminho, FILE_IGNORE_NEW_LINES);
//          }
//            return json_encode($history);
//          } else {
//            header('HTTP/1.1 401 Unauthorized');
//          }
//        });
//$r3->get('/usuarios', function() {
//          if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
//            header("Content-Type: application/json");
//           // exec('cut -d : -f1 /etc/passwd > usuarios.txt');
//            //$usuario = file_get_contents('/home/victor/devel/Trabsas/app/api/usuarios.txt');
//            $usuario = [];
//            $count = 0;
//            //$usuario = file_get_contents('/etc/passwd');
//            $arquivo = fopen('/etc/passwd', 'r');
//            while(!feof($arquivo)){
//               $usuario[$count]= fgets($arquivo);
//               $count ++;
//            }
//            fclose($arquivo);
//            return json_encode($usuario);
//          } else {
//            header('HTTP/1.1 401 Unauthorized');
//          }
//        });


print $r3->run();
