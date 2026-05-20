<?php

require "conexao.php";

header("Content-Type: application/json");

$cpf = $_GET["cpf"] ?? "";

if (!$cpf) {
    echo json_encode(["erro" => "CPF não informado"]);
    exit;
}

$sql  = "SELECT foto_perfil FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario   = $resultado->fetch_assoc();

if ($usuario && $usuario["foto_perfil"]) {
    /* Retorna a URL pública que foi salva no banco */
    echo json_encode(["foto_perfil" => $usuario["foto_perfil"]]);

} else {
    /* Sem foto cadastrada — frontend mantém a imagem padrão */
    echo json_encode(["foto_perfil" => null]);
}