## Setup

These commands should probably do the trick assuming you have docker running and automake available in your system

```shell
cp .env.example .env
docker compose up -d --build
make composer-install
make migrate
```

Feel free to examine `Makefile` and `openapi.yaml` to get the idea of available endpoints.
