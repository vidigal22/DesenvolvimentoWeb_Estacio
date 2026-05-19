<?php

$host = "localhost";
$usuario = "root";
$senha = getenv('db_pass');

/* -------------------------------- */
/* CONEXÃO MYSQL */
/* -------------------------------- */

$conn = new mysqli(

    $host,
    $usuario,
    $senha
);

if($conn->connect_error){

    die("Erro: " .
    $conn->connect_error);
}

/* -------------------------------- */
/* CRIA BANCO */
/* -------------------------------- */

$sql =
"CREATE DATABASE IF NOT EXISTS
fomento_corporal";

$conn->query($sql);

/* -------------------------------- */
/* USA O BANCO */
/* -------------------------------- */

$conn->select_db(
    "fomento_corporal"
);

/* -------------------------------- */
/* TABELA USUÁRIOS */
/* -------------------------------- */

$sql =
"CREATE TABLE IF NOT EXISTS usuarios(

    id INT AUTO_INCREMENT
    PRIMARY KEY,

    nome VARCHAR(100),

    cpf VARCHAR(20)
    UNIQUE,

    data_registro TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql);

/* -------------------------------- */
/* TABELA HISTÓRICO SAÚDE */
/* -------------------------------- */

$sql =
"CREATE TABLE IF NOT EXISTS
historico_saude(

    id INT AUTO_INCREMENT
    PRIMARY KEY,

    usuario_id INT,

    altura DECIMAL(5,2),

    peso DECIMAL(5,2),

    data_registro TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
)";

$conn->query($sql);

/* -------------------------------- */
/* TABELA HISTÓRICO RENDA */
/* -------------------------------- */

$sql =
"CREATE TABLE IF NOT EXISTS
historico_renda(

    id INT AUTO_INCREMENT
    PRIMARY KEY,

    usuario_id INT,

    renda DECIMAL(10,2),

    data_registro TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
)";

$conn->query($sql);

echo "Banco e tabelas criados!";

