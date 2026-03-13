# Gaia List

Sistema web de gerenciamento colaborativo de tarefas, desenvolvido em PHP puro com MySQL.

## Funcionalidades

- Autenticação com sessões PHP e senhas em bcrypt
- Controle de acesso baseado em três perfis:
  - **Editor** — CRUD completo de tarefas, listas e usuários; acesso ao painel administrativo
  - **Comentador** — visualiza tarefas, altera status e gerencia próprios comentários
  - **Visualizador** — acesso somente leitura
- Gerenciamento de listas e tarefas (título, descrição, status, lista vinculada)
- Filtro de tarefas por status e lista; busca por título via AJAX
- Comentários por tarefa com controle de autoria
- Dashboard com contadores resumidos
- Perfil do usuário com edição de dados, troca de senha e exclusão de conta
- Painel administrativo para gerenciar perfis e excluir usuários


## Tecnologias

| Camada | Tecnologia |
|--------|-----------|
| Backend | PHP (sem framework), PDO |
| Banco de dados | MySQL / MariaDB |
| Frontend | Bootstrap 5.3 + Bootstrap Icons (CDN) |
| JavaScript | Vanilla JS |

## Pré-requisitos

- PHP 7.4+
- MySQL / MariaDB
- Servidor web (Apache, XAMPP, WAMP etc.)

## Instalação

1. Copie o projeto para o diretório raiz do servidor web (ex.: `htdocs/Gaia-List-Project/`).

2. Importe o banco de dados:
   ```
   bd_gaia_list.sql
   ```

3. Configure as credenciais do banco copiando o arquivo de exemplo:
   ```
   cp includes/config.exemplo.php includes/config.php
   ```
   Edite `includes/config.php` com os dados do seu ambiente.

4. Acesse no navegador:
   ```
   http://localhost/Gaia-List-Project/
   ```

## Usuários de teste (seed)

| E-mail | Senha | Perfil |
|--------|-------|--------|
| matheus@email.com | 12345678 | editor |
| fabricio@email.com | 12345678 | comentador |
| joaoguilherme@email.com | 12345678 | visualizador |

## Estrutura do projeto

```
├── index.html               Página inicial
├── login.php / cadastro.php Autenticação
├── dashboard.php            Visão geral
├── tarefas.php              Listagem e CRUD de tarefas
├── listas.php               Gerenciamento de listas
├── tarefa_detalhes.php      Detalhes + comentários
├── perfil.php               Perfil do usuário
├── admin_usuarios.php       Painel administrativo
├── acoes/                   Handlers de ações POST
├── auth/                    Login, cadastro e logout
├── api/                     Endpoint AJAX (busca de tarefas)
├── includes/                Configuração, conexão e partials HTML
├── bd_gaia_list.sql         Schema e dados iniciais
├── style.css                Estilos customizados
└── script.js                JavaScript do cliente
```
