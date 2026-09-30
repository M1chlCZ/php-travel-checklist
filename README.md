# Travel Checklist API

A new PHP application sample created with AI assistance from Codex in September 2026. This is not past client work.

The API stores trips and checklist items. It uses PHP 8.4, Laravel 13, MySQL 8.4, and Docker.

## Run locally

1. Copy `.env.example` to `.env`.
2. Build the image.

```sh
docker compose build
```

3. Generate an application key. Copy the value into `APP_KEY` in `.env`.

```sh
docker compose run --rm --no-deps app php artisan key:generate --show
```

4. Generate an API token. Copy the value into `DEMO_API_TOKEN` in `.env`.

```sh
docker compose run --rm --no-deps app php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;'
```

5. Start the containers. Create the tables.

```sh
docker compose up -d --wait
docker compose exec app php artisan migrate --force
```

The API listens on `http://localhost:8088`. Docker keeps MySQL inside its private network.

## Use the API

Set `CHECKLIST_TOKEN` to the token from `.env`. Use the returned IDs in later requests.

```sh
CHECKLIST_TOKEN="your local token"

curl -fsS http://localhost:8088/api/trips \
  -H "Authorization: Bearer $CHECKLIST_TOKEN" \
  -H 'Content-Type: application/json' \
  -d '{"destination":"CZ","departure_date":"2030-06-20"}'

curl -fsS http://localhost:8088/api/trips/1/items \
  -H "Authorization: Bearer $CHECKLIST_TOKEN" \
  -H 'Content-Type: application/json' \
  -d '{"title":"Pack charger"}'

curl -fsS -X PATCH http://localhost:8088/api/trips/1/items/1 \
  -H "Authorization: Bearer $CHECKLIST_TOKEN" \
  -H 'Content-Type: application/json' \
  -d '{"completed":true}'
```

| Method | Path | Result |
|---|---|---|
| POST | `/api/trips` | Create a trip |
| GET | `/api/trips` | List trips, 25 per page |
| GET | `/api/trips/{trip}` | Read a trip and its items |
| POST | `/api/trips/{trip}/items` | Add an item |
| PATCH | `/api/trips/{trip}/items/{item}` | Set completion to true or false |

Country codes contain two letters. The API converts letters to uppercase. This check does not establish that a country exists.
Departure dates cannot be in the past. Item titles contain at most 120 characters.
The API rejects an item update through a different trip. Repeated completion requests leave the same result.

## Scope

This demo uses one shared token. The token grants access to every trip. It does not provide user accounts.
The server fails closed when the token is empty. The local server does not provide TLS or production hosting.
Use fictional data. This sample does not handle identity documents, payments, or real visa requirements.

The repository contains no test suite. GitHub CI builds the image and checks code format. GitLab CI installs dependencies and checks code format.
GitLab CI is included for the job stack. It is not a confirmed GitLab run.
