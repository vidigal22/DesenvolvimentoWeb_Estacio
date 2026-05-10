// Função para calcular o IMC
const imcForm = document.getElementById("imcForm");

if(imcForm){

    imcForm.addEventListener("submit", function(e){

        e.preventDefault();

        let nome = document.getElementById("nome").value;
        let peso = parseFloat(document.getElementById("peso").value);
        let altura = parseFloat(document.getElementById("altura").value);
        let cpf = document.getElementById("cpf").value;

        if (!peso || !altura || altura <= 0) {
            alert("Preencha peso e altura corretamente!");
            return;
        }

        let imc = peso / (altura * altura);
        imc = imc.toFixed(2);

        let classificacao = "";
        let resultado = document.getElementById("resultado");

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

        resultado.style.display = "block";

        resultado.innerHTML = `
        Cadastro: <strong>${cpf}</strong><br>
        <strong>${nome}</strong>, seu IMC é <strong>${imc}</strong><br>
        Classificação: <strong>${classificacao}</strong>
        `;

        let opcoes = document.getElementById("opcoes");
        opcoes.style.display = "flex";

        document.querySelector(".tabela-imc").style.display = "flex";

        let botoes = document.querySelectorAll(".opcoes button");

        botoes.forEach(btn => btn.style.background = "aquamarine");

        if(imc < 18.5){
            botoes[1].style.background = "#3498db";
        } else if(imc >= 25){
            botoes[0].style.background = "#e74c3c";
        }

    });
}


// Função para o botão Atualizar (reset)
const btnAtualizar = document.getElementById("btnAtualizar");

if(btnAtualizar){

    btnAtualizar.addEventListener("click", function() {

        document.getElementById("imcForm").reset();

        let resultado = document.getElementById("resultado");

        resultado.style.display = "none";
        resultado.innerHTML = "";

        document.getElementById("opcoes").style.display = "none";

        document.querySelector(".tabela-imc").style.display = "none";

        document.getElementById("nome").focus();
    });
}

const languageSelect = document.getElementById("language");

function changeLanguage(language) {

    // pega todos os elementos com data-lang
    const elements = document.querySelectorAll("[data-lang]");

    elements.forEach(element => {

        const key = element.getAttribute("data-lang");

        element.textContent = translations[language][key];
    });

    // salva idioma escolhido
    localStorage.setItem("language", language);
}

// troca idioma ao mudar select
languageSelect.addEventListener("change", () => {

    changeLanguage(languageSelect.value);
});

// idioma salvo
const savedLanguage = localStorage.getItem("language") || "pt";

languageSelect.value = savedLanguage;

changeLanguage(savedLanguage);

/* ------------------------------------*/

const botoesObjetivo =
document.querySelectorAll(".opcoes button");

const campoRenda =
document.getElementById("campoRenda");

botoesObjetivo.forEach(botao => {

    botao.addEventListener("click", () => {

        campoRenda.style.display = "flex";
    });
});