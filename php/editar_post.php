<?php
require "conexao.php";
header("Content-Type: application/json");

$dados    = json_decode(file_get_contents("php://input"), true);
$post_id  = $dados["post_id"]  ?? 0;
$cpf      = $dados["cpf"]      ?? "";
$conteudo = $dados["conteudo"] ?? "";

if (!$post_id || !$cpf || !$conteudo) {
    echo json_encode(["erro" => "Dados incompletos"]);
    exit;
}

/* Garante que só o dono pode editar */
$stmt = $conn->prepare("
    UPDATE posts p
    JOIN usuarios u ON u.id = p.usuario_id
    SET p.conteudo = ?
    WHERE p.id = ? AND u.cpf = ?
");
$stmt->bind_param("sis", $conteudo, $post_id, $cpf);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    echo json_encode(["erro" => "Post não encontrado ou sem permissão"]);
    exit;
}

echo json_encode(["sucesso" => true]);