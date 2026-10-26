# HelpDesk — Sistema de Controle de Chamados

Sistema web de gerenciamento de chamados de suporte de TI, desenvolvido em PHP puro (sem frameworks), MySQL com PDO e Bootstrap 5. Permite registrar ocorrências, acompanhar o andamento e atualizar o status de cada atendimento, simulando o fluxo real de um service desk.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Git](https://img.shields.io/badge/Git-GitHub-F05032?logo=git&logoColor=white)

---

## Sobre o Projeto

Equipes de suporte necessitam de visibilidade sobre o andamento das solicitações técnicas. Este projeto entrega uma solução prática para:

- Abertura de novos chamados com título e descrição do problema;
- Visualização de todas as solicitações em um painel com indicadores por status;
- Atualização do status do atendimento (Aberto → Em Andamento → Resolvido).

O foco da aplicação é demonstrar os fundamentos práticos do desenvolvimento back-end com PHP puro: acesso seguro a banco de dados com PDO, validações de rotas e interface responsiva.

## Funcionalidades

- Cadastro de solicitações de suporte
- Painel de acompanhamento de chamados
- Alteração de status dos atendimentos (Aberto, Em Andamento, Resolvido)
- Interface responsiva com Bootstrap 5

## Tecnologias Utilizadas

| Tecnologia | Finalidade |
|---|---|
| **PHP 8+** | Lógica de negócio, validações e renderização |
| **MySQL + PDO** | Persistência dos dados com Prepared Statements |
| **HTML5 / CSS3** | Estruturação e estilização de telas |
| **Bootstrap 5** | Design responsivo e componentes visuais |
| **Git / GitHub** | Versionamento de código |

## Segurança Aplicada

- **SQL Injection:** Todas as consultas que utilizam dados do usuário utilizam Prepared Statements com PDO.
- **XSS:** Saída de dados dinâmicos tratada com `htmlspecialchars`.
- **Validação Server-side:** Validação de tipos de dados nos formulários e restrição de status permitidos.
- **Proteção de Rotas:** Controle de acesso através de sessões do PHP no arquivo de autenticação.

## Estrutura de Pastas

```text
sistema-chamados/
├── config/
│   └── conexao.php          # Conexão PDO com o banco de dados
├── database.sql             # Script de criação do banco e tabelas
├── index.php                # Painel principal: listagem e alteração de status
├── novo-chamado.php         # Formulário de abertura de chamado
├── salvar-chamado.php       # Processamento do formulário e inserção via PDO
├── atualizar-status.php     # Atualização do status do chamado
└── README.md
```

## Como Executar Localmente

### Pré-requisitos
- PHP 8.0+
- MySQL ou MariaDB
- Servidor local (XAMPP, WAMP ou Laragon)

### Passo a Passo

1. **Clone o repositório** na pasta pública do seu servidor local (`htdocs` no XAMPP):
   ```bash
   git clone https://github.com/cauancarvalh0/sistema-chamados.git
   ```
2. **Crie o banco de dados** importando o arquivo `database.sql` pelo phpMyAdmin.
3. **Configure a conexão** no arquivo `config/conexao.php` ajustando o host, usuário e senha do seu MySQL local (usuário `root` e senha vazia por padrão).
4. **Acesse no navegador:**
   ```
   http://localhost/sistema-chamados/
   ```

## Melhorias Futuras

- Autenticação de usuários (técnico e solicitante)
- Níveis de prioridade e categorias
- Filtros, busca e paginação
- Histórico de alterações de status

## Autor

**Cauan Felipe Carvalho da Silva** — Desenvolvedor Web Júnior

- GitHub: https://github.com/cauancarvalh0
- LinkedIn: https://www.linkedin.com/in/cauancarvalh0
- E-mail: cauancarvalho004@gmail.com
