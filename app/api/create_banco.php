<?php

include ( 'conexao.php' );

$obj_conect = new conexao();

if (!$obj_conect) {
  die ('Sem conexao com o banco');
}
$obj_conect->set_db('cad_membros');
try { 
  
  $obj_conect->query('CREATE DATABASE cad_membros;');
  mysql_select_db($obj_conect->get_db(), $obj_conect->get_link());
  
  $obj_conect->query('CREATE TABLE cargo(
    id_cargo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    cargo VARCHAR(30),
    data_consagracao DATE,
    igreja VARCHAR(40),
    cidade VARCHAR(30), 
    PRIMARY KEY(id_cargo) );');
  
  $obj_conect->query('CREATE TABLE historico_eclesiastico (
    id_hist_eclesiastico INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    data_conversao DATE,
    data_batismo DATE, 
    id_cargo INTEGER UNSIGNED NOT NULL, 
    PRIMARY KEY(id_hist_eclesiastico),
    FOREIGN KEY(id_cargo)
    REFERENCES cargo(id_cargo) );');
  
  $obj_conect->query('CREATE TABLE contato(
    id_contato INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    residencial VARCHAR(20),
    celular1 VARCHAR(20),
    celular2 VARCHAR(20),
    email VARCHAR(20),
    facebook VARCHAR (20),
    PRIMARY KEY (id_contato) );');
  
  $obj_conect->query('CREATE TABLE teologia(
    id_teologia INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    curso VARCHAR (30),
    instituicao VARCHAR(30),
    duracao VARCHAR (30),
    anexos BLOB,
    PRIMARY KEY(id_teologia) );');
  
  $obj_conect->query('CREATE TABLE endereco(
    id_endereco INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    logradouro VARCHAR(50),
    numero VARCHAR(30),
    bairro VARCHAR(30), 
    complemento VARCHAR(30),
    cep VARCHAR(20), 
    PRIMARY KEY(id_endereco) );');
  
  $obj_conect->query('CREATE TABLE historico_familiar(
    id_historico_familiar INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    estado_civil VARCHAR(15), 
    data_casamento DATE, 
    nome_conjuje VARCHAR(40),
    filhos INTEGER, 
    nr_filhos INTEGER, 
    PRIMARY KEY(id_historico_familiar)
    );');
  
  $obj_conect->query('CREATE TABLE dados_pessoais(
    matricula INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    nome VARCHAR(30),
    rg VARCHAR(20), 
    sexo VARCHAR(15),
    data_nascimento DATE, 
    tipo_sanguineo VARCHAR(10), 
    nome_mae VARCHAR(40),
    profissao VARCHAR(40), 
    nome_pai VARCHAR(40),
    id_historico_familiar INTEGER UNSIGNED, 
    id_endereco INTEGER UNSIGNED, 
    id_contato INTEGER UNSIGNED, 
    id_hist_eclesiastico INTEGER UNSIGNED, 
    id_teologia INTEGER UNSIGNED, 
    PRIMARY KEY(matricula),
    FOREIGN KEY(id_historico_familiar)
    REFERENCES historico_familiar(id_historico_familiar),
    FOREIGN KEY(id_endereco)
    REFERENCES endereco(id_endereco),
    FOREIGN KEY(id_contato)
    REFERENCES contato(id_contato),
    FOREIGN KEY(id_hist_eclesiastico)
    REFERENCES historico_eclesiastico(id_hist_eclesiastico),
    FOREIGN KEY(id_teologia)
    REFERENCES teologia(id_teologia) );');
  
  
  
  $obj_conect->query('CREATE TABLE info_adm(
    id_info_adm INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    matricula INTEGER UNSIGNED NOT NULL, 
    recebido_em DATE, 
    modo VARCHAR(40), 
    carta_referencia INTEGER, 
    data_carta DATE, 
    igreja_anterior VARCHAR(40),
    observacao VARCHAR(50), 
    data_ultima_atualizacao DATE, 
    status_membro VARCHAR(40), 
    PRIMARY KEY(id_info_adm),
    FOREIGN KEY(matricula) 
    REFERENCES dados_pessoais(matricula) );');
  
}catch (Exception $e){
  echo $e.'Criacao de tabelas';
}
