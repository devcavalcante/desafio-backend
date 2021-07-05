# Objetivo

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar somente ao fluxo de transferência entre dois usuários.
- 

## Tecnologias

- Lumen
- PostgreSQL

## Como rodar esse projeto
No terminal:
$ git clone https://github.com/devcavalcante/desafio-backend.git
$ cd desafio-backend <br>
$ composer install <br>
$ cp .env.example .env <br>
$ php artisan migrate #antes de rodar este comando verifique sua configuracao com banco em .env <br>
$ php artisan db:seed #para gerar os seeders dos tipos de usuários <br>
$ php -S localhost:8000 -t public <br>

## Para subir no docker
Digite no terminal: <br>
$ docker-compose up -d --build <br>
- Obs.: Caso de erro de permissão na pasta storage apenas rode na sua máquina local o comando: chmod -R 777 ./storage 
- Abra o arquivo .env e faça as configurações para conectar ao seu banco.
DB_CONNECTION=pgsql  
DB_HOST=db  
DB_PORT=5432  
DB_DATABASE= desafio-backend  
DB_USERNAME=postgres  
DB_PASSWORD=postgres <br>
Digite no terminal <br>
$ docker-compose exec web sh <br>
$ php artisa migrate:fresh --seed