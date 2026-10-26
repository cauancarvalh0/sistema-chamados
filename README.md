# 🛠️ HelpDesk — Sistema de Controle de Chamados

Sistema web de **gerenciamento de chamados de suporte de TI**, desenvolvido em **PHP puro (sem frameworks)** com **PDO** e **MySQL**. Permite registrar ocorrências, acompanhar o andamento e atualizar o status de cada atendimento, simulando o fluxo real de um service desk.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Git](https://img.shields.io/badge/Git-GitHub-F05032?logo=git&logoColor=white)

---

## 🎯 Propósito

Equipes de suporte precisam de visibilidade sobre o que está aberto, em andamento e resolvido. Este projeto entrega um painel simples e objetivo para:

- Abrir novos chamados com título e descrição do problema;
- Visualizar todos os chamados em um painel com indicadores por status;
- Alterar o status do atendimento (**Aberto → Em Andamento → Resolvido**).

O foco do projeto é demonstrar **boas práticas de back-end com PHP puro**: acesso a dados seguro, validação, separação de responsabilidades e interface responsiva.

## 🧰 Tecnologias

| Tecnologia | Uso |
|---|---|
| **PHP 8+** | Lógica de negócio e renderização das páginas |
| **PDO** | Acesso ao banco com *prepared statements* |
| **MySQL / MariaDB** | Persistência dos chamados |
| **Bootstrap 5** | Interface responsiva (via CDN) |
| **Git / GitHub** | Versionamento e publicação |

## 🔐 Segurança aplicada

- **SQL Injection:** todas as consultas com entrada do usuário usam *prepared statements* do PDO (`ATTR_EMULATE_PREPARES = false`).
- **XSS:** toda saída dinâmica é escapada com `htmlspecialchars`.
- **CSRF:** formulários protegidos por token de sessão validado com `hash_equals`.
- **Validação server-side:** ID validado como inteiro e status validado por *whitelist*.
- **Tratamento de erros:** exceções do PDO são registradas em log, sem expor detalhes ao usuário.

## 🏗️ Arquitetura

```
helpdesk-chamados/
├── config/
│   └── conexao.php          # Conexão PDO (try/catch, modo de exceções)
├── database.sql             # Criação do banco db_chamados e da tabela chamados
├── index.php                # Painel: lista, badges de status e alteração de status
├── novo-chamado.php         # Formulário de abertura de chamado
├── salvar-chamado.php       # Recebe o POST e insere o chamado com PDO
├── atualizar-status.php     # Atualiza o status de um chamado pelo ID
└── README.md
```

### Fluxo da aplicação

```
[novo-chamado.php] --POST--> [salvar-chamado.php] --INSERT--> [MySQL]
                                      |
                                      v
                               [index.php] <--SELECT-- [MySQL]
                                      |
                                      +--POST--> [atualizar-status.php] --UPDATE--> [MySQL]
```

### Telas (descrição)

- **Painel (`index.php`):** cards de resumo por status, tabela responsiva com badges coloridos (🔴 Aberto, 🟡 Em Andamento, 🟢 Resolvido) e menu "Alterar status" em cada linha.
- **Novo chamado (`novo-chamado.php`):** formulário centralizado com campos de título e descrição, validação e mensagens de erro.

> 💡 Dica: adicione prints reais na pasta `docs/` e referencie-os aqui, por exemplo: `![Painel](docs/painel.png)`.

## ⚙️ Como executar localmente

### Pré-requisitos
- PHP 8.0 ou superior
- MySQL ou MariaDB
- XAMPP, WAMP, Laragon (ou PHP + MySQL instalados)

### Passo a passo

1. **Clone o repositório**
   ```bash
   git clone https://github.com/cauancarvalh0/helpdesk-chamados.git
   ```
2. **Mova o projeto** para a pasta pública do servidor (`htdocs` no XAMPP ou `www` no Laragon).
3. **Crie o banco de dados** importando o script:
   - Pelo phpMyAdmin (aba *Importar* → `database.sql`), ou
   - Pelo terminal:
     ```bash
     mysql -u root -p < database.sql
     ```
4. **Configure a conexão** em `config/conexao.php` (host, usuário e senha do seu MySQL).
5. **Acesse no navegador:**
   ```
   http://localhost/helpdesk-chamados/
   ```

## 🚀 Melhorias futuras

- Autenticação de usuários (técnico e solicitante)
- Níveis de prioridade e categorias
- Filtros, busca e paginação
- Edição e exclusão de chamados
- Histórico de alterações de status

## 👨‍💻 Autor

**Cauan Felipe Carvalho da Silva** — Desenvolvedor Web

- 🌐 Portfólio: [cauancarvalho.netlify.app](https://cauancarvalho.netlify.app)
- 🐙 GitHub: [github.com/cauancarvalh0](https://github.com/cauancarvalh0)
- 💼 LinkedIn: [linkedin.com/in/cauancarvalho0](https://www.linkedin.com/in/cauancarvalho0)
- 📧 E-mail: [cauancarvalho004@gmail.com](mailto:cauancarvalho004@gmail.com)
- 📸 Instagram: [@dev_cauan](https://instagram.com/dev_cauan)

---

⭐ Se este projeto foi útil, deixe uma estrela no repositório!
