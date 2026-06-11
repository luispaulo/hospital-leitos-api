# Hospital Leitos API

Teste técnico desenvolvido em Laravel utilizando SQLite para gerenciamento de ocupação de leitos hospitalares.

## Regras implementadas

- Um paciente não pode ocupar mais de um leito.
- Um leito só pode possuir um paciente.
- Transferência de pacientes entre leitos.
- Busca de leito por CPF do paciente.
- Consulta de status de ocupação dos leitos.
- Listagem de leitos.

## Requisitos

- PHP 8.2+
- Composer
- SQLite
- Laravel 12

## Instalação

### 1. Instalar dependências

```bash
composer install
```

### 2. Configurar ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Criar banco SQLite

```bash
touch database/database.sqlite
```

### 4. Configurar conexão no arquivo `.env`

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 5. Executar migrations

```bash
php artisan migrate
```

### 6. Popular banco com dados iniciais (seed)

```bash
php artisan db:seed
```

Ou executar migrations e seeders em um único comando:

```bash
php artisan migrate --seed
```

### 7. Executar testes

```bash
php artisan test
```

### 8. Iniciar a aplicação

```bash
php artisan serve
```

A aplicação ficará disponível em:

```text
http://localhost:8000
```


## Endpoints

### Listar leitos

```http
GET /api/leitos
```

### Status de um leito

```http
GET /api/leitos/{id}/status
```

### Ocupar leito

```http
POST /api/leitos/{id}/ocupar
```

Exemplo de payload:

```json
{
    "nome": "Luis Paulo",
    "cpf": "12345678901"
}
```

### Desocupar leito

```http
POST /api/leitos/{id}/desocupar
```

### Transferir paciente

```http
POST /api/transferencias
```

Exemplo de payload:

```json
{
    "cpf": "12345678901",
    "leito_destino_id": 2
}
```

### Buscar leito por CPF

```http
GET /api/pacientes/{cpf}/leito
```

## Executando os testes

```bash
php artisan test
```

## Estrutura da solução

- Controllers responsáveis pelos endpoints da API.
- Services contendo as regras de negócio.
- Requests para validação de entrada.
- Models para persistência dos dados.
- Migrations para estrutura do banco.
- Seeders para carga inicial de dados.
- Testes automatizados cobrindo os principais cenários.

## Regras de negócio validadas

- Não permite internar paciente em leito ocupado.
- Não permite internar paciente já internado.
- Não permite transferir paciente para leito ocupado.
- Não permite transferir paciente para o mesmo leito.
- Permite localizar rapidamente o leito ocupado através do CPF.
- Mantém consistência entre pacientes e leitos durante transferências.

## Autor

Teste técnico desenvolvido utilizando Laravel e SQLite.
