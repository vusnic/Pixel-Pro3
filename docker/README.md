# Docker for Development and Production

This directory contains Docker configuration to run the Pxp3 project in different environments.

## Structure

```
docker/
├── nginx/
│   ├── dev/            # Nginx configurations for development
│   │   └── laravel.conf
│   ├── prod/           # Nginx configurations for production
│   │   └── laravel.conf
│   └── ssl/            # SSL certificates for production
│
├── php/
│   └── prod/           # PHP configurations for production
│       └── php.ini
│
└── README.md
```

## How to Use

### For Development Environment

Use the `start-dev.sh` script in the project root:

```bash
./start-dev.sh
```

This script:
1. Creates a symbolic link to the Nginx development configuration
2. Starts the containers using `docker-compose.dev.yml`

### For Production Environment

Use the `start-prod.sh` script in the project root:

```bash
./start-prod.sh
```

This script:
1. Creates a symbolic link to the Nginx production configuration
2. Starts the containers in detached mode using `docker-compose.prod.yml`

## Configuration Files

### docker-compose.dev.yml
- Specific for local development
- Mounts local directories for rapid development
- Includes PHPMyAdmin and other development tools

### docker-compose.prod.yml
- Optimized for production
- Configured for high performance and security
- Includes SSL configurations

### Dockerfile.prod
- Docker image optimized for production
- Includes caching and performance optimizations
- Enhanced security configuration

## SSL in Production

To configure SSL in production:

1. Place your certificates in `docker/nginx/ssl/`:
   - `pxp3.com.crt`
   - `pxp3.com.key`

2. If using Let's Encrypt, the process can be automated with Certbot.

## Notes

- Always use `docker compose down` before switching between environments
- Run `docker compose build` after changes to the Dockerfile
- The production environment requires environment variables defined in `.env` 