<?php
require "conexao.php";
header("Content-Type: application/json");

$dados   = json_decode(file_get_contents("php://input"), true);
$post_id = $dados["post_id"] ?? 0;
$cpf     = $dados["cpf"]     ?? "";

if (!$post_id || !$cpf) {
    echo json_encode(["erro" => "Dados incompletos"]);
    exit;
}

/* Deleta comentários do post primeiro (FK) */
$stmt = $conn->prepare("DELETE FROM comentarios WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

/* Deleta o post — só se o CPF for o dono */
$stmt = $conn->prepare("
    DELETE p FROM posts p
    JOIN usuarios u ON u.id = p.usuario_id
    WHERE p.id = ? AND u.cpf = ?
");
$stmt->bind_param("is", $post_id, $cpf);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    echo json_encode(["erro" => "Post não encontrado ou sem permissão"]);
    exit;
}

echo json_encode(["sucesso" => true]);