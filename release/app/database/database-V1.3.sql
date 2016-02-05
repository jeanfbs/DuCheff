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
	login VARCHAR(15),
	senha VARCHAR(50),
	nome VARCHAR(40) not null,
	endereco VARCHAR(70) not null,
	telefone VARCHAR(25) not null,
	email VARCHAR(40) default null,
	latitude FLOAT default 0.00,
	longitude FLOAT default 0.00
);

CREATE TABLE IF NOT EXISTS comentarios(
	cod	 INT primary key auto_increment,
	cod_cliente	 INT,
	tipo INT not null, -- Elogio:1, Reclamação:2, Sugestao:3
	horario TIME not null,
	data DATE not null,
	mensagem TEXT not null,
	status int default 1, -- Não visualizado: 1, Visualizado: 2		
	FOREIGN KEY(cod_cliente) REFERENCES clientes(cod)
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
	observacoes TEXT,
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
	observacoes TEXT,
	FOREIGN KEY(cod_produto)REFERENCES produtos(cod)
);

-- Tabela: Variedades

CREATE TABLE IF NOT EXISTS variedades(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	deletada BOOLEAN default 0
);

-- Tabela: Categorias

CREATE TABLE IF NOT EXISTS categorias(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	deletada BOOLEAN default 0
);

-- Tabela: Adicionais

CREATE TABLE IF NOT EXISTS adicionais(
	cod INT primary key auto_increment,
	cod_produto	 INT,
	cod_categoria INT,
	UNIQUE(cod_produto,cod_categoria),
	FOREIGN KEY(cod_produto) REFERENCES produtos(cod),
	FOREIGN KEY(cod_categoria) REFERENCES categorias(cod)
);

-- Tabela: Tipo de Prato

CREATE TABLE IF NOT EXISTS tipo_prato(
	cod	 INT primary key auto_increment,
	nome VARCHAR(30) not null,
	foto_url VARCHAR(100) default null,
	deletada BOOLEAN default 0
);
-- Tabela: Relação Tipo Prato x Variedade

CREATE TABLE IF NOT EXISTS pratos(
	cod	 INT primary key auto_increment,
	cod_tipo_prato	 INT,
	nome VARCHAR(30) not null,
	valor	         FLOAT default 0.00,
	descricao        TEXT,
	deletada  BOOLEAN default 0,
	foto_url VARCHAR(100) default null,
	FOREIGN KEY(cod_tipo_prato) REFERENCES tipo_prato(cod)
);

-- Tabela: Relação Prato X Variedades

CREATE TABLE IF NOT EXISTS prato_variedade(
	cod_prato	 	 INT,
	cod_variedade	 INT,
	PRIMARY KEY(cod_prato,cod_variedade),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod),
	FOREIGN KEY(cod_variedade) REFERENCES variedades(cod)
);

-- Tabela: Relação Prato X Categoria

CREATE TABLE IF NOT EXISTS prato_categoria(
	cod_prato	 	 INT,
	cod_categoria	 INT,
	limite			 INT default -1,-- valor para todos os itens daquela categoria
	PRIMARY KEY(cod_prato,cod_categoria),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod),
	FOREIGN KEY(cod_categoria) REFERENCES categorias(cod)
);


-- Tabela: Pedido

CREATE TABLE IF NOT EXISTS pedidos(
	cod	 INT primary key auto_increment,
	cod_cliente INT,
	horario TIME not null,
	data DATE not null,
	nro_mesa INT,
	valor_total FLOAT not null,
	status INT default 1, -- Enviado:1, Aceito e Preparando:2, Rejeitado:3, Pronto:4
						 -- Pago:5, Cancelado:6
	origem INT default null, -- Web:1, APP:2,
	observacoes TEXT default null,
	FOREIGN KEY(cod_cliente) REFERENCES clientes(cod)
);


-- Tabela: Relação Pedidos X Pratos

CREATE TABLE IF NOT EXISTS item_pedido(
	cod_item   INT primary key auto_increment,
	cod_pedido INT,
	cod_prato  INT,
	quantidade INT default 1,
	FOREIGN KEY(cod_pedido) REFERENCES pedidos(cod),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod)
);

-- Tabela: Relação Item Pedido Prato X Variedade

CREATE TABLE IF NOT EXISTS item_pedido_variedade(
	cod_item   INT,
	cod_prato  INT,
	cod_variedade INT,
	PRIMARY KEY(cod_item,cod_prato,cod_variedade),
	FOREIGN KEY(cod_item) REFERENCES item_pedido(cod_item),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod),
	FOREIGN KEY(cod_variedade) REFERENCES variedades(cod)
);

-- Tabela: Relação Pedidos - Pratos X Adicional

CREATE TABLE IF NOT EXISTS item_pedido_adicional(
	cod_item   INT,
	cod_prato  INT,
	cod_adicional INT,
	PRIMARY KEY(cod_item,cod_prato,cod_adicional),
	FOREIGN KEY(cod_item) REFERENCES item_pedido(cod_item),
	FOREIGN KEY(cod_prato) REFERENCES pratos(cod),
	FOREIGN KEY(cod_adicional) REFERENCES adicionais(cod)
);

-- Tabela: Relação Pedido x Bebida

CREATE TABLE IF NOT EXISTS itens_pedido_bebida(
	cod_pedido INT not null,
	cod_bebida INT not null,
	quantidade INT not null default 1,
	PRIMARY KEY(cod_pedido,cod_bebida),
	FOREIGN KEY(cod_pedido) REFERENCES pedidos(cod),
	FOREIGN KEY(cod_bebida) REFERENCES bebidas(cod)
);
