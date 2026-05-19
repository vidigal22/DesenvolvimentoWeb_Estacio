<?php
require "conexao.php";
header("Content-Type: application/json");

/* Busca todos os posts com nome e foto do autor, mais recentes primeiro */
$sql = "
    SELECT
        p.id,
        p.conteudo,
        p.data_postagem,
        u.nome,
        u.cpf,
        u.foto_perfil
    FROM posts p
    JOIN usuarios u ON u.id = p.usuario_id
    ORDER BY p.data_postagem DESC
";

$resultado = $conn->query($sql);
$posts = [];

while ($row = $resultado->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);