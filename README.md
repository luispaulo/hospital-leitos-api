
# Hospital Leitos API

Teste técnico em Laravel + SQLite.

## Regras implementadas
- Um paciente não pode ocupar mais de um leito.
- Um leito só pode possuir um paciente.
- Transferência entre leitos.
- Busca de leito por CPF.
- Status de ocupação.
- Listagem de leitos.

## Instalação

composer install
cp .env.example .env
php artisan key:generate

Criar SQLite:

touch database/database.sqlite

Configurar:

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

php artisan migrate --seed
php artisan test
php artisan serve
