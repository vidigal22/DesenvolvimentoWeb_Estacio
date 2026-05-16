<?php

header("Content-Type: application/json");

require "conexao.php";

require "dietas.php";

$dados =
json_decode(file_get_contents("php://input"), true);

$acao = $dados["acao"];

/* -------------------------------- */
/* CALCULAR IMC */
/* -------------------------------- */

if($acao == "imc"){

    $nome = $dados["nome"];

    $peso =
    floatval($dados["peso"]);

    $altura =
    floatval($dados["altura"]);

    $cpf =
    $dados["cpf"];

    $renda =
    floatval($dados["renda"]);

    if($peso <= 0 || $altura <= 0){

        echo json_encode([

            "erro" =>
            "Peso ou altura inválidos"
        ]);

        exit;
    }

    /* -------------------------------- */
    /* VERIFICA CPF */
    /* -------------------------------- */

    $sql =
    "SELECT id FROM usuarios
    WHERE cpf = ?";

    $stmt =
    $conn->prepare($sql);

    $stmt->bind_param("s", $cpf);

    $stmt->execute();

    $resultado =
    $stmt->get_result();

    /* -------------------------------- */
    /* SE CPF NÃO EXISTIR */
    /* -------------------------------- */

    if($resultado->num_rows == 0){

        $sql =
        "INSERT INTO usuarios(

            nome,
            cpf

        ) VALUES (?, ?)";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(

            "ss",

            $nome,
            $cpf
        );

        $stmt->execute();

        $usuario_id =
        $conn->insert_id;
    }

    /* -------------------------------- */
    /* SE CPF JÁ EXISTIR */
    /* -------------------------------- */

    else {

        $usuario =
        $resultado->fetch_assoc();

        $usuario_id =
        $usuario["id"];
    }

    /* -------------------------------- */
    /* SALVA HISTÓRICO */
    /* -------------------------------- */

    $sql =
    "INSERT INTO historico_saude(

        usuario_id,
        altura,
        peso,
        renda

    ) VALUES (?, ?, ?, ?)";

    $stmt =
    $conn->prepare($sql);

    $stmt->bind_param(

        "iddd",

        $usuario_id,
        $altura,
        $peso,
        $renda
    );

    $stmt->execute();

    /* -------------------------------- */
    /* CALCULA IMC */
    /* -------------------------------- */

    $imc =
    $peso / ($altura * $altura);

    $classificacao = "";

    if($imc < 18.5){

        $classificacao =
        "Abaixo do peso";

    }

    elseif($imc < 25){

        $classificacao =
        "Peso normal";
    }

    elseif($imc < 30){

        $classificacao =
        "Sobrepeso";
    }

    else {

        $classificacao =
        "Obesidade";
    }

    echo json_encode([

        "nome" => $nome,

        "cpf" => $cpf,

        "imc" =>
        number_format($imc, 2),

        "classificacao" =>
        $classificacao
    ]);

    exit;
}

/* -------------------------------- */
/* DIETA */
/* -------------------------------- */

if($acao == "dieta"){

    $renda =
    floatval($dados["renda"]);

    $objetivo =
    $dados["objetivo"];

    if($renda <= 0){

        echo json_encode([

            "erro" =>
            "Renda inválida"
        ]);

        exit;
    }

    $tipoDieta =
    $renda <= 5000
    ? "simples"
    : "premium";

    if(

        !isset($dietas[$objetivo]) ||

        !isset(
            $dietas[$objetivo][$tipoDieta]
        )
    ){

        echo json_encode([

            "erro" =>
            "Dieta não encontrada"
        ]);

        exit;
    }

    $dieta =
    $dietas[$objetivo][$tipoDieta];

    echo json_encode([

        "tipo" => $tipoDieta,

        "dieta" => $dieta
    ]);

    exit;
}