<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host    = $_ENV["DB_HOST"];
$usuario = $_ENV["DB_USER"];
$senha   = $_ENV["DB_PASS"];


/* CONEXÃO MYSQL */
$conn = new mysqli($host, $usuario, $senha);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}


/* CRIA E USA O BANCO */
$conn->query("CREATE DATABASE IF NOT EXISTS fomento_corporal");
$conn->select_db("fomento_corporal");


/* TABELA USUÁRIOS */
$conn->query("
    CREATE TABLE IF NOT EXISTS usuarios (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        nome          VARCHAR(100),
        cpf           VARCHAR(20) UNIQUE,
        data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        foto_perfil   VARCHAR(255)
    )
");

/* TABELA HISTÓRICO SAÚDE */
$conn->query("
    CREATE TABLE IF NOT EXISTS historico_saude (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id    INT,
        altura        DECIMAL(5,2),
        peso          DECIMAL(5,2),
        data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )
");

/* TABELA HISTÓRICO RENDA */
$conn->query("
    CREATE TABLE IF NOT EXISTS historico_renda (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id    INT,
        renda         DECIMAL(10,2),
        data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )
");

echo "Banco e tabelas criados com sucesso!";