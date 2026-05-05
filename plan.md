# Plano: Sistema de Avaliação de Optativas/Professores (Glassdoor Acadêmico)

## Contexto

Trabalho Prático da disciplina Tópicos Especiais. Sistema onde alunos avaliam optativas e professores, com mecânica "give to get" (só vê reviews de outros se postar a sua). Backend Laravel, frontend Vue + Quasar.

## Arquitetura Geral
tp-testes/
backend/ # Laravel API
frontend/ # Vue 3 + Quasar SPA

text

## Backend (Laravel)

### Models

- **User** — nome, email, senha, matricula, curso, role (aluno/admin)
- **Curso (Course)** — nome, codigo, departamento, descricao
- **Professor** — nome, email, departamento
- **Optativa (Elective)** — nome, codigo, curso_id, professor_id, semestre, descricao, creditos
- **Avaliacao (Review)** — user_id, optativa_id, nota_geral (1-5), nota_didatica (1-5), nota_conteudo (1-5), nota_dificuldade (1-5), comentario, tags (ex: "muita leitura", "provas
  ur anser is divided Aqui está o arquivo completo e formatado em Markdown. Salve como PLANO_SISTEMA_AVALIACAO.md:

markdown
# Plano: Sistema de Avaliação de Optativas/Professores (Glassdoor Acadêmico)

## Contexto

Trabalho Prático da disciplina Tópicos Especiais. Sistema onde alunos avaliam optativas e professores, com mecânica "give to get" (só vê reviews de outros se postar a sua). Backend Laravel, frontend Vue + Quasar.

## Arquitetura Geral
tp-testes/
backend/ # Laravel API
frontend/ # Vue 3 + Quasar SPA

text

## Backend (Laravel)

### Models

- **User** — nome, email, senha, matricula, curso, role (aluno/admin)
- **Curso (Course)** — nome, codigo, departamento, descricao
- **Professor** — nome, email, departamento
- **Optativa (Elective)** — nome, codigo, curso_id, professor_id, semestre, descricao, creditos
- **Avaliacao (Review)** — user_id, optativa_id, nota_geral (1-5), nota_didatica (1-5), nota_conteudo (1-5), nota_dificuldade (1-5), comentario, tags (ex: "muita leitura", "provas
  Desculpe pela interrupção! Aqui está o arquivo completo de uma só vez:

markdown
# Plano: Sistema de Avaliação de Optativas/Professores (Glassdoor Acadêmico)

## Contexto

Trabalho Prático da disciplina Tópicos Especiais. Sistema onde alunos avaliam optativas e professores, com mecânica "give to get" (só vê reviews de outros se postar a sua). Backend Laravel, frontend Vue + Quasar.

## Arquitetura Geral
tp-testes/
backend/ # Laravel API
frontend/ # Vue 3 + Quasar SPA

text

## Backend (Laravel)

### Models

- **User** — nome, email, senha, matricula, curso, role (aluno/admin)
- **Curso (Course)** — nome, codigo, departamento, descricao
- **Professor** — nome, email, departamento
- **Optativa (Elective)** — nome, codigo, curso_id, professor_id, semestre, descricao, creditos
- **Avaliacao (Review)** — user_id, optativa_id, nota_geral (1-5), nota_didatica (1-5), nota_conteudo (1-5), nota_dificuldade (1-5), comentario, tags (ex: "muita leitura", "provas dificeis"), anonima (bool), created_at
    - Aluno escolhe no momento de postar se a review e anonima ou identificada
    - Se anonima, o card mostra "Aluno Anonimo" no lugar do nome; se identificada, mostra o nome real
    - Sem moderacao — reviews entram no ar imediatamente apos postagem

### Regra de Negocio Principal: "Give to Get"

- Usuario logado que NAO postou nenhuma avaliacao ve uma lista censurada (so ve medias agregadas, sem comentarios nem autores)
- Usuario logado que JA postou pelo menos 1 avaliacao ve reviews completas com comentarios. Reviews anonimas mostram "Aluno Anonimo", identificadas mostram o nome do autor
- Admin sempre ve tudo (inclusive o nome real por tras de reviews anonimas)
- Reviews sao postadas diretamente (sem fila de aprovacao)

### API Endpoints

```php
POST   /api/auth/register
POST   /api/auth/login
GET    /api/auth/me

GET    /api/cursos
GET    /api/cursos/:id

GET    /api/professores
GET    /api/professores/:id

GET    /api/optativas                    # listagem com busca/filtros
GET    /api/optativas/:id                # detalhe com medias + reviews (gateada)

POST   /api/optativas/:id/avaliacoes     # criar avaliacao
GET    /api/avaliacoes/minha             # minhas avaliacoes

# Admin
GET    /api/admin/avaliacoes
DELETE /api/admin/avaliacoes/:id
Testes (Etapa 1 — min 70% codecov)
Unit tests para Models, regras de negocio, policies

Feature tests para API endpoints

CI/CD com GitHub Actions rodando PHPUnit + codecov

Testes (Etapa 2 — min 90% codecov)
Testes e2e cobrindo fluxos completos (registro, login, postar avaliacao, ver reviews)

Frontend (Vue 3 + Quasar)
Paginas
/login — Login

/registro — Cadastro

/ — Home com listagem de optativas (busca, filtros)

/optativas/:id — Detalhe da optativa com medias e reviews

/perfil — Minhas avaliacoes, estatisticas pessoais

/admin — Painel admin (gerenciar avaliacoes)

Estados da Tela de Detalhe
Nao logado: ve medias, ve "faca login para ver reviews"

Logado sem ter postado: ve medias, ve "Poste uma avaliacao para desbloquear os comentarios", botao para avaliar

Logado com avaliacao postada: ve tudo — medias, comentarios, tags

Componentes Chave
StarRating — componente de estrelas para notas

ReviewCard — card de avaliacao com notas, comentario, tags

ReviewForm — formulario de avaliacao com toggle "Postar como anonimo"

ElectiveCard — card de optativa na listagem

AuthGate — wrapper que controla visibilidade baseada no estado da sessao

Plano de Execucao
Step 1: Setup do projeto Laravel (backend)
composer create-project laravel/laravel backend

Configurar Laravel Sail (Docker) com MySQL

Criar models, migrations, seeders

Step 2: Setup do projeto Quasar (frontend)
npm create quasar ou Vue + Quasar CLI

Configurar router, axios, estrutura basica

Step 3: API — Auth
Implementar registro, login (Laravel Sanctum ou token API simples)

Middleware de auth

Step 4: API — Catalogos
CRUD basico de Cursos, Professores, Optativas

Seeders com dados de exemplo

Step 5: API — Avaliacoes + Give to Get
CRUD de avaliacoes

Logica de gate: middleware/policy que verifica se usuario pode ver reviews completas

Step 6: Frontend — Paginas publicas
Home com listagem de optativas

Pagina de detalhe (com estados de visibilidade)

Step 7: Frontend — Auth e Avaliacoes
Login, registro

Formulario de avaliacao

Gate visual de "poste para desbloquear"

Step 8: Testes Etapa 1
Unit tests + Feature tests

Configurar GitHub Actions + codecov

Resumo das Decisoes
Decisao	Escolha
Anonimato	Aluno escolhe se anonima ou nao
Moderacao	Sem fila de aprovacao
Dados iniciais	Seeders ficticios
Banco	MySQL via Laravel Sail
Arquivos/fotos	Nao vai ter
text

Pronto! O arquivo está completo e pode ser salvo como `PLANO_SISTEMA_AVALIACAO.md` na raiz do seu projeto.
