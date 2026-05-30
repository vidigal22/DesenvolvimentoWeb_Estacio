<?php
require "conexao.php";

header("Content-Type: application/json");

/* Recebe FormData (texto + arquivos) */
$cpf      = $_POST["cpf"]      ?? "";
$conteudo = $_POST["conteudo"] ?? "";

if (!$cpf) { echo json_encode(["erro" => "CPF não informado"]); exit; }

/* usuario_id */
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { echo json_encode(["erro" => "Usuário não encontrado"]); exit; }

$usuario_id = $u["id"];

/* Insere post */
$stmt = $conn->prepare("INSERT INTO posts (usuario_id, conteudo) VALUES (?, ?)");
$stmt->bind_param("is", $usuario_id, $conteudo);
$stmt->execute();
$post_id = $conn->insert_id;

/* Salva mídias */
$midias = [];
if (!empty($_FILES["midias"]["name"][0])) {

    $pastaFisica = __DIR__ . "/../uploads/posts/";
    if (!is_dir($pastaFisica)) mkdir($pastaFisica, 0755, true);

    $total = count($_FILES["midias"]["name"]);
    for ($i = 0; $i < $total; $i++) {
        if ($_FILES["midias"]["error"][$i] !== UPLOAD_ERR_OK) continue;

        $ext           = strtolower(pathinfo($_FILES["midias"]["name"][$i], PATHINFO_EXTENSION));
        $nomeArquivo   = uniqid("post_") . "." . $ext;
        $caminhoFisico = $pastaFisica . $nomeArquivo;
        $urlPublica    = "/uploads/posts/" . $nomeArquivo;
        $tipo          = str_starts_with($_FILES["midias"]["type"][$i], "video") ? "video" : "imagem";

        if (move_uploaded_file($_FILES["midias"]["tmp_name"][$i], $caminhoFisico)) {
            $s = $conn->prepare("INSERT INTO midias_post (post_id, url, tipo) VALUES (?, ?, ?)");
            $s->bind_param("iss", $post_id, $urlPublica, $tipo);
            $s->execute();
            $midias[] = ["url" => $urlPublica, "tipo" => $tipo];
        }
    }
}

echo json_encode(["sucesso" => true, "post_id" => $post_id, "midias" => $midias]);
