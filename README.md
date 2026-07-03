# Fomento Corporal

Site desenvolvido em **HTML, CSS, JavaScript e PHP** para a disciplina de Desenvolvimento Web (Estácio), sendo a nota principal do período. A plataforma permite calcular o IMC e com base a sua renda mensal cria um regime e treino baseados nisso e no objetivo do usuário, interagir com profissionais e entusiastas da área e publicar posts em um mural social (com curtidas, comentários e upload de fotos/vídeos).

## Funcionalidades

- **Cálculo de IMC**: formulário que calcula o Índice de Massa Corporal e sugere planos de dieta (perder peso, ganhar peso, ganhar músculos, definir corpo), com versões simples e premium com base na renda mensal.
- **Cadastro por CPF**: identificação do usuário via CPF, com verificação e criação automática de registro no banco.
- **Upload de foto de perfil**: envio e recuperação da foto do usuário.
- **Mural de posts**: criação, edição e exclusão de posts, com suporte a mídias (imagens/vídeos).
- **Curtidas e comentários** nos posts.
- **Área de Profissionais** e **área de Entusiastas**, com conteúdos e dicas específicas.
- **Página de dicas de especialistas**.
- **Suporte a múltiplos idiomas** (tradução de textos da interface via `translations.js`).

## Estrutura do projeto

```
DesenvolvimentoWeb_Estacio/
├── index.html                 # Página inicial
├── html/                      # Demais páginas do site
│   ├── pag2.html               # Cálculo de IMC / dietas
│   ├── profissionais.html      # Área de profissionais
│   ├── intusiastas.html        # Área de entusiastas
│   └── dicas_especialistas.html
├── css/                        # Estilos de cada página
├── js/                         # Scripts (mural de posts, modais, traduções)
├── php/                         # Back-end (API em PHP)
│   ├── conexao.php               # Conexão com o banco (usa .env)
│   ├── verificar_cpf.php
│   ├── calcular_imc.php
│   ├── dietas.php
│   ├── upload_foto.php
│   ├── buscar_foto.php
│   ├── salvar_post.php / editar_post.php / deletar_post.php
│   ├── buscar_posts.php
│   ├── curtir_post.php
│   └── salvar_comentario.php
├── setup.php                   # Script para criar o banco e as tabelas
├── uploads/                     # Arquivos enviados pelos usuários (fotos/posts)
├── imagens/                     # Imagens estáticas do site
├── vendor/                      # Dependências do Composer (vlucas/phpdotenv)
├── composer.json / composer.lock
└── .env                         # Credenciais do banco (não versionar)
```

## Tecnologias utilizadas

- **HTML5 / CSS3**
- **JavaScript** (vanilla)
- **PHP 8** (mysqli)
- **MySQL**
- [**vlucas/phpdotenv**](https://github.com/vlucas/phpdotenv) para gerenciar variáveis de ambiente

## Pré-requisitos

- PHP 8 ou superior com extensão `mysqli` habilitada
- MySQL (ou MariaDB)
- [Composer](https://getcomposer.org/)
- Servidor web local (embutido do PHP, XAMPP, MAMP, etc.)

## Como executar o projeto

1. **Clone o repositório**
   ```bash
   git clone <url-do-repositorio>
   cd DesenvolvimentoWeb_Estacio
   ```

2. **Instale as dependências PHP**
   ```bash
   composer install
   ```

3. **Configure as variáveis de ambiente**

   Crie um arquivo `.env` na raiz do projeto com as credenciais do seu banco MySQL:
   ```
   DB_HOST=localhost
   DB_USER=seu_usuario
   DB_PASS=sua_senha
   DB_NAME=fomento_corporal
   ```

4. **Crie o banco de dados e as tabelas**

   Execute o script `setup.php` (via navegador ou linha de comando) para criar o banco `fomento_corporal` e todas as tabelas necessárias (`usuarios`, `historico_saude`, `historico_renda`, `posts`, `midias_post`, `curtidas`, `comentarios`):
   ```bash
   php setup.php
   ```

5. **Suba um servidor local**
   ```bash
   php -S localhost:8000
   ```
   Em seguida, acesse `http://localhost:8000/index.html` no navegador.

## Observações

- A pasta `uploads/` é usada para armazenar as fotos de perfil e as mídias dos posts enviados pelos usuários.
- O arquivo `.env` contém dados sensíveis e não deve ser versionado (já está listado no `.gitignore`).

## Licença

Este projeto está licenciado sob os termos da licença [MIT](LICENSE).

## Autor

Vinicius Vidigal
