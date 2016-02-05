-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23-Jun-2015 às 16:24
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.11

--
-- Database: `duchefdb`
--

-- CREATE USER 'ducheff'@'localhost' IDENTIFIED BY 'ducheff';

-- GRANT ALL PRIVILEGES ON duchefdb.* TO 'ducheff'@'localhost' WITH GRANT OPTION;


-- Tabela: Funcionário

CREATE TABLE IF NOT EXISTS funcionarios(
	cod	 INT primary key auto_increment,
	nome VARCHAR(40) not null,
	nivel INT not null, -- Administrador:1, Atendente:2, Entregador:3
	login VARCHAR(15) not null,
	senha VARCHAR(70) not null,
	foto_url VARCHAR(100) NULL 
);

INSERT INTO `funcionarios`(`cod`, `nome`, `nivel`, `login`, `senha`) VALUES (null,'administrador',
1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997');

-- Tabela: Cliente

CREATE TABLE IF NOT EXISTS clientes(
	cod	 INT primary key auto_increment,
	login VARCHAR(15) not null,
	senha VARCHAR(50) not null,
	nome VARCHAR(40) not null,
	endereco VARCHAR(70) not null,
	telefone VARCHAR(20) not null,
	email VARCHAR(40) default null,
	latitude FLOAT default 0.00,
	longitude FLOAT default 0.00
);

-- Tabela: Bebidas

CREATE TABLE IF NOT EXISTS bebidas(
	cod	 INT primary key auto_increment,
	nome VARCHAR(40) not null,
	valor FLOAT not null,
	foto_url VARCHAR(100) default null,
	deletada BOOLEAN default 0
		
);

-- Tabela: Estoque Bebidas

CREATE TABLE IF NOT EXISTS estoque_bebidas(
	cod_estoque	 INT primary key auto_increment,
	cod_bebida 	 INT,
	qtd_entrada  FLOAT not null,
	qtd_atual    FLOAT not null,
	unidade_medida CHAR(2),
	data_entrada  DATE not null,
	data_vencimento DATE not null,
	FOREIGN KEY(cod_bebida)REFERENCES bebidas(cod)
);

-- Tabela: Produtos

CREATE TABLE IF NOT EXISTS produtos(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	deletada BOOLEAN default 0
);

-- Tabela: Estoque Produtos

CREATE TABLE IF NOT EXISTS estoque_produtos(
	cod_estoque	 INT primary key auto_increment,
	cod_produto	 INT,
	qtd_entrada  FLOAT not null,
	qtd_atual    FLOAT not null,
	unidade_medida CHAR(2),
	data_entrada  DATE not null,
	data_vencimento DATE not null,
	FOREIGN KEY(cod_produto)REFERENCES produtos(cod)
);

-- Tabela: Variedades

CREATE TABLE IF NOT EXISTS variedades(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	deletada BOOLEAN default 0
);


-- Tabela: Tipo de Prato

CREATE TABLE IF NOT EXISTS tipo_prato(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	foto_url VARCHAR(100) default null,
	deletada BOOLEAN default 0
);

-- Tabela: Categorias

CREATE TABLE IF NOT EXISTS categorias(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	foto_url VARCHAR(100) default null,
	deletada BOOLEAN default 0
);

-- Tabela: Adicionais

CREATE TABLE IF NOT EXISTS adicionais(
	cod INT primary key auto_increment,
	cod_produto	 INT,
	descricao TEXT,
	foto_url VARCHAR(100) default null,
	FOREIGN KEY(cod_produto) REFERENCES produtos(cod)
);

-- Tabela: Relação Categoria X Adicionais

CREATE TABLE IF NOT EXISTS categoria_adicional(
	cod_categoria	 INT,
	cod_adicional	 INT,
	PRIMARY KEY(cod_categoria,cod_adicional),
	FOREIGN KEY(cod_categoria)REFERENCES categorias(cod),
	FOREIGN KEY(cod_adicional)REFERENCES adicionais(cod)
);

-- Tabela: Relação Tipo Prato x Variedade

CREATE TABLE IF NOT EXISTS pratos(
	cod	 INT primary key auto_increment,
	cod_tipo_prato	 INT,
	cod_variedade	 INT,
	valor	         FLOAT default 0.00,
	descricao        TEXT,
	deletada  BOOLEAN default 0,
	foto_url VARCHAR(100) default null,
	FOREIGN KEY(cod_tipo_prato) REFERENCES tipo_prato(cod),
	FOREIGN KEY(cod_variedade) REFERENCES variedades(cod)
);


-- Tabela: Relação Prato X Categoria

CREATE TABLE IF NOT EXISTS prato_categoria(
	cod_prato	 	 INT,
	cod_categoria	 INT,
	limite			 INT default -1,-- valor para todos os itens daquela categoria
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod),
	FOREIGN KEY(cod_categoria) REFERENCES categorias(cod)
);


-- Tabela: Pedido

CREATE TABLE IF NOT EXISTS pedidos(
	cod	 INT primary key auto_increment,
	cod_cliente INT,
	horario TIME not null,
	data DATE not null,
	valor_total FLOAT not null,
	status INT default 1, -- Enviado:1, Aceito:2, Rejeitado:3 Preparando:4, Pronto:5
						 -- Pago:6, Cancelado:7, Editando:8
	origem INT default null,
	FOREIGN KEY(cod_cliente) REFERENCES clientes(cod)
);


-- Tabela: Relação Pedidos X Pratos

CREATE TABLE IF NOT EXISTS pedido_prato(
	cod_item   INT primary key auto_increment,
	cod_pedido INT,
	cod_prato  INT,
	quantidade INT default 1,
	tipo INT default 1, -- Médio: 1 , Grande: 2
	FOREIGN KEY(cod_pedido) REFERENCES pedidos(cod),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod)
);

-- Tabela: Relação Pedidos - Pratos X Adicional

CREATE TABLE IF NOT EXISTS pedido_prato_adicional(
	cod_item   INT primary key auto_increment,
	cod_adicional INT,
	FOREIGN KEY(cod_item) REFERENCES pedido_prato(cod_item),
	FOREIGN KEY(cod_adicional) REFERENCES adicionais(cod)
);

-- Tabela: Relação Pedido x Bebida

CREATE TABLE IF NOT EXISTS itens_pedido_bebidas(
	cod_pedido INT not null,
	cod_bebida INT not null,
	PRIMARY KEY(cod_pedido,cod_bebida),
	FOREIGN KEY(cod_pedido) REFERENCES pedidos(cod),
	FOREIGN KEY(cod_bebida) REFERENCES bebidas(cod)
);
