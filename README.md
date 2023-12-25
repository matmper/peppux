# Peppux - API Framework

**Attention:** A web framework developed in PHP. This repository is used for PHP language studies.

<p align="center">
    <a href="https://github.com/matmper/peppux/pulls">
        <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs Welcome">
    </a>
    <a href="https://github.com/matmper/peppux/actions/workflows/github_actions.yml?query=branch%3Amain+event%3Apush">
        <img src="https://github.com/matmper/peppux/actions/workflows/github_actions.yml/badge.svg?event=push" alt="Actions">
    </a>
    <a href="https://github.com/matmper/peppux/blob/main/LICENSE">
        <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License MIT">
    </a>
</p>

## Requeriments
- Docker
- Docker Compose
- Make

## Install
- Clone repository: [Github](https://github.com/matmper/peppux)
- Start docker and run these commands: 
```base
$ cp .env.example .env
$ make build
$ make up
```
- Use `$ make up` to start or `$ make down` to stop

---

## Utilities and tools

### Database Migrate
- Create a new migrate file into `./database/Migrations`
- Naming file like `20240101_123000_create_users_table.php`
- Run `$ make migrate` to run all remaining migration files
- Run `$ migrate-rollback` to rollback one step

### Tests - PHP Unit
- Library: [PHP Unit 10](https://phpunit.de/getting-started/phpunit-10.html)
- Run `$ make composer-tests` to execute all tests

### Code Sniffer & Code Beautifier
Use these commands to keep your code clean and up to standards:
- PHP Code Check: `$ make composer-check`
- PHP Code Beautifier and Fixer: `$ make composer-phpcbf`

---

This repository use [MIT License](https://choosealicense.com/licenses/mit/)
