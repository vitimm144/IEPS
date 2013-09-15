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
    cargo VARCHAR(20),
    data_consagracao DATE,
    igreja VARCHAR(40),
    cidade VARCHAR(20), 
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
    logradouro VARCHAR(10),
    numero VARCHAR(10),
    bairro VARCHAR(10), 
    complemento VARCHAR(10),
    cep VARCHAR(15), 
    PRIMARY KEY(id_endereco) );');
  
  $obj_conect->query('CREATE TABLE dados_pessoais(
    matricula INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    nome VARCHAR(30),
    id_endereco INTEGER UNSIGNED NOT NULL, 
    profissao VARCHAR(20), 
    sexo VARCHAR(10),
    rg VARCHAR(15), 
    id_contato INTEGER UNSIGNED NOT NULL, 
    tipo_sanguineo VARCHAR(2), 
    data_nascimento DATE, 
    estado_civil VARCHAR(10), 
    data_casamento DATE, 
    nome_conjuje VARCHAR(40),
    filhos INTEGER, 
    nr_filhos INTEGER, 
    nome_mae VARCHAR(40),
    nome_pai VARCHAR(40),
    id_hist_eclesiastico INTEGER UNSIGNED NOT NULL, 
    id_teologia INTEGER UNSIGNED NOT NULL, 
    PRIMARY KEY(matricula),
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
    status_membro VARCHAR(20), 
    PRIMARY KEY(id_info_adm),
    FOREIGN KEY(matricula) 
    REFERENCES dados_pessoais(matricula) );');
  
}catch (Exception $e){
  echo $e.'Criacao de tabelas';
}