# Objetivo

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar somente ao fluxo de transferência entre dois usuários.
- 

## Tecnologias

- Lumen 
- PostgreSQL

## Autenticação
- Autenticação com Passport 

## Transação
- Lojistas só recebem transferência 
- Usuários podem fazer transferências de uma conta para outra 

## Como rodar esse projeto local
No terminal:
$ git clone https://github.com/devcavalcante/desafio-backend.git
$ cd desafio-backend <br>
$ composer install <br>
$ cp .env.example .env <br>
$ php artisan migrate #antes de rodar este comando verifique sua configuracao com banco em .env <br>
$ php artisan db:seed #para gerar os seeders dos tipos de usuários <br>
$ php artisan passport:install
$ php -S localhost:8000 -t public <br>

## Para subir no docker
Digite no terminal: <br>
$ docker-compose up -d --build <br>
- Obs.: Caso de erro de permissão na pasta storage apenas rode na sua máquina local o comando: chmod -R 777 ./storage 
- Abra o arquivo .env e faça as configurações para conectar ao seu banco. <br>
DB_CONNECTION=pgsql  
DB_HOST=db  
DB_PORT=5432  
DB_DATABASE= desafio-backend  
DB_USERNAME=postgres  
DB_PASSWORD=postgres <br>
<br>
Digite no terminal <br>
$ docker-compose exec web sh <br>
$ php artisan migrate:fresh --seed

## Rotas
/ (GET): Cria um usuário (podendo ser do tipo lojista ou normal, verificar a role_id) <br>
/login (POST): Usuário é autenticado no sistema <br>
/user (GET): Pega o usuário que está logado no sistema <br>
/type_user: (GET): Exibe o tipo do usuário logado no sistema <br>
/transaction (POST): Realiza a transação entre usuários