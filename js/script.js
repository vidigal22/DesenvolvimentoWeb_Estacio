// Função para calcular o IMC
const imcForm = document.getElementById("imcForm");

if(imcForm){
    imcForm.addEventListener("submit", function(e){
        e.preventDefault();
        let nome = document.getElementById("nome").value;
        let peso = parseFloat(
            document.getElementById("peso")
            .value
            .replace(".", "")
            .replace(",", ".")
        );

        let altura = parseFloat(
            document.getElementById("altura")
            .value
            .replace(".", "")
            .replace(",", ".")
        );

        let cpf = document.getElementById("cpf").value;

        if (!peso || !altura || altura <= 0) {
            alert("Preencha peso e altura corretamente!");
            return;
        }

        let resultado = document.getElementById("resultado");

        fetch("../php/calcular_imc.php", {

            method: "POST",
            headers: {"Content-Type": "application/json"},
            
            body: JSON.stringify({
                acao: "imc",
                nome: nome,
                peso: peso,
                altura: altura,
                cpf: cpf
            })
        }).then(resposta => resposta.json()).then(dados => {
            if(dados.erro){
                alert(dados.erro);
                return;
            }

            resultado.style.display = "block";
            resultado.innerHTML = `
                Cadastro: <strong>${dados.cpf}</strong><br>
                <strong>${dados.nome}</strong>, seu IMC é <strong>${dados.imc}</strong><br>
                Classificação: <strong>${dados.classificacao}</strong>
            `;
            
            let opcoes = document.getElementById("opcoes");

            opcoes.style.display = "flex";

            document.querySelector(".tabela-imc").style.display = "flex";

            let botoes = document.querySelectorAll(".opcoes button");

            if(dados.imc < 18.5){
                botoes[1].style.background = "#3498db";
            } else if(dados.imc >= 25){
                botoes[0].style.background = "#e74c3c";
            }
            }).catch(erro => {console.error(erro);

            alert("Erro ao conectar com o servidor.");
        });
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

const botoesObjetivo = document.querySelectorAll(".opcoes button");
const campoRenda = document.getElementById("campoRenda");

botoesObjetivo.forEach(botao => {
    botao.addEventListener("click", () => {
        objetivoSelecionado = botao.textContent;

        campoRenda.style.display = "flex";
    });
});

/* ------------------------------------*/

let objetivoSelecionado = "";

document.getElementById("confirmarRenda").addEventListener("click", () => {

    const renda =parseFloat(document.getElementById("renda").value.replace(/\./g, "").replace(",", "."))

    if(!renda){
        alert("Informe uma renda válida!");

        return;
    }

    fetch("../php/calcular_imc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    
        body: JSON.stringify({
            acao: "dieta",
            renda: renda,
            objetivo: objetivoSelecionado,
            cpf: document.getElementById("cpf").value
        })
    }).then(resposta => {   
        if(!resposta.ok){  
            throw new Error("Erro no servidor");
        }
    
        return resposta.json();
    }).then(dados => {    
        if(dados.erro){    
            alert(dados.erro);   
            return;
        }
    
        const dietaResultado = document.getElementById("dietaResultado");
    
        dietaResultado.style.display = "block";
    
        dietaResultado.innerHTML = dados.dieta;
    }).catch(erro => {    
        console.error(erro);
    
        alert("Erro ao buscar dieta.");
    });
});


function aplicarMascaraDecimal(idCampo){
    const campo = document.getElementById(idCampo);

    campo.addEventListener("input", () => {

        let valor = campo.value.replace(/\D/g, "");

        if(valor === ""){
            campo.value = "";
            return;
        }

        valor = (parseInt(valor) / 100)
        .toLocaleString("pt-BR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        campo.value = valor;
    });
}

aplicarMascaraDecimal("altura");

aplicarMascaraDecimal("peso");

aplicarMascaraDecimal("renda");

function aplicarMascaraCPF(){

    const campoCPF = document.getElementById("cpf");

    campoCPF.addEventListener("input", () => {
        let valor = campoCPF.value;

        // remove tudo que não for número
        valor = valor.replace(/\D/g, "");

        // limita a 11 números
        valor = valor.slice(0, 11);

        // coloca pontos e traço
        valor = valor.replace(
            /(\d{3})(\d)/,
            "$1.$2"
        );

        valor = valor.replace(
            /(\d{3})(\d)/,
            "$1.$2"
        );

        valor = valor.replace(
            /(\d{3})(\d{1,2})$/,
            "$1-$2"
        );

        campoCPF.value = valor;
    });
}

aplicarMascaraCPF();