# 🌐 Pxp3 - Website

<details>
<summary>🇺🇸 English</summary>

---

This is the repository of **Pxp3's** commercial website, developed using **Laravel 12, Vite, JavaScript, and Bootstrap 5.2.1**.

## 🚀 Technologies Used

- **PHP 8.4.5** → Backend programming language
- **Laravel 12** → PHP web development framework  
- **Vite** → Bundler and development server  
- **Bootstrap 5.2.1** → Components and responsiveness  
- **JavaScript (ES6+)** → Interactivity  
- **Blade** → Laravel's templating engine  

## 📂 Project Structure

```bash
📦 pixelpro3-website
 ┣ 📂 app                  # PHP source code of the Laravel application
 ┣ 📂 resources            # Application resources
 ┃ ┣ 📂 css                # Style files 
 ┃ ┣ 📂 js                 # JavaScript scripts
 ┃ ┣ 📂 views              # Blade templates
 ┃ ┃ ┣ 📂 components       # Reusable components  
 ┃ ┃ ┣ 📂 layouts          # Main layouts
 ┃ ┃ ┗ 📂 pages            # Website pages
 ┣ 📂 public               # Public files (compiled)
 ┃ ┣ 📂 img                # Images and icons
 ┃ ┣ 📂 js                 # Compiled JavaScript
 ┃ ┗ 📂 css                # Compiled CSS
 ┣ 📂 routes               # Route definitions
 ┗ 📜 README.md            # This file
```

## ⚙️ Requirements

- PHP 8.4.5 or higher
- Composer
- Node.js 16+ and npm
- Web server (Apache/Nginx)

## ⚙️ Installation and Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/pixelpro3.git
   cd pixelpro3
   ```

2. Install PHP dependencies via Composer:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

## 🚀 Running the Project

1. For development environment:
   ```bash
   # Terminal 1: Start the Laravel server
   php artisan serve

   # Terminal 2: Compile and watch assets
   npm run dev
   ```

2. For production:
   ```bash
   # Compile assets for production
   npm run build
   
   # Configure your web server (Apache/Nginx) to point to the public/ folder
   ```

## 🌙 Dark/Light Theme

The site supports switching between dark and light themes, implemented with Bootstrap and custom JavaScript.

## 📱 Responsiveness

The layout is fully responsive, adapting to different screen sizes (mobile, tablet, and desktop).

## 🔄 Animations

We use smooth animations via AOS (Animate On Scroll) to enhance the user experience.

## 📊 Google Analytics

The admin dashboard presents user traffic and behavior metrics integrated with Google Analytics. To properly configure:

1. Create an account on [Google Analytics](https://analytics.google.com/)
2. Obtain Google Analytics API credentials:
   - Access the [Google Developer Console](https://console.developers.google.com/)
   - Create a project and enable the Analytics API
   - Create service account credentials and download the JSON file
   
3. Configure the `.env` file:
   ```bash
   ANALYTICS_VIEW_ID=ga:XXXXXXXX
   ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS_JSON=storage/app/analytics/service-account-credentials.json
   ```

4. Create the directory and save the JSON file:
   ```bash
   mkdir -p storage/app/analytics
   # Copy the credential JSON file to storage/app/analytics/service-account-credentials.json
   ```

5. Add the service account email as a user with viewing permission in your Google Analytics property

If credentials are not configured or there is a connection failure, the system will automatically use simulated data, indicating this with an alert in the dashboard.

</details>

<details>
<summary>🇧🇷 Português (Brasil)</summary>

---

Este é o repositório do website comercial da **Pxp3**, desenvolvido utilizando **Laravel 12, Vite, JavaScript e Bootstrap 5.2.1**.

## 🚀 Tecnologias Utilizadas

- **PHP 8.4.5** → Linguagem de programação backend
- **Laravel 12** → Framework PHP para desenvolvimento web  
- **Vite** → Bundler e servidor de desenvolvimento  
- **Bootstrap 5.2.1** → Componentes e responsividade  
- **JavaScript (ES6+)** → Interatividade  
- **Blade** → Engine de templates do Laravel  

## 📂 Estrutura do Projeto

```bash
📦 pixelpro3-website
 ┣ 📂 app                  # Código-fonte PHP da aplicação Laravel
 ┣ 📂 resources            # Recursos da aplicação
 ┃ ┣ 📂 css                # Arquivos de estilo 
 ┃ ┣ 📂 js                 # Scripts JavaScript
 ┃ ┣ 📂 views              # Templates Blade
 ┃ ┃ ┣ 📂 components       # Componentes reutilizáveis  
 ┃ ┃ ┣ 📂 layouts          # Layouts principais
 ┃ ┃ ┗ 📂 pages            # Páginas do site
 ┣ 📂 public               # Arquivos públicos (compilados)
 ┃ ┣ 📂 img                # Imagens e ícones
 ┃ ┣ 📂 js                 # JavaScript compilado
 ┃ ┗ 📂 css                # CSS compilado
 ┣ 📂 routes               # Definição das rotas
 ┗ 📜 README.md            # Este arquivo
```

## ⚙️ Requisitos

- PHP 8.4.5 ou superior
- Composer
- Node.js 16+ e npm
- Servidor web (Apache/Nginx)

## ⚙️ Instalação e Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/pixelpro3.git
   cd pixelpro3
   ```

2. Instale as dependências do PHP via Composer:
   ```bash
   composer install
   ```

3. Instale as dependências do JavaScript:
   ```bash
   npm install
   ```

4. Copie o arquivo de ambiente:
   ```bash
   cp .env.example .env
   ```

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

## 🚀 Executando o Projeto

1. Para ambiente de desenvolvimento:
   ```bash
   # Terminal 1: Inicie o servidor Laravel
   php artisan serve

   # Terminal 2: Compile e observe os assets
   npm run dev
   ```

2. Para produção:
   ```bash
   # Compile os assets para produção
   npm run build
   
   # Configure seu servidor web (Apache/Nginx) para apontar para a pasta public/
   ```

## 🌙 Tema Escuro / Claro

O site suporta alternância entre tema escuro e claro, implementado com Bootstrap e JavaScript personalizado.

## 📱 Responsividade

O layout é totalmente responsivo, adaptando-se a diferentes tamanhos de tela (mobile, tablet e desktop).

## 🔄 Animações

Utilizamos animações suaves via AOS (Animate On Scroll) para melhorar a experiência do usuário.

## 📊 Google Analytics

O painel de administração apresenta métricas de tráfego e comportamento dos usuários integradas com o Google Analytics. Para configurar corretamente:

1. Crie uma conta no [Google Analytics](https://analytics.google.com/)
2. Obtenha as credenciais da API do Google Analytics:
   - Acesse o [Google Developer Console](https://console.developers.google.com/)
   - Crie um projeto e habilite a API do Analytics
   - Crie credenciais de conta de serviço e baixe o arquivo JSON
   
3. Configure o arquivo `.env`:
   ```bash
   ANALYTICS_VIEW_ID=ga:XXXXXXXX
   ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS_JSON=storage/app/analytics/service-account-credentials.json
   ```

4. Crie o diretório e salve o arquivo JSON:
   ```bash
   mkdir -p storage/app/analytics
   # Copie o arquivo JSON de credenciais para storage/app/analytics/service-account-credentials.json
   ```

5. Adicione o email da conta de serviço como usuário com permissão de visualização na sua propriedade do Google Analytics

Se as credenciais não estiverem configuradas ou houver falha na conexão, o sistema usará dados simulados automaticamente, indicando com um alerta no painel.

</details>

<details>
<summary>🇪🇸 Español</summary>

---

Este es el repositorio del sitio web comercial de **Pxp3**, desarrollado utilizando **Laravel 12, Vite, JavaScript y Bootstrap 5.2.1**.

## 🚀 Tecnologías Utilizadas

- **PHP 8.4.5** → Lenguaje de programación backend
- **Laravel 12** → Framework PHP para desarrollo web  
- **Vite** → Bundler y servidor de desarrollo  
- **Bootstrap 5.2.1** → Componentes y capacidad de respuesta  
- **JavaScript (ES6+)** → Interactividad  
- **Blade** → Motor de plantillas de Laravel  

## 📂 Estructura del Proyecto

```bash
📦 pixelpro3-website
 ┣ 📂 app                  # Código fuente PHP de la aplicación Laravel
 ┣ 📂 resources            # Recursos de la aplicación
 ┃ ┣ 📂 css                # Archivos de estilo 
 ┃ ┣ 📂 js                 # Scripts JavaScript
 ┃ ┣ 📂 views              # Plantillas Blade
 ┃ ┃ ┣ 📂 components       # Componentes reutilizables  
 ┃ ┃ ┣ 📂 layouts          # Layouts principales
 ┃ ┃ ┗ 📂 pages            # Páginas del sitio
 ┣ 📂 public               # Archivos públicos (compilados)
 ┃ ┣ 📂 img                # Imágenes e iconos
 ┃ ┣ 📂 js                 # JavaScript compilado
 ┃ ┗ 📂 css                # CSS compilado
 ┣ 📂 routes               # Definiciones de rutas
 ┗ 📜 README.md            # Este archivo
```

## ⚙️ Requisitos

- PHP 8.4.5 o superior
- Composer
- Node.js 16+ y npm
- Servidor web (Apache/Nginx)

## ⚙️ Instalación y Configuración

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/pixelpro3.git
   cd pixelpro3
   ```

2. Instalar dependencias PHP a través de Composer:
   ```bash
   composer install
   ```

3. Instalar dependencias JavaScript:
   ```bash
   npm install
   ```

4. Copiar el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

5. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

## 🚀 Ejecutando el Proyecto

1. Para entorno de desarrollo:
   ```bash
   # Terminal 1: Iniciar el servidor Laravel
   php artisan serve

   # Terminal 2: Compilar y observar los activos
   npm run dev
   ```

2. Para producción:
   ```bash
   # Compilar activos para producción
   npm run build
   
   # Configurar su servidor web (Apache/Nginx) para apuntar a la carpeta public/
   ```

## 🌙 Tema Oscuro / Claro

El sitio admite cambiar entre temas oscuro y claro, implementado con Bootstrap y JavaScript personalizado.

## 📱 Capacidad de Respuesta

El diseño es totalmente responsivo, adaptándose a diferentes tamaños de pantalla (móvil, tablet y escritorio).

## 🔄 Animaciones

Utilizamos animaciones suaves a través de AOS (Animate On Scroll) para mejorar la experiencia del usuario.

## 📊 Google Analytics

El panel de administración presenta métricas de tráfico y comportamiento del usuario integradas con Google Analytics. Para configurar correctamente:

1. Cree una cuenta en [Google Analytics](https://analytics.google.com/)
2. Obtenga las credenciales de la API de Google Analytics:
   - Acceda a la [Google Developer Console](https://console.developers.google.com/)
   - Cree un proyecto y habilite la API de Analytics
   - Cree credenciales de cuenta de servicio y descargue el archivo JSON
   
3. Configure el archivo `.env`:
   ```bash
   ANALYTICS_VIEW_ID=ga:XXXXXXXX
   ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS_JSON=storage/app/analytics/service-account-credentials.json
   ```

4. Cree el directorio y guarde el archivo JSON:
   ```bash
   mkdir -p storage/app/analytics
   # Copie el archivo JSON de credenciales a storage/app/analytics/service-account-credentials.json
   ```

5. Agregue el correo electrónico de la cuenta de servicio como usuario con permisos de visualización en su propiedad de Google Analytics

Si las credenciales no están configuradas o hay un fallo en la conexión, el sistema utilizará datos simulados automáticamente, indicándolo con una alerta en el panel.

</details>

# Sistema de Geração de Contratos - Pxp3

## Requisitos do Sistema
- PHP 8.4 ou superior
- Extensão ZipArchive do PHP
- Permissões de escrita nos diretórios de armazenamento de contratos

## Configuração em Produção

### 1. Configuração do Docker

O projeto está configurado para funcionar automaticamente com Docker. Use o seguinte comando para iniciar:

```bash
docker-compose up -d
```

O Dockerfile e docker-compose.yml já estão configurados para criar todos os diretórios necessários e definir as permissões corretas.

### 2. Verificação de Diretórios e Permissões

Se você enfrentar problemas com permissões, verifique se os seguintes diretórios existem e têm permissões de escrita:

```bash
# Diretórios de storage para contratos
/var/www/storage/app/contracts/templates
/var/www/storage/app/contracts/generated

# Diretório temporário para debugging
/var/www/tmp/docx_debug
```

Execute o seguinte comando para garantir as permissões:

```bash
chmod -R 777 /var/www/storage/app/contracts
chmod -R 777 /var/www/tmp
```

### 3. Verificação de Extensões

Certifique-se de que a extensão ZipArchive está instalada:

```bash
php -m | grep zip
```

### 4. Volumes Persistentes

O sistema usa volumes Docker para armazenar os arquivos de templates e contratos gerados:

- `contracts_templates`: Para modelos de contratos
- `contracts_generated`: Para contratos gerados
- `contracts_temp`: Para arquivos temporários

## Troubleshooting

Se encontrar problemas com a geração de contratos:

1. Verifique os logs em `storage/logs/laravel.log`
2. Garanta que o formato dos placeholders no documento coincide com os suportados (normal, com chaves, com cifrão)
3. Verifique se os diretórios têm permissões adequadas
4. Certifique-se de que a extensão ZipArchive está habilitada

## Formatos de Placeholders Suportados

O sistema suporta os seguintes formatos de placeholders nos modelos de contratos:

- `ClientName` (formato normal)
- `{ClientName}` (com chaves)
- `$ClientName` (com cifrão)
- `${ClientName}` (com cifrão e chaves)
