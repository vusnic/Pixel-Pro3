# Configuração do Supabase para PixelPro3

## 📋 Pré-requisitos

- Conta no Supabase (crie em https://supabase.com)
- Docker instalado (para desenvolvimento local)
- Node.js 16+ e npm

## 🔧 Configuração

### 1. Criar Projeto no Supabase

1. Acesse https://supabase.com e faça login
2. Clique em "New Project"
3. Preencha as informações:
   - Nome do projeto: `pixelpro3`
   - Database Password: (escolha uma senha forte)
   - Region: (escolha a região mais próxima)

### 2. Obter Credenciais

Após criar o projeto, acesse as configurações:

1. Vá em **Settings** > **API**
2. Copie as seguintes informações:
   - `Project URL` (SUPABASE_URL)
   - `anon public` key (SUPABASE_ANON_KEY)

3. Vá em **Settings** > **Database**
4. Copie as credenciais do PostgreSQL:
   - Host
   - Database name
   - Port
   - User
   - Password

### 3. Configurar Variáveis de Ambiente

Atualize o arquivo `.env` com suas credenciais:

```env
# Supabase Frontend
VITE_SUPABASE_URL=https://seu-projeto.supabase.co
VITE_SUPABASE_ANON_KEY=sua-chave-anon

# Supabase Database (PostgreSQL)
SUPABASE_DB_HOST=db.seu-projeto.supabase.co
SUPABASE_DB_PORT=5432
SUPABASE_DB_DATABASE=postgres
SUPABASE_DB_USER=postgres
SUPABASE_DB_PASSWORD=sua-senha-do-banco
```

### 4. Executar Migrações

As migrações do Laravel precisam ser executadas no Supabase:

#### Opção 1: Via Docker (Recomendado)

```bash
# Iniciar containers
docker-compose up -d

# Executar script de inicialização
docker-compose exec app ./init-project.sh
```

#### Opção 2: Localmente (se tiver PHP instalado)

```bash
# Instalar dependências
composer install
npm install

# Gerar chave da aplicação
php artisan key:generate

# Executar migrações
php artisan migrate

# Executar seeders
php artisan db:seed

# Criar link simbólico do storage
php artisan storage:link

# Compilar assets
npm run build
```

### 5. Verificar Conexão

Execute o seguinte comando para verificar se a conexão está funcionando:

```bash
php artisan db:show
```

## 📊 Tabelas Criadas

O sistema criará automaticamente as seguintes tabelas no Supabase:

- `users` - Usuários do sistema
- `leads` - Leads de clientes
- `portfolios` - Projetos do portfólio
- `services` - Serviços oferecidos
- `posts` - Posts do blog
- `categories` - Categorias do blog
- `tags` - Tags do blog
- `contracts` - Contratos gerados
- `contract_templates` - Templates de contratos
- `device_tokens` - Tokens de dispositivos para notificações
- `personal_access_tokens` - Tokens de acesso da API

## 🚀 Executar o Projeto

### Desenvolvimento

```bash
# Terminal 1: Start Docker containers
docker-compose up

# Terminal 2: Watch assets
npm run dev
```

Acesse: http://localhost:8000

### Produção

```bash
# Compile assets
npm run build

# Start production containers
docker-compose -f docker-compose.prod.yml up -d
```

## 🔐 Segurança

- Nunca commite o arquivo `.env` com credenciais reais
- Use senhas fortes para o banco de dados
- Mantenha as chaves do Supabase seguras
- Configure Row Level Security (RLS) no Supabase para proteger seus dados

## 🐛 Troubleshooting

### Erro de Conexão com o Banco

- Verifique se as credenciais do `.env` estão corretas
- Certifique-se de que o IP do servidor está na whitelist do Supabase
- Em Settings > Database > Connection Pooling, habilite o connection pooling

### Migrations Falhando

- Verifique se o usuário tem permissões adequadas
- Execute `php artisan migrate:fresh` para recriar todas as tabelas
- Verifique os logs em `storage/logs/laravel.log`

## 📚 Recursos

- [Documentação do Supabase](https://supabase.com/docs)
- [Laravel Database](https://laravel.com/docs/database)
- [Docker Documentation](https://docs.docker.com/)
