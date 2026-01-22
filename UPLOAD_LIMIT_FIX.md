# 🚀 Correção - Erro 413 Request Entity Too Large

## ❌ Problema Identificado
O erro `413 Request Entity Too Large` ocorria porque a configuração do nginx de produção não possuía os limites de upload configurados, diferentemente da configuração de desenvolvimento.

## ✅ Correções Aplicadas

### 1. **Nginx Produção** (`docker/nginx/prod/laravel.conf`)
```nginx
# Configurações de upload - correção para erro 413
client_max_body_size 100M;
client_body_buffer_size 1024k;
client_body_timeout 60s;
client_header_timeout 60s;

# Configurações específicas para upload no FastCGI
fastcgi_request_buffering off;
fastcgi_max_temp_file_size 0;
```

### 2. **PHP** (`docker/php/custom.ini`)
```ini
memory_limit = 512M          # Aumentado de 256M
max_execution_time = 300     # Aumentado de 120s
upload_max_filesize = 100M   # Aumentado de 50M
post_max_size = 100M         # Aumentado de 50M
max_file_uploads = 20        # Adicionado
```

## 🔧 Como Aplicar em Produção

### Via Docker (Recomendado)
```bash
# 1. Fazer backup das configurações atuais
cp docker/nginx/prod/laravel.conf docker/nginx/prod/laravel.conf.backup
cp docker/php/custom.ini docker/php/custom.ini.backup

# 2. Aplicar as mudanças (já feitas nos arquivos)
# 3. Recriar os containers
docker-compose down
docker-compose up -d --build

# 4. Verificar se os containers subiram corretamente
docker-compose ps
docker-compose logs nginx
docker-compose logs app
```

### Verificação Manual
```bash
# Testar configuração do nginx
docker-compose exec nginx nginx -t

# Verificar configurações PHP
docker-compose exec app php -i | grep -E "(upload_max_filesize|post_max_size|memory_limit)"
```

## 📊 Limites Configurados

| Componente | Limite Anterior | Limite Atual | Descrição |
|------------|----------------|--------------|-----------|
| Nginx | 1MB (padrão) | 100MB | Tamanho máximo da requisição |
| PHP Upload | 50MB | 100MB | Tamanho máximo do arquivo |
| PHP Post | 50MB | 100MB | Tamanho máximo do POST |
| PHP Memory | 256MB | 512MB | Memória disponível para PHP |
| PHP Execution | 120s | 300s | Tempo máximo de execução |

## 🧪 Testes Recomendados

1. **Upload de arquivo pequeno** (< 1MB)
2. **Upload de arquivo médio** (10-20MB)
3. **Upload de arquivo grande** (50-80MB)
4. **Upload múltiplo** de arquivos

## ⚠️ Observações Importantes

- As mudanças requerem restart dos containers
- Em produção, monitore o uso de memória após a aplicação
- Os timeouts foram aumentados para acomodar uploads maiores
- Considere implementar upload progressivo para arquivos muito grandes

## 🔍 Troubleshooting

Se ainda ocorrer erro 413:
1. Verificar se os containers foram reiniciados
2. Verificar logs: `docker-compose logs nginx`
3. Confirmar configuração: `docker-compose exec nginx nginx -t`
4. Verificar espaço em disco disponível

## 📝 Histórico
- **Data**: 2024-01-XX
- **Problema**: 413 Request Entity Too Large em produção
- **Causa**: Configurações de upload ausentes no nginx de produção
- **Solução**: Alinhamento das configurações nginx e PHP para 100MB