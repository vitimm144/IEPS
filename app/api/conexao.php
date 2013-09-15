<?php
class conexao {
  private $pass = 123;
  private $user = 'ieps';
  private $banco = 'localhost';
  private $comando = '';
  private $link = '';
  private $db = 'cad_membros';
  
  public function get_banco(){
    return $this->banco;
  }
  public function get_db(){
    return $this->db;
  }
  public function set_db($db){
    $this->db = $db;
  }
  public function get_link(){
    return $this->link;
  }
  public function conexao (){
    $this->conectar();
  }
  public function conectar(){
    $this->link = mysql_connect($this->banco, $this->user, $this->pass );
    if(!$this->link){
      die('Problema na conexão com o Mysql'); 
    }else if(!mysql_select_db($this->db, $this->link)){
      if($this->db == ''){
        die('Defina o nome da database');
      }
      mysql_query('CREATE DATABASE'.$this->db.';', $this->link);
    }
  }
  public function desconectar(){
    mysql_close($this->link);     
  }
  public function query($comando){
    $this->comando = $comando;
    try{
      $resultado = mysql_query($this->comando, $this->link);
      return $resultado;
    }  catch (Exception $e){
      
      die($e." ####comando");
    }
  }
}