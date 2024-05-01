# PROJECT-PHP-API-WEB-TOKEN
Crud Project


### 1° - Execute os seguintes comandos DUMP para criar o banco de dados no **MysqlSql** sgbd

### 1.1 - Executar esta função no banco para formatar os dados de retorno pela api via postman por exemplo.

CREATE DATABASE db_doadores;

CREATE TYPE INTERVALO_DOACAO AS ENUM
(
    'unico',
    'bimestral',
    'semestral',
    'anual'
);

CREATE TYPE FORMA_PAGAMENTO AS ENUM
(
'debito',
'credito'
);

CREATE TABLE tb_doadores
(
    doador_id SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    cpf CHAR(11),
    telefone VARCHAR(55),
    data_nascimento DATE,
    data_cadastro DATE,
    intervalo_doacao INTERVALO_DOACAO,
    forma_pagamento FORMA_PAGAMENTO,
    preco_doacao NUMERIC(19,2),
    cep VARCHAR(55),
    endereco VARCHAR(255),
    numero INTEGER,
    bairro VARCHAR(55),
    cidade VARCHAR(55),
    uf VARCHAR(55)
 );

 SELECT * FROM tb_doadores;	

DELIMITER //

CREATE FUNCTION mask (unformatted_value BIGINT, format_string CHAR(32))
RETURNS CHAR(32) DETERMINISTIC

BEGIN
# Declare variables
DECLARE input_len TINYINT;
DECLARE output_len TINYINT;
DECLARE temp_char CHAR;

# Initialize variables
SET input_len = LENGTH(unformatted_value);
SET output_len = LENGTH(format_string);

# Construct formated string
WHILE ( output_len > 0 ) DO

SET temp_char = SUBSTR(format_string, output_len, 1);
IF ( temp_char = '#' ) THEN
IF ( input_len > 0 ) THEN
SET format_string = INSERT(format_string, output_len, 1, SUBSTR(unformatted_value, input_len, 1));
SET input_len = input_len - 1;
ELSE
SET format_string = INSERT(format_string, output_len, 1, '0');
END IF;
END IF;

SET output_len = output_len - 1;
END WHILE;

RETURN format_string;
END //

DELIMITER ;

### 1.2 - Criar a tabela usuarios e hidrata-la

CREATE TABLE usuarios (
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nome varchar(60) NULL,
  senha varchar(60) NULL
) ENGINE=InnoDB;

INSERT INTO usuario (nome, senha)
VALUES ('Lucas', 'hdgf');

INSERT INTO usuario (nome, senha)
VALUES ('Luca', 'hdgf');

SELECT * FROM usuario;  

### 1.2 - Criar a tabela clientes e hidrata-la

  CREATE TABLE clientes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome varchar(60) NULL,
    genero varchar(60) NULL,
    data_nascimento DATE NULL,
    cep VARCHAR(45) NULL,
    endereco VARCHAR(45) NULL,
    numero VARCHAR(45) NULL,
    bairro VARCHAR(45) NULL,
    cidade VARCHAR(45) NULL,
    uf VARCHAR(45) NULL,
    email VARCHAR(45) NULL,
    telefone varchar(100) NOT NULL,
    cpf_cnpj VARCHAR(45) NULL,
    data_cadastro DATE NULL,
    status VARCHAR(45) NULL
  ) ENGINE=InnoDB;

  INSERT INTO clientes (nome, genero, data_nascimento, cep, endereco, numero, bairro, cidade, uf, email, telefone, cpf_cnpj, data_cadastro, status)
  VALUES ('Lucas', 'Masculino', '1988-09-22', '05642000', 'Av José Galante', '2', 'Vila Andrade', 'São Paulo', 'SP', 'hd@gmail.com', '11953547808', 23609522832,   '2024-04-30', 'ativo');

  INSERT INTO clientes (nome, genero, data_nascimento, cep, endereco, numero, bairro, cidade, uf, email, telefone, cpf_cnpj, data_cadastro, status)
  VALUES ('Roberto', 'Masculino', '1988-09-22', '05642000', 'Av José Galante', '3', 'Vila Andrade', 'São Paulo', 'SP', 'hd@gmail.com', '11958547803',         
  33609522852, '2024-04-30', 'inativo');
  
  INSERT INTO clientes (nome, genero, data_nascimento, cep, endereco, numero, bairro, cidade, uf, email, telefone, cpf_cnpj, data_cadastro, status)
  VALUES ('Márcio', 'Masculino', '1988-09-22', '05642000', 'Av José Galante', '4', 'Vila Andrade', 'São Paulo', 'SP', 'hd@gmail.com', '11958547848',     
  23609522855, '2024-04-30', 'pendente');

### Testando as máscaras
select  mask(telefone, '(##) #####-####') AS telefone from clientes;
select  mask(cpf_cnpj, '###.###.###-##') AS cpf_cnpj from clientes;
select  mask(cep, '#####-###') AS cep from clientes;

SELECT  DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento
FROM clientes;
              
SELECT * FROM clientes;	

### 2° - Executar o comando **composer install** para gerenciar o bandle "firebase/php-jwt": "^6.10"

### 3° - Executar o comando **php -S localhost:8080** (Choose your **port** if you want) para executar o index.php e testar a autenticação via JWT e no postman também. observação(O servidor precisar estar em funcionamento para que o teste das api's via postman funcione.)

### 4° - Lista para testar os end points da api via postman  por exemplo.

### - VERBO GET: http://localhost:3000/api/read.php

### - VERBO GET ID: http://localhost:3000/api/read.php?id=2

### - VERBO POST: http://localhost:3000/api/create.php

### - VERBO PUT: http://localhost:3000/api/update.php?id=5

### - VERBO DELETE: http://localhost:3000/api/delete.php?id=5

