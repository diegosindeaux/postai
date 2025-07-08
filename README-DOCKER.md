# Sistema de Gestão - Instruções de Execução

Este projeto é um sistema Laravel com Docker configurado para facilitar o desenvolvimento.

## Pré-requisitos

- Docker
- Docker Compose

## Como Rodar o Projeto

### 1. Clone o repositório (se ainda não fez)
```bash
git clone <url-do-repositorio>
cd gestao-php
```

### 2. Suba os containers
```bash
docker-compose up --build
```

### 3. Acesse a aplicação
- **URL**: http://localhost
- **Banco de dados**: localhost:3306

## Serviços Configurados

### App (Laravel)
- **Container**: gestao-php-app
- **Porta**: 9000 (interno)
- **Framework**: Laravel 8.x
- **PHP**: 7.4-fpm

### MySQL
- **Container**: gestao-php-mysql
- **Porta**: 3306
- **Versão**: MySQL 8.0
- **Database**: gestao_db
- **Usuário**: gestao_user
- **Senha**: gestao_password

### Nginx
- **Container**: gestao-php-nginx
- **Porta**: 80
- **Proxy**: Para o container Laravel

## Configurações Automáticas

O sistema irá automaticamente:
1. Aguardar o MySQL iniciar
2. Copiar `.env.example` para `.env` (se necessário)
3. Gerar a chave da aplicação Laravel
4. Limpar e recriar cache de configuração
5. Executar as migrations do banco de dados

## Comandos Úteis

### Acessar o container Laravel
```bash
docker exec -it gestao-php-app bash
```

### Executar comandos Artisan
```bash
docker exec -it gestao-php-app php artisan <comando>
```

### Ver logs
```bash
docker-compose logs app
docker-compose logs mysql
docker-compose logs nginx
```

### Parar os containers
```bash
docker-compose down
```

### Parar e remover volumes (cuidado: apaga dados do banco)
```bash
docker-compose down -v
```

## Desenvolvimento

### Compilar assets (se necessário)
```bash
# Instalar dependências Node.js
docker exec -it gestao-php-app npm install

# Compilar para desenvolvimento
docker exec -it gestao-php-app npm run dev

# Compilar para produção
docker exec -it gestao-php-app npm run prod
```

### Instalar dependências PHP
```bash
docker exec -it gestao-php-app composer install
```

## Troubleshooting

### Se o banco não conectar
1. Verifique se o container MySQL está rodando: `docker ps`
2. Verifique os logs: `docker-compose logs mysql`
3. Aguarde alguns segundos para o MySQL inicializar completamente

### Se a aplicação não carregar
1. Verifique se todos os containers estão rodando: `docker ps`
2. Verifique os logs do Nginx: `docker-compose logs nginx`
3. Verifique os logs da aplicação: `docker-compose logs app`

### Se as migrations falharem
1. Acesse o container: `docker exec -it gestao-php-app bash`
2. Execute manualmente: `php artisan migrate`
3. Verifique as mensagens de erro 