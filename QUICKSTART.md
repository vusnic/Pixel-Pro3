# 🚀 Guia Rápido - PixelPro3

## Status do Projeto ✅

O projeto foi configurado e está pronto para uso! Todas as dependências foram instaladas e o build foi concluído com sucesso.

## O que foi corrigido:

1. ✅ **Dependências instaladas**
   - Laravel Vite Plugin
   - Tailwind CSS
   - Axios
   - Todas as dependências Node.js

2. ✅ **Configuração do ambiente**
   - Arquivo `.env` configurado para usar Supabase (PostgreSQL)
   - Docker Compose atualizado (removido MySQL local)
   - Variáveis de ambiente para frontend e backend

3. ✅ **Build do projeto**
   - Assets compilados com sucesso
   - TypeScript verificado
   - Vite build completo

## 🎯 Próximos Passos

### 1. Configure o Supabase

Você precisa criar um projeto no Supabase e adicionar as credenciais:

```bash
# Crie uma conta em https://supabase.com
# Crie um novo projeto
# Copie as credenciais para o arquivo .env
```

Edite o arquivo `.env` e substitua pelos seus valores:

```env
SUPABASE_DB_HOST=db.seu-projeto.supabase.co
SUPABASE_DB_DATABASE=postgres
SUPABASE_DB_USER=postgres
SUPABASE_DB_PASSWORD=sua-senha
SUPABASE_URL=https://seu-projeto.supabase.co
SUPABASE_ANON_KEY=sua-chave-anon
```

Veja instruções detalhadas em `SUPABASE_SETUP.md`

### 2. Execute as Migrations

Com o Supabase configurado, execute:

```bash
# Se usar Docker
docker-compose up -d
docker-compose exec app ./init-project.sh

# Ou localmente (se tiver PHP instalado)
php artisan migrate
php artisan db:seed
```

### 3. Inicie o Servidor

```bash
# Desenvolvimento com Docker
docker-compose up

# Ou localmente
php artisan serve
```

Em outro terminal, execute:
```bash
npm run dev
```

Acesse: http://localhost:8000

## 📋 Estrutura do Projeto

- **Backend**: Laravel 12 + PHP 8.4
- **Frontend**: Vite + JavaScript + Bootstrap 5
- **Database**: PostgreSQL (Supabase)
- **Cache/Session**: Redis (via Docker)

## 🔧 Comandos Úteis

```bash
# Verificar conexão com o banco
php artisan db:show

# Limpar cache
php artisan cache:clear

# Executar seeders
php artisan db:seed

# Compilar assets
npm run build

# Desenvolvimento (watch mode)
npm run dev
```

## 📱 Features Disponíveis

- ✅ Sistema de autenticação (API + Web)
- ✅ Gerenciamento de leads
- ✅ Portfólio de projetos
- ✅ Blog com categorias e tags
- ✅ Serviços
- ✅ Sistema de contratos
- ✅ Notificações push
- ✅ Google Analytics integrado
- ✅ Tema claro/escuro
- ✅ Responsivo

## 🆘 Problemas Comuns

### O site não carrega
- Verifique se o Docker está rodando: `docker ps`
- Verifique os logs: `docker-compose logs -f`

### Erro de banco de dados
- Verifique as credenciais no `.env`
- Confirme que o Supabase está acessível
- Execute as migrations: `php artisan migrate`

### Assets não compilam
- Limpe o cache: `npm run build`
- Reinstale dependências: `rm -rf node_modules && npm install`

## 📚 Documentação

- `README.md` - Documentação completa do projeto
- `SUPABASE_SETUP.md` - Configuração detalhada do Supabase
- `MANUAL_SETUP.md` - Setup manual sem Docker

## 🎉 Pronto para começar!

O projeto está configurado e pronto para uso. Configure o Supabase e execute as migrations para começar a desenvolver!
