<?php
require "conexao.php";
header("Content-Type: application/json");

$dados      = json_decode(file_get_contents("php://input"), true);
$post_id    = $dados["post_id"]    ?? 0;
$cpf        = $dados["cpf"]        ?? "";
$comentario = $dados["comentario"] ?? "";

if (!$post_id || !$cpf || !$comentario) {
    echo json_encode(["erro" => "Dados incompletos"]); exit;
}

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { echo json_encode(["erro" => "Usuário não encontrado"]); exit; }
$usuario_id = $u["id"];

$stmt = $conn->prepare("INSERT INTO comentarios (post_id, usuario_id, comentario) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $post_id, $usuario_id, $comentario);
$stmt->execute();

echo json_encode(["sucesso" => true, "comentario_id" => $conn->insert_id]);
