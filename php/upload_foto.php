<?php

require "conexao.php";

header("Content-Type: application/json");

$cpf     = $_POST["cpf"]  ?? "";
$arquivo = $_FILES["foto"] ?? null;

if (!$cpf || !$arquivo || $arquivo["error"] !== UPLOAD_ERR_OK) {
    echo json_encode(["erro" => "Dados inválidos ou erro no upload"]);
    exit;
}

/* ── Pasta física onde o arquivo é salvo ── */
$pastaFisica = __DIR__ . "/../uploads/";

/* Cria a pasta se não existir */
if (!is_dir($pastaFisica)) {
    mkdir($pastaFisica, 0755, true);
}

/* Nome único para evitar conflito */
$extensao    = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
$nomeArquivo = uniqid("foto_") . "." . $extensao;
$caminhoFisico = $pastaFisica . $nomeArquivo;

/* Move o arquivo para a pasta definitiva */
if (!move_uploaded_file($arquivo["tmp_name"], $caminhoFisico)) {
    echo json_encode(["erro" => "Falha ao mover o arquivo"]);
    exit;
}

/* ── URL acessível pelo browser ── */
$urlPublica = "/uploads/" . $nomeArquivo;

/* Salva a URL pública no banco */
$sql  = "UPDATE usuarios SET foto_perfil = ? WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $urlPublica, $cpf);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    /* CPF não encontrado no banco */
    echo json_encode(["erro" => "CPF não encontrado. Faça o cadastro primeiro."]);
    exit;
}

echo json_encode(["mensagem" => "Foto salva!", "caminho"  => $urlPublica]);