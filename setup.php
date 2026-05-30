<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host    = $_ENV["DB_HOST"];
$usuario = $_ENV["DB_USER"];
$senha   = $_ENV["DB_PASS"];

/* CONEXÃO MYSQL */
$conn = new mysqli($host, $usuario, $senha);

if ($conn->connect_error) die("Erro: " . $conn->connect_error);


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

/* POSTS */
$conn->query("
    CREATE TABLE IF NOT EXISTS posts (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id    INT,
        conteudo      TEXT,
        data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )
");

/* MÍDIAS DOS POSTS */
$conn->query("
    CREATE TABLE IF NOT EXISTS midias_post (
        id      INT AUTO_INCREMENT PRIMARY KEY,
        post_id INT NOT NULL,
        url     VARCHAR(500) NOT NULL,
        tipo    ENUM('imagem','video') NOT NULL,
        FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
    )
");

/* CURTIDAS */
$conn->query("
    CREATE TABLE IF NOT EXISTS curtidas (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        post_id    INT NOT NULL,
        usuario_id INT NOT NULL,
        UNIQUE KEY unica_curtida (post_id, usuario_id),
        FOREIGN KEY (post_id)    REFERENCES posts(id)    ON DELETE CASCADE,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    )
");

/* COMENTÁRIOS */
$conn->query("
    CREATE TABLE IF NOT EXISTS comentarios (
        id              INT AUTO_INCREMENT PRIMARY KEY,
        post_id         INT NOT NULL,
        usuario_id      INT NOT NULL,
        comentario      TEXT,
        data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (post_id)    REFERENCES posts(id)    ON DELETE CASCADE,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    )
");

echo "Banco e tabelas criados com sucesso!";

