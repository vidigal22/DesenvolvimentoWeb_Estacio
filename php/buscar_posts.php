<?php
require "conexao.php";
header("Content-Type: application/json");

$cpf_logado = $_GET["cpf"] ?? "";

$sql = "
    SELECT
        p.id, p.conteudo, p.data_postagem,
        u.nome, u.cpf, u.foto_perfil,
        (SELECT COUNT(*) FROM curtidas  c WHERE c.post_id = p.id) AS total_curtidas,
        (SELECT COUNT(*) FROM comentarios k WHERE k.post_id = p.id) AS total_comentarios
    FROM posts p
    JOIN usuarios u ON u.id = p.usuario_id
    ORDER BY p.data_postagem DESC
";

$resultado = $conn->query($sql);
$posts = [];

while ($row = $resultado->fetch_assoc()) {

    /* Mídias */
    $sm = $conn->prepare("SELECT url, tipo FROM midias_post WHERE post_id = ?");
    $sm->bind_param("i", $row["id"]);
    $sm->execute();
    $rm = $sm->get_result();
    $row["midias"] = [];
    while ($m = $rm->fetch_assoc()) $row["midias"][] = $m;

    /* Comentários com autor */
    $sc = $conn->prepare("
        SELECT c.id, c.comentario, c.data_comentario, u.nome, u.foto_perfil
        FROM comentarios c
        JOIN usuarios u ON u.id = c.usuario_id
        WHERE c.post_id = ?
        ORDER BY c.data_comentario ASC
    ");
    $sc->bind_param("i", $row["id"]);
    $sc->execute();
    $rc = $sc->get_result();
    $row["comentarios"] = [];
    while ($c = $rc->fetch_assoc()) $row["comentarios"][] = $c;

    /* O usuário logado já curtiu? */
    $row["curtiu"] = false;
    if ($cpf_logado) {
        $sk = $conn->prepare("
            SELECT 1 FROM curtidas c
            JOIN usuarios u ON u.id = c.usuario_id
            WHERE c.post_id = ? AND u.cpf = ?
        ");
        $sk->bind_param("is", $row["id"], $cpf_logado);
        $sk->execute();
        $row["curtiu"] = $sk->get_result()->num_rows > 0;
    }

    $posts[] = $row;
}

echo json_encode($posts);
