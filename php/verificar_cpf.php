<?php

require "conexao.php";

header("Content-Type: application/json");

$dados = json_decode(file_get_contents("php://input"),true);

$cpf = $dados["cpf"] ?? "";

if (!$cpf) {
    echo json_encode(["erro" => "CPF não informado"]);
    exit;
}

$sql = "SELECT id, nome FROM usuarios WHERE cpf = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    echo json_encode(["encontrado" => true,"nome" => $usuario["nome"]]);

} else {
    echo json_encode(["encontrado" => false]);
}