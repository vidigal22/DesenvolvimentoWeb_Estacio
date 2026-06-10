(function () {

    /* ── Injeta HTML do modal ── */
    const modalHTML = `
        <div id="modalCpfProf" style="
            display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.45); z-index:9999;
            align-items:center; justify-content:center;
        ">
            <div style="
                background:white; border-radius:16px;
                padding:32px 28px 24px; width:90%; max-width:380px;
                box-shadow:0 8px 32px rgba(0,0,0,0.18);
                text-align:center; font-family:Arial,sans-serif;
                position:relative;
            ">
                <button id="modalFechProf" style="
                    position:absolute; top:12px; right:14px;
                    background:none; border:none; font-size:1.3rem;
                    cursor:pointer; color:#aaa; line-height:1;
                ">✕</button>

                <div style="font-size:2.8rem; margin-bottom:8px;">🩺</div>

                <h2 style="margin:0 0 4px; font-size:1.2rem; color:#1a1a1a;">
                    Área de Profissionais
                </h2>

                <p style="font-size:0.85rem; color:#777; margin-bottom:20px;">
                    Digite seu CPF para continuar
                </p>

                <input
                    id="modalCpfProfInput"
                    type="text"
                    maxlength="14"
                    placeholder="000.000.000-00"
                    style="
                        width:100%; padding:12px 16px;
                        border:1.5px solid #c8f0ed; border-radius:10px;
                        font-size:1rem; font-family:Arial,sans-serif;
                        outline:none; text-align:center; letter-spacing:1px;
                        margin-bottom:10px; transition:border 0.2s;
                        box-sizing:border-box;
                    "
                >

                <p id="modalMsgProf" style="
                    font-size:0.82rem; min-height:18px;
                    margin-bottom:14px; color:#e74c3c;
                "></p>

                <button id="modalEntrarProf" style="
                    width:100%; padding:12px;
                    background:aquamarine; border:none; border-radius:10px;
                    font-size:1rem; font-weight:bold; color:white;
                    cursor:pointer; transition:background 0.2s, transform 0.15s;
                    font-family:Arial,sans-serif;
                ">Entrar</button>

                <p style="margin-top:14px; font-size:0.8rem; color:#aaa;">
                    Ainda não tem cadastro?
                    <a id="modalLinkCadastroProf" href="#" style="
                        color:#00b0a0; font-weight:bold; text-decoration:none;
                    ">Faça seu IMC primeiro</a>
                </p>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML("beforeend", modalHTML);

    /* ── Detecta pasta ── */
    const emSubpasta = window.location.pathname.includes("/html/");

    const caminhoPhp          = emSubpasta ? "../php/verificar_cpf.php"   : "./php/verificar_cpf.php";
    const caminhoProfissionais = emSubpasta ? "./profissionais.html"       : "./html/profissionais.html";
    const caminhoPag2          = emSubpasta ? "./pag2.html"                : "./html/pag2.html";

    document.getElementById("modalLinkCadastroProf").href = caminhoPag2;

    /* ── Referências ── */
    const modal     = document.getElementById("modalCpfProf");
    const inputCpf  = document.getElementById("modalCpfProfInput");
    const btnEntrar = document.getElementById("modalEntrarProf");
    const btnFechar = document.getElementById("modalFechProf");
    const msgEl     = document.getElementById("modalMsgProf");

    /* ── Abre modal ao clicar em .btn-profissionais ── */
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-profissionais");
        if (btn) {
            e.preventDefault();
            abrirModal();
        }
    });

    function abrirModal() {
        modal.style.display = "flex";
        inputCpf.value      = "";
        msgEl.textContent   = "";
        resetarBotao();
        setTimeout(() => inputCpf.focus(), 80);
    }

    function fecharModal() {
        modal.style.display = "none";
    }

    btnFechar.addEventListener("click", fecharModal);
    modal.addEventListener("click", e => { if (e.target === modal) fecharModal(); });

    /* ── Máscara CPF ── */
    inputCpf.addEventListener("input", function () {
        let v = inputCpf.value.replace(/\D/g, "").slice(0, 11);
        v = v.replace(/(\d{3})(\d)/,       "$1.$2");
        v = v.replace(/(\d{3})(\d)/,       "$1.$2");
        v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        inputCpf.value = v;
    });

    /* ── Enter dispara ── */
    inputCpf.addEventListener("keydown", e => { if (e.key === "Enter") btnEntrar.click(); });

    /* ── Lógica Entrar ── */
    btnEntrar.addEventListener("click", function () {

        const cpf = inputCpf.value.trim();

        if (cpf.length < 14) {
            mostrarMsg("Digite um CPF válido (000.000.000-00)");
            inputCpf.focus();
            return;
        }

        btnEntrar.textContent      = "Verificando...";
        btnEntrar.disabled         = true;
        btnEntrar.style.background = "#a0e0d8";
        msgEl.textContent          = "";

        fetch(caminhoPhp, {
            method:  "POST",
            headers: { "Content-Type": "application/json" },
            body:    JSON.stringify({ cpf: cpf })
        }).then(r => r.json()).then(dados => {
            if (dados.erro) {
                mostrarMsg("Erro no servidor. Tente novamente.");
                resetarBotao();
                return;
            }

            if (dados.encontrado) {

                /* ✅ CPF cadastrado → salva e redireciona */
                localStorage.setItem("cpf",  cpf);
                localStorage.setItem("nome", dados.nome);

                btnEntrar.textContent      = "✓ Encontrado! Redirecionando...";
                btnEntrar.style.background = "#00c9a7";

                setTimeout(() => { window.location.href = caminhoProfissionais; }, 700);

            } else {

                /* CPF não cadastrado → manda para pag2 */
                mostrarMsg("CPF não encontrado. Redirecionando para o cadastro...");
                btnEntrar.textContent      = "Ir para o cadastro";
                btnEntrar.disabled         = false;
                btnEntrar.style.background = "#e74c3c";

                setTimeout(() => { window.location.href = caminhoPag2; }, 1800);
            }
        })
        .catch(() => {
            mostrarMsg("Erro de conexão. Verifique o servidor.");
            resetarBotao();
        });
    });

    function mostrarMsg(texto) { msgEl.textContent = texto; }

    function resetarBotao() {
        btnEntrar.textContent      = "Entrar";
        btnEntrar.disabled         = false;
        btnEntrar.style.background = "aquamarine";
    }

})();