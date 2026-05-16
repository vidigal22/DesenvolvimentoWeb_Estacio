<?php

header("Content-Type: application/json");



$dados =
json_decode(file_get_contents("php://input"), true);

$acao = $dados["acao"];

/* -------------------------------- */
/* CALCULAR IMC */
/* -------------------------------- */

if($acao == "imc"){

    $nome = $dados["nome"];
    $peso = floatval($dados["peso"]);
    $altura = floatval($dados["altura"]);
    $cpf = $dados["cpf"];

    if($peso <= 0 || $altura <= 0){

        echo json_encode([
            "erro" => "Peso ou altura inválidos"
        ]);

        exit;
    }

    $imc = $peso / ($altura * $altura);

    $classificacao = "";

    if($imc < 18.5){

        $classificacao = "Abaixo do peso";

    } elseif($imc < 25){

        $classificacao = "Peso normal";

    } elseif($imc < 30){

        $classificacao = "Sobrepeso";

    } else {

        $classificacao = "Obesidade";
    }

    echo json_encode([

        "nome" => $nome,
        "cpf" => $cpf,
        "imc" => number_format($imc, 2),
        "classificacao" => $classificacao
    ]);

    exit;
}

/* -------------------------------- */
/* DIETA */
/* -------------------------------- */
require "dietas.php";
if($acao == "dieta"){

    $renda =
    floatval($dados["renda"]);

    $objetivo =
    $dados["objetivo"];

    if($renda <= 0){

        echo json_encode([

            "erro" => "Renda inválida"
        ]);

        exit;
    }

    $tipoDieta =
    $renda <= 5000
    ? "simples"
    : "premium";

    if(
        !isset($dietas[$objetivo]) ||
        !isset($dietas[$objetivo][$tipoDieta])
    ){

        echo json_encode([

            "erro" => "Dieta não encontrada"
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