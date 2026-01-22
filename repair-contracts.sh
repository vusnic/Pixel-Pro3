#!/bin/bash

echo "Script de reparo do sistema de contratos"
echo "======================================"
echo ""

# Verificar se o Docker está rodando
if ! docker ps | grep -q pixelpro3-app; then
    echo "Erro: O contêiner Docker do aplicativo não está em execução."
    echo "Inicie os contêineres com o comando: docker-compose up -d"
    exit 1
fi

echo "Etapa 1: Corrigindo permissões dos diretórios de armazenamento..."
docker exec -it pixelpro3-app-1 bash -c "chmod -R 777 /var/www/storage/app/contracts/"
echo "✓ Permissões corrigidas"

echo ""
echo "Etapa 2: Corrigindo arquivos de templates..."
docker exec -it pixelpro3-app-1 bash -c "cd /var/www && php artisan contracts:fix-permissions"
echo "✓ Arquivos de templates verificados"

echo ""
echo "Etapa 3: Executando reparo completo do sistema..."
docker exec -it pixelpro3-app-1 bash -c "cd /var/www && php artisan contracts:repair-system"
echo "✓ Sistema reparado"

echo ""
echo "Reparo concluído! Agora você deve conseguir gerar contratos normalmente."
echo "Se o problema persistir, entre em contato com o suporte técnico."
echo "======================================" 