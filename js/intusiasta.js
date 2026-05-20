/* DADOS DO USUÁRIO LOGADO (vem do modal CPF)*/
const cpfLogado  = localStorage.getItem("cpf")  || "";
const nomeLogado = localStorage.getItem("nome") || "Você";
   
/* FOTO DE PERFIL */
const avatarEl   = document.getElementById("previewFoto");
const inputFotoP = document.getElementById("fotoPerfil");

/* Carrega foto salva ao abrir a página */
(function carregarFotoPerfil() {
    if (!cpfLogado) return;

    fetch(`../php/buscar_foto.php?cpf=${encodeURIComponent(cpfLogado)}`).then(r => r.json()).then(d => { if (d.foto_perfil) avatarEl.src = d.foto_perfil; }).catch(() => {});
})();

/* Clicar na foto abre seletor */
avatarEl.addEventListener("click", () => inputFotoP.click());

/* Trocar foto → preview + upload */
inputFotoP.addEventListener("change", () => {
    const arquivo = inputFotoP.files[0];
    if (!arquivo) return;

    /* preview imediato */
    const leitor = new FileReader();
    leitor.onload = e => { avatarEl.src = e.target.result; };
    leitor.readAsDataURL(arquivo);

    if (!cpfLogado) { showToast("Faça o login primeiro!"); return; }

    const fd = new FormData();
    fd.append("foto", arquivo);
    fd.append("cpf",  cpfLogado);

    fetch("../php/upload_foto.php", { method: "POST", body: fd }).then(r => r.json()).then(d => {
            if (d.caminho) {
                avatarEl.src = d.caminho;
                showToast("Foto de perfil atualizada! ✅");
            } else {
                showToast(d.erro || "Erro ao salvar foto.");
            }
        }).catch(() => showToast("Erro de conexão ao salvar foto."));
});

/* ABRIR / FECHAR FORMULÁRIO DE PUBLICAÇÃO */
const openBtn   = document.getElementById("openPublish");
const formEl    = document.getElementById("publishForm");
const cancelBtn = document.getElementById("cancelPublish");
const shortcuts = document.querySelector(".publish-shortcuts");

function openForm() {
    formEl.classList.add("open");
    shortcuts.style.display = "none";
    openBtn.parentElement.style.display = "none";
}

openBtn.addEventListener("click", openForm);

["shortcutVideo","shortcutFoto","shortcutArtigo"].forEach(id => {
    document.getElementById(id).addEventListener("click", openForm);
});

cancelBtn.addEventListener("click", resetarForm);

function resetarForm() {
    formEl.classList.remove("open");
    shortcuts.style.display = "flex";
    openBtn.parentElement.style.display = "flex";
    document.getElementById("postText").value = "";
    document.getElementById("previewArea").innerHTML = "";
    attachedFiles = [];
}

/* PREVIEW DE MÍDIA ANEXADA */
let attachedFiles = [];

function handleFiles(files, type) {
    Array.from(files).forEach(file => {
        attachedFiles.push(file);
        const url  = URL.createObjectURL(file);
        const item = document.createElement("div");
        item.className = "preview-item";
        item.innerHTML = type === "video"
            ? `<video src="${url}" controls></video>`
            : `<img src="${url}" alt="preview">`;
        const rm = document.createElement("button");
        rm.className   = "remove-btn";
        rm.textContent = "✕";
        rm.onclick = () => {
            const idx = attachedFiles.indexOf(file);
            if (idx > -1) attachedFiles.splice(idx, 1);
            item.remove();
        };
        item.appendChild(rm);
        document.getElementById("previewArea").appendChild(item);
    });
}

document.getElementById("inputVideo").addEventListener("change", e => handleFiles(e.target.files, "video"));
document.getElementById("inputFoto").addEventListener("change",  e => handleFiles(e.target.files, "image"));

/* PUBLICAR POST → SALVA NO BANCO */
document.getElementById("submitPost").addEventListener("click", () => {
    const texto = document.getElementById("postText").value.trim();

    if (!texto && attachedFiles.length === 0) {
        showToast("Escreva algo antes de publicar!");
        return;
    }

    if (!cpfLogado) {
        showToast("Você precisa estar logado para publicar!");
        return;
    }

    fetch("../php/salvar_post.php", {
        method:  "POST",
        headers: { "Content-Type": "application/json" },
        body:    JSON.stringify({ cpf: cpfLogado, conteudo: texto })
    }).then(r => r.json()).then(d => {
        if (d.erro) { showToast(d.erro); return; }

        /* Monta mídia HTML (URLs temporárias locais — ok para exibição imediata) */
        let mediaHTML = "";
        attachedFiles.forEach(file => {
            const url = URL.createObjectURL(file);
            mediaHTML += file.type.startsWith("video")
                ? `<div class="post-media"><video controls style="width:100%;max-height:340px;"><source src="${url}"></video></div>`
                : `<div class="post-media"><img src="${url}" alt="imagem"></div>`;
        });

        const fotoSrc = avatarEl.src;
        criarCardPost({
            id:           d.post_id,
            nome:         nomeLogado,
            cpf:          cpfLogado,
            foto_perfil:  fotoSrc,
            conteudo:     texto,
            data_postagem: "Agora mesmo",
            mediaHTML:    mediaHTML,
            dono:         true
        }, true);

        resetarForm();
        showToast("Publicação criada com sucesso! 🎉");
    }).catch(() => showToast("Erro ao salvar publicação."));
});

/* BUSCAR POSTS DO BANCO AO CARREGAR A PÁGINA */
(function carregarPosts() {
    fetch("../php/buscar_posts.php").then(r => r.json()).then(posts => {
        posts.forEach(p => {
            criarCardPost({
                id:           p.id,
                nome:         p.nome,
                cpf:          p.cpf,
                foto_perfil:  p.foto_perfil || "",
                conteudo:     p.conteudo,
                data_postagem: formatarData(p.data_postagem),
                mediaHTML:    "",
                dono:         p.cpf === cpfLogado
            }, false);
        });
    }).catch(() => {});
})();

/* CRIAR CARD DE POST */
function criarCardPost(p, noTopo) {
    const card = document.createElement("div");
    card.className    = "post-card";
    card.dataset.postId = p.id;

    /* Avatar: foto salva ou emoji padrão */
    const avatarHTML = p.foto_perfil
        ? `<img src="${p.foto_perfil}" alt="foto" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`
        : "👤";

    /* Botões editar/deletar — só para o dono */
    const botoesOwner = p.dono ? `
        <button class="btn-editar-post" title="Editar" onclick="editarPost(this)">✏️</button>
        <button class="btn-deletar-post" title="Deletar" onclick="deletarPost(this)">🗑️</button>
    ` : "";

    card.innerHTML = `
        <div class="post-header">
            <div class="avatar">${avatarHTML}</div>
            <div class="post-user-info">
                <strong>${escapeHTML(p.nome)}</strong>
                <span class="role">Membro da Comunidade</span>
                <span class="time">${p.data_postagem}</span>
            </div>
            <div class="post-owner-actions">${botoesOwner}</div>
            ${!p.dono ? `<button class="follow-btn" onclick="toggleFollow(this)">+ Seguir</button>` : ""}
        </div>
        <div class="post-text" data-original="${escapeAttr(p.conteudo)}">${escapeHTML(p.conteudo).replace(/\n/g,"<br>")}</div>
        ${p.mediaHTML || ""}
        <div class="post-stats">
            <span class="reaction-icons"></span>
            <span class="stats-texto">0 reações · 0 comentários</span>
        </div>
        <div class="post-actions">
            <button class="action-btn" onclick="toggleLike(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Curtir
            </button>
            <button class="action-btn" onclick="toggleComments(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Comentar
            </button>
            <button class="action-btn" onclick="sharePost(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 17 20 12 15 7"/><path d="M4 18v-2a4 4 0 0 1 4-4h12"/></svg>
                Compartilhar
            </button>
        </div>
        <div class="comments-section">
            <div class="comment-input-row">
                <div class="avatar" style="width:34px;height:34px;font-size:0.9rem;">👤</div>
                <input type="text" placeholder="Adicione um comentário..." onkeypress="addComment(event,this)">
                <button onclick="submitComment(this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    `;

    const feed = document.getElementById("postsFeed");
    if (noTopo) {
        feed.insertBefore(card, feed.firstChild);
    } else {
        feed.appendChild(card);
    }
}

/* EDITAR POST */
window.editarPost = function(btn) {
    const card     = btn.closest(".post-card");
    const postId   = card.dataset.postId;
    const textoDiv = card.querySelector(".post-text");
    const textoAtual = textoDiv.dataset.original;

    /* Se já está em modo edição, ignora */
    if (card.querySelector(".edit-area")) return;

    /* Substitui o texto por um textarea */
    const textarea = document.createElement("textarea");
    textarea.className = "edit-area";
    textarea.value     = textoAtual;
    textarea.style.cssText = `
        width:100%; min-height:80px; padding:10px 18px;
        border:1.5px solid aquamarine; border-radius:8px;
        font-size:0.9rem; font-family:Arial,sans-serif;
        resize:vertical; outline:none; margin-bottom:8px;
        box-sizing:border-box;
    `;
    textoDiv.replaceWith(textarea);

    /* Botões salvar / cancelar edição */
    const acoes = document.createElement("div");
    acoes.style.cssText = "display:flex;gap:8px;padding:0 18px 12px;justify-content:flex-end;";
    acoes.innerHTML = `
        <button class="btn-cancelar" onclick="cancelarEdicao(this)">Cancelar</button>
        <button class="btn-publicar" onclick="salvarEdicao(this,'${postId}')">Salvar</button>
    `;
    textarea.insertAdjacentElement("afterend", acoes);
    textarea.focus();
};

window.cancelarEdicao = function(btn) {
    const card     = btn.closest(".post-card");
    const textarea = card.querySelector(".edit-area");
    const original = textarea.value; /* mantém o valor original */

    /* Restaura a div de texto */
    const textoDiv = document.createElement("div");
    textoDiv.className = "post-text";
    textoDiv.dataset.original = textarea.dataset
        ? textarea.dataset.original || original
        : original;
    /* Pega o original real do dataset do card */
    const textoReal = card.querySelector(".edit-area")?._original || original;
    textoDiv.dataset.original = textoReal;
    textoDiv.innerHTML = escapeHTML(textoReal).replace(/\n/g,"<br>");

    textarea.replaceWith(textoDiv);
    btn.closest("div").remove();
};

window.salvarEdicao = function(btn, postId) {
    const card    = btn.closest(".post-card");
    const textarea = card.querySelector(".edit-area");
    const novoTexto = textarea.value.trim();

    if (!novoTexto) { showToast("O post não pode ficar vazio!"); return; }

    fetch("../php/editar_post.php", {
        method:  "POST",
        headers: { "Content-Type": "application/json" },
        body:    JSON.stringify({ post_id: parseInt(postId), cpf: cpfLogado, conteudo: novoTexto })}).then(r => r.json()).then(d => {
            if (d.erro) { showToast(d.erro); return; }

        /* Restaura a div com o novo texto */
        const textoDiv = document.createElement("div");
        textoDiv.className = "post-text";
        textoDiv.dataset.original = novoTexto;
        textoDiv.innerHTML = escapeHTML(novoTexto).replace(/\n/g,"<br>");
        textarea.replaceWith(textoDiv);
        btn.closest("div").remove();
        showToast("Post editado com sucesso! ✅");
    }).catch(() => showToast("Erro ao editar post."));
};

/* DELETAR POST */
window.deletarPost = function(btn) {
    if (!confirm("Tem certeza que deseja deletar esta publicação?")) return;

    const card   = btn.closest(".post-card");
    const postId = parseInt(card.dataset.postId);

    fetch("../php/deletar_post.php", {
        method:  "POST",
        headers: { "Content-Type": "application/json" },
        body:    JSON.stringify({ post_id: postId, cpf: cpfLogado })
    }).then(r => r.json()).then(d => {
        if (d.erro) { showToast(d.erro); return; }
        card.style.transition = "opacity 0.3s";
        card.style.opacity    = "0";
        setTimeout(() => card.remove(), 300);
        showToast("Publicação deletada.");
    }).catch(() => showToast("Erro ao deletar post."));
};

/* CURTIR */
window.toggleLike = function(btn) {
    btn.classList.toggle("liked");
    btn.innerHTML = btn.classList.contains("liked")
        ? `<svg viewBox="0 0 24 24" fill="#e74c3c" stroke="#e74c3c" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Curtido`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Curtir`;
};

/* COMENTÁRIOS */
window.toggleComments = function(btn) {
    btn.closest(".post-card").querySelector(".comments-section").classList.toggle("open");
};

window.addComment = function(e, input) {
    if (e.key === "Enter") submitComment(input.nextElementSibling);
};

window.submitComment = function(btn) {
    const input    = btn.previousElementSibling;
    const texto    = input.value.trim();
    if (!texto) return;

    const section  = btn.closest(".comments-section");
    const inputRow = btn.closest(".comment-input-row");

    const comment  = document.createElement("div");
    comment.className = "comment";
    comment.innerHTML = `
        <div class="avatar" style="width:34px;height:34px;font-size:0.9rem;">
            ${avatarEl.src && !avatarEl.src.includes("user.png")
                ? `<img src="${avatarEl.src}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`
                : "👤"}
        </div>
        <div class="comment-bubble">
            <strong>${escapeHTML(nomeLogado)}</strong>${escapeHTML(texto)}
        </div>
    `;
    section.insertBefore(comment, inputRow);
    input.value = "";
};

/* SEGUIR / COMPARTILHAR */
window.toggleFollow = function(btn) {
    if (btn.classList.contains("seguindo")) {
        btn.classList.remove("seguindo");
        btn.textContent = "+ Seguir";
    } else {
        btn.classList.add("seguindo");
        btn.textContent = "✓ Seguindo";
        showToast("Você está seguindo este usuário!");
    }
};

window.sharePost = function() {
    navigator.clipboard?.writeText(window.location.href).then(() => showToast("Link copiado! 🔗")).catch(() => showToast("Link copiado! 🔗"));
};

/* HELPERS */
function showToast(msg) {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.classList.add("show");
    setTimeout(() => t.classList.remove("show"), 3000);
}

function escapeHTML(str) {
    return String(str)
        .replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;")
        .replace(/"/g,"&quot;");
}

function escapeAttr(str) {
    return String(str).replace(/"/g,"&quot;").replace(/'/g,"&#39;");
}

function formatarData(dataStr) {
    if (!dataStr) return "";
    const d = new Date(dataStr);
    return d.toLocaleDateString("pt-BR", {
        day:"2-digit", month:"2-digit", year:"numeric",
        hour:"2-digit", minute:"2-digit"
    });
}

/* CSS extra para botões editar/deletar */
const style = document.createElement("style");
style.textContent = `
    .post-owner-actions {
        display: flex;
        gap: 6px;
        margin-left: auto;
    }
    .btn-editar-post, .btn-deletar-post {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        padding: 4px 6px;
        border-radius: 6px;
        transition: background 0.2s;
    }
    .btn-editar-post:hover  { background: #e0fff8; }
    .btn-deletar-post:hover { background: #ffe0e0; }
`;
document.head.appendChild(style);