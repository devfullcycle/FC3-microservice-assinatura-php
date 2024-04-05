# Laravel 11 + Docker (Microservice Subscription FC3)

### Passo a passo
Clone Repositório
```sh
git clone -b starter-kits-laravel-11 https://github.com/devfullcycle/FC3-microservice-assinatura-php microservice-subscription-laravel
```
```sh
cd microservice-subscription-laravel
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Rode as migrations
```sh
php artisan migrate
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```


Acesse o projeto
[http://localhost:8890](http://localhost:8890)
