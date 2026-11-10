# PokéLar - Centro de Resgate e Adoção Pokémon

Projeto acadêmico desenvolvido para a disciplina de SCOM. O **PokéLar** é um portal dinâmico Full-Stack dedicado ao resgate, reabilitação e gestão de solicitações de adoção responsável de Pokémon na região de Kanto.

---

## Estrutura de Arquivos do Projeto
pokelar/
├── admin/                     # Área Administrativa Protegida
│   ├── adocoes.php            # Painel de Gestão de Solicitações e Status
│   ├── create.php             # Form de Cadastro com Upload de Imagens
│   ├── editar.php             # Form de Edição de Pokémon
│   ├── exportar-csv.php       # Gerador e Download de Relatório CSV
│   └── index.php              # Painel Geral do Administrador
├── config/
│   └── database.php           # Conexão PDO Singleton com o MySQL
├── css/
│   └── style.css              # Estilização Unificada do Sistema
├── img/                       # Ativos de Imagens Estáticas da Interface
├── logs/
│   ├── .gitkeep               # Preservador da Pasta no Git
│   └── app.log                # Log de Auditoria do Sistema
├── src/
│   ├── Auth.php               # Middleware de Autenticação e Permissões
│   ├── Csrf.php               # Gerador e Validador de Tokens CSRF
│   └── Logger.php             # Classe de Registro de Logs do Sistema
├── uploads/                   # Diretório de Imagens Enviadas via Upload Real
│   └── .gitkeep
├── adocao-sucesso.php         # Confirmação do Agendamento de Visita
├── agendar-visita.php         # Form Público de Seleção de Data/Hora de Visita
├── cadastro.php               # Registro de Novos Treinadores
├── como-adotar.php            # Instruções do Processo de Adoção
├── index.php                  # Página Inicial do Portal
├── login.php                  # Tela de Autenticação
├── logout.php                 # Encerramento de Sessão
├── minha-conta.php            # Painel do Treinador Logado (Meus Agendamentos)
├── pokemon.php                # Catálogo Dinâmico com Filtros por Tipo e Porte
├── schema.sql                 # Script SQL para Criação do Banco e Tabelas
├── sobre.php                  # Informações sobre a ONG PokéLar
└── README.md                  # Documentação do Projeto
---

## Instruções de Inicialização e Execução

### Pré-requisitos:
- Servidor Web Apache com PHP 8.2 ou superior (ex: **XAMPP**).
- Banco de dados MySQL.

---

### Passo a Passo para Configuração:

1. **Clonar/Mover o Projeto:**
   Baixe ou clone o repositório dentro do diretório raiz do seu servidor web local:
   - XAMPP: `C:/xampp/htdocs/pokelar`

2. **Importar o Banco de Dados:**
   - Acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
   - Clique em **Importar**.
   - Escolha o arquivo `schema.sql` localizado na raiz da pasta do projeto e clique em **Executar**.
   - O script criará o banco `pokelar_db`, as tabelas (`usuarios`, `pokemons`, `adocoes`) e os dados de teste iniciais.

3. **Verificar a Conexão:**
   - O arquivo `config/database.php` já vem pré-configurado com as credenciais padrão do XAMPP (`host=localhost`, `user=root`, `pass=vacaberta/sem senha`). Se o seu MySQL tiver senha definida, ajuste a variável `$pass` no arquivo.

4. **Acessar o Sistema:**
   - Abra o navegador e acesse: `http://localhost/pokelar/index.php`.

---

## Credenciais para Testes de Avaliação

Para testar as diferentes permissões do sistema, utilize as contas pré-cadastradas:

| Perfil | E-mail | Senha | Permissões |
| **Administrador** | `admin@pokelar.com` | `admin123` | Acesso total ao painel `/admin`, cadastro, edição, gestão de status de visitas e exportação CSV. |
| **Treinador (Cliente)**   | `ash@pokelar.com` | `cliente123` | Acesso ao catálogo, agendamento de visitas presenciais e acompanhamento em `minha-conta.php`. |

---