# 🛠️ Configuração Manual do Ambiente

Como a instalação automática falhou (provavelmente devido a restrições de permissão ou rede), você precisará instalar o **PHP** e o **Composer** manualmente.

## 1. Instalar PHP
1. Baixe o **PHP 8.2+ (VS16 x64 Thread Safe)**:
   - [Clique aqui para baixar (Zip)](https://windows.php.net/downloads/releases/php-8.2.27-Win32-vs16-x64.zip) (ou acesse [windows.php.net/download](https://windows.php.net/download/))
2. Extraia o arquivo zip para uma pasta como `C:\php`.
3. **Adicione ao PATH**:
   - Pesquise por "Editar as variáveis de ambiente do sistema" no Windows.
   - Clique em "Variáveis de Ambiente".
   - Em "Variáveis do sistema", encontre `Path` e clique em "Editar".
   - Clique em "Novo" e adicione o caminho da pasta: `C:\php`.
   - Clique em OK em tudo.
4. **Configurar php.ini**:
   - Na pasta `C:\php`, renomeie `php.ini-development` para `php.ini`.
   - **IMPORTANTE**: Abra o `php.ini` no Bloco de Notas.
   - Pressione `Ctrl+F` e procure por `extension_dir`.
   - Encontre a linha que diz `; extension_dir = "ext"` (ou similar).
   - **Mude para**: `extension_dir = "C:\php\ext"` (remova o `;` se tiver).
   
   - Agora, procure por `extension=` e ative as extensões:
     ```ini
     extension=curl
     extension=fileinfo
     extension=gd
     extension=mbstring
     extension=openssl
     extension=pdo_mysql
     extension=pdo_sqlite
     extension=zip
     ```
   - **Salve o arquivo** (Ctrl+S).

## 2. Instalar Composer
1. Baixe o instalador: [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe).
2. Execute o instalador.
   - Ele deve detectar o seu PHP em `C:\php\php.exe` automaticamente.
   - Siga as instruções até o fim.

## 3. Verificar Instalação
Abra um **novo** terminal (PowerShell ou CMD) e digite:
```powershell
php -v
composer -v
```
Se ambos mostrarem a versão, você está pronto!

## 4. Rodar o Servidor
Após instalar, basta rodar o script automático que preparei:
```powershell
./setup_and_run.ps1
```
