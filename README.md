# CadêMeuPix

Sistema para gerenciamento de vendas fiadas e cobranças via Pix e WhatsApp.

## Requisitos

- PHP 8.1+
- Composer
- MySQL 5.7+ ou PostgreSQL
- Extensões PHP: pdo, mbstring, xml, gd, zip

## Instalação

```bash
# Clonar o repositório
git clone <repo-url> cadeMeuPix
cd cadeMeuPix

# Instalar dependências
composer install

# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar banco de dados no arquivo .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=cademeupix
# DB_USERNAME=root
# DB_PASSWORD=

# Executar migrations
php artisan migrate --seed

# Iniciar servidor
php artisan serve
```

## Usando Docker

```bash
# Subir os containers
docker-compose up -d

# Executar migrations dentro do container
docker-compose exec app php artisan migrate --seed

# Acessar em http://localhost:8080
```

## Produção (Grátis)

### Railway (Recomendado)
1. Crie conta em [railway.app](https://railway.app)
2. Conecte seu repositório GitHub
3. Adicione serviço MySQL
4. Configure as variáveis em Settings > Variables:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-app.railway.app
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```
5. O deploy é automático via Git push

### Render
1. Crie conta em [render.com](https://render.com)
2. New + > Web Service > Connect repositório
3. Runtime: Docker
4. Adicione banco MySQL separado
5. Configure Environment Variables similar ao Railway

## Acesso

Acesse `http://localhost:8000` (ou `http://localhost:8080` com Docker) e cadastre-se para começar a usar.

## Funcionalidades

- Cadastro de lojistas e clientes
- Registro de dívidas (vendas fiadas)
- Geração de QR Code Pix (Copia e Cola)
- Envio de cobranças via WhatsApp
- Dashboard com resumo financeiro
- API REST para integrações

## Agendamento

Para verificar dívidas vencidas automaticamente:
```bash
php artisan dividas:check-overdue
```

Configure no crontab:
```
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

## Licença

MIT License
