// intusiastas.js

// ── Open / close publish form ──
const openBtn    = document.getElementById('openPublish');
const form       = document.getElementById('publishForm');
const cancelBtn  = document.getElementById('cancelPublish');
const shortcuts  = document.querySelector('.publish-shortcuts');

function openForm() {
    form.classList.add('open');
    shortcuts.style.display = 'none';
    openBtn.parentElement.style.display = 'none';
}

openBtn.addEventListener('click', openForm);

['shortcutVideo','shortcutFoto','shortcutArtigo'].forEach(id => {
    document.getElementById(id).addEventListener('click', openForm);
});

cancelBtn.addEventListener('click', () => {
    form.classList.remove('open');
    shortcuts.style.display = 'flex';
    openBtn.parentElement.style.display = 'flex';
    document.getElementById('postText').value = '';
    document.getElementById('previewArea').innerHTML = '';
    attachedFiles = [];
});

// ── File preview ──
let attachedFiles = [];

function handleFiles(files, type) {
    Array.from(files).forEach(file => {
        attachedFiles.push(file);
        const url = URL.createObjectURL(file);
        const item = document.createElement('div');
        item.className = 'preview-item';
        item.innerHTML = type === 'video'
            ? `<video src="${url}" controls></video>`
            : `<img src="${url}" alt="preview">`;
        const rmBtn = document.createElement('button');
        rmBtn.className = 'remove-btn';
        rmBtn.textContent = '✕';
        rmBtn.onclick = () => { item.remove(); };
        item.appendChild(rmBtn);
        document.getElementById('previewArea').appendChild(item);
    });
}

document.getElementById('inputVideo').addEventListener('change', e => handleFiles(e.target.files, 'video'));
document.getElementById('inputFoto').addEventListener('change',  e => handleFiles(e.target.files, 'image'));

// ── Submit new post ──
document.getElementById('submitPost').addEventListener('click', () => {
    const text = document.getElementById('postText').value.trim();
    if (!text && attachedFiles.length === 0) {
        showToast('Escreva algo antes de publicar!');
        return;
    }

    const card = document.createElement('div');
    card.className = 'post-card';

    let mediaHTML = '';
    attachedFiles.forEach(file => {
        const url = URL.createObjectURL(file);
        if (file.type.startsWith('video')) {
            mediaHTML += `<div class="post-media"><video controls style="width:100%;max-height:340px;"><source src="${url}"></video></div>`;
        } else {
            mediaHTML += `<div class="post-media"><img src="${url}" alt="imagem do post"></div>`;
        }
    });

    card.innerHTML = `
        <div class="post-header">
            <div class="avatar">👤</div>
            <div class="post-user-info">
                <strong>Você</strong>
                <span class="role">Membro da Comunidade</span>
                <span class="time">Agora mesmo</span>
            </div>
        </div>
        <div class="post-text">${text.replace(/\n/g,'<br>')}</div>
        ${mediaHTML}
        <div class="post-stats">
            <span class="reaction-icons"></span>
            <span>0 reações · 0 comentários</span>
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
                <input type="text" placeholder="Adicione um comentário..." onkeypress="addComment(event, this)">
                <button onclick="submitComment(this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    `;

    const feed = document.getElementById('postsFeed');
    feed.insertBefore(card, feed.firstChild);

    // reset form
    cancelBtn.click();
    showToast('Publicação criada com sucesso! 🎉');
});

// ── Like toggle ──
window.toggleLike = function(btn) {
    btn.classList.toggle('liked');
    btn.innerHTML = btn.classList.contains('liked')
        ? `<svg viewBox="0 0 24 24" fill="#e74c3c" stroke="#e74c3c" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Curtido`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Curtir`;
}

// ── Comments toggle ──
window.toggleComments = function(btn) {
    const section = btn.closest('.post-card').querySelector('.comments-section');
    section.classList.toggle('open');
}

// ── Add comment on Enter ──
window.addComment = function(event, input) {
    if (event.key === 'Enter') submitComment(input.nextElementSibling);
}

window.submitComment = function(btn) {
    const input = btn.previousElementSibling;
    const text = input.value.trim();
    if (!text) return;

    const section = btn.closest('.comments-section');
    const inputRow = btn.closest('.comment-input-row');

    const comment = document.createElement('div');
    comment.className = 'comment';
    comment.innerHTML = `
        <div class="avatar" style="width:34px;height:34px;font-size:0.9rem;">👤</div>
        <div class="comment-bubble">
            <strong>Você</strong> ${text}
        </div>
    `;
    section.insertBefore(comment, inputRow);
    input.value = '';
}

// ── Follow toggle ──
window.toggleFollow = function(btn) {
    if (btn.classList.contains('seguindo')) {
        btn.classList.remove('seguindo');
        btn.textContent = '+ Seguir';
    } else {
        btn.classList.add('seguindo');
        btn.textContent = '✓ Seguindo';
        showToast('Você está seguindo este usuário!');
    }
}

// ── Share ──
window.sharePost = function(btn) {
    showToast('Link copiado para a área de transferência! 🔗');
}

// ── Toast ──
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

/*---------------------------------------- */
const avatar = document.getElementById("previewFoto");

const inputFoto = document.getElementById("fotoPerfil");

/* ── Carrega foto salva ao abrir a página ── */
(function carregarFotoPerfil() {

    const cpf = localStorage.getItem("cpf");

    if (!cpf) return; // usuário ainda não fez cadastro

    fetch(`../php/buscar_foto.php?cpf=${encodeURIComponent(cpf)}`)
        .then(res => res.json())
        .then(dados => {

            if (dados.foto_perfil) {
                avatar.src = dados.foto_perfil;
            }
        })
        .catch(() => { /* silencia erros de rede */ });
})();

/* ── Clicar na foto abre o seletor de arquivo ── */
avatar.addEventListener("click", () => {

    inputFoto.click();
});

/* ── Trocar foto: preview imediato + envio ao servidor ── */
inputFoto.addEventListener("change", () => {

    const arquivo = inputFoto.files[0];

    if (!arquivo) return;

    /* preview instantâneo antes do upload terminar */
    const leitor = new FileReader();

    leitor.onload = function(e) {
        avatar.src = e.target.result;
    };

    leitor.readAsDataURL(arquivo);

    /* pega cpf salvo no login */
    const cpf = localStorage.getItem("cpf");

    if (!cpf) {
        showToast("Faça o cadastro/login primeiro!");
        return;
    }

    /* envia para o servidor */
    const formData = new FormData();

    formData.append("foto", arquivo);
    formData.append("cpf", cpf);

    fetch("../php/upload_foto.php", {
        method: "POST",
        body: formData

    }).then(res => res.json()).then(dados => {

        if (dados.caminho) {
            /* garante que o src aponta para o arquivo definitivo no servidor */
            avatar.src = dados.caminho;
            showToast("Foto de perfil atualizada! ✅");
        } else {
            showToast("Erro ao salvar foto. Tente novamente.");
        }

    }).catch(() => {

        showToast("Erro de conexão ao salvar foto.");
    });
});

