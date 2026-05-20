<?php
require "conexao.php";
header("Content-Type: application/json");

$dados   = json_decode(file_get_contents("php://input"), true);
$cpf     = $dados["cpf"]     ?? "";
$conteudo = $dados["conteudo"] ?? "";

if (!$cpf || !$conteudo) {
    echo json_encode(["erro" => "Dados incompletos"]);
    exit;
}

/* Pega o id do usuário pelo CPF */
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$res  = $stmt->get_result()->fetch_assoc();

if (!$res) {
    echo json_encode(["erro" => "Usuário não encontrado"]);
    exit;
}

$usuario_id = $res["id"];

$stmt = $conn->prepare(
    "INSERT INTO posts (usuario_id, conteudo) VALUES (?, ?)"
);
$stmt->bind_param("is", $usuario_id, $conteudo);
$stmt->execute();

echo json_encode(["sucesso"  => true,"post_id"  => $conn->insert_id]);