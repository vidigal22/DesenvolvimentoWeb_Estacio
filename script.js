// Função para calcular o IMC
document.getElementById("imcForm").addEventListener("submit", function(e){
    e.preventDefault();

    let nome = document.getElementById("nome").value;
    let peso = parseFloat(document.getElementById("peso").value);
    let altura = parseFloat(document.getElementById("altura").value);
    let cpf = document.getElementById("cpf").value;

    // Validação
    if (!peso || !altura || altura <= 0) {
        alert("Preencha peso e altura corretamente!");
        return;
    }

    let imc = peso / (altura * altura);
    imc = imc.toFixed(2);

    let classificacao = "";
    let resultado = document.getElementById("resultado");

    // Reset cor padrão
    resultado.style.background = "#333";

    if(imc < 18.5){
        classificacao = "Abaixo do peso";
        
    } else if(imc < 25){
        classificacao = "Peso normal";
        
    } else if(imc < 30){
        classificacao = "Sobrepeso";
        
    } else {
        classificacao = "Obesidade";
        
    }

    // Mostrar resultado
    resultado.style.display = "block";
    resultado.innerHTML = `
    Cadastro: <strong>${cpf}</strong><br><strong>${nome}</strong>, seu IMC é <strong>${imc}</strong> <br>
        Classificação: <strong>${classificacao}</strong>
    `;

    // Mostrar opções
    let opcoes = document.getElementById("opcoes");
    opcoes.style.display = "flex";

    // Mostrar tabela IMC
    document.querySelector(".tabela-imc").style.display = "flex";

    // Destacar botão conforme IMC
    let botoes = document.querySelectorAll(".opcoes button");

    // Reset cores
    botoes.forEach(btn => btn.style.background = "aquamarine");

    if(imc < 18.5){
        botoes[1].style.background = "#3498db"; // ganhar peso
    } else if(imc >= 25){
        botoes[0].style.background = "#e74c3c"; // perder peso
    }
});


// Função para o botão Atualizar (reset)
document.getElementById("btnAtualizar").addEventListener("click", function() {

    // Limpa formulário
    document.getElementById("imcForm").reset();

    // Esconde resultado
    let resultado = document.getElementById("resultado");
    resultado.style.display = "none";
    resultado.innerHTML = "";

    // Esconde opções
    document.getElementById("opcoes").style.display = "none";

    // ✅ NOVO - Esconde tabela IMC
    document.querySelector(".tabela-imc").style.display = "none";

    // Foco no nome
    document.getElementById("nome").focus();
});