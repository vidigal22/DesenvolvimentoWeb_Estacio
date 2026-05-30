<?php
require "conexao.php";
header("Content-Type: application/json");

$dados   = json_decode(file_get_contents("php://input"), true);
$post_id = $dados["post_id"] ?? 0;
$cpf     = $dados["cpf"]     ?? "";

if (!$post_id || !$cpf) { echo json_encode(["erro" => "Dados incompletos"]); exit; }

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { echo json_encode(["erro" => "Usuário não encontrado"]); exit; }
$usuario_id = $u["id"];

/* Toggle curtida */
$stmt = $conn->prepare("SELECT id FROM curtidas WHERE post_id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $post_id, $usuario_id);
$stmt->execute();
$existe = $stmt->get_result()->num_rows > 0;

if ($existe) {
    $stmt = $conn->prepare("DELETE FROM curtidas WHERE post_id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $post_id, $usuario_id);
    $stmt->execute();
    $acao = "descurtido";
} else {
    $stmt = $conn->prepare("INSERT INTO curtidas (post_id, usuario_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $post_id, $usuario_id);
    $stmt->execute();
    $acao = "curtido";
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM curtidas WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()["total"];

echo json_encode(["sucesso" => true, "acao" => $acao, "total" => (int)$total]);
