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

## Documentation

Access: [Peppux - Complete Documentation](https://matmper.github.io/peppux)

## Requeriments
- Docker
- Docker Compose
- GNU make
- PHP ^8.3 (Optional, you can use it within Docker)

## Installation for development

Clone repository, copy env and configure it:
```bash
$ cp .env.example .env
```

Start docker and run these commands:
```bash
$ make build
$ make up
```

Use `$ make up` to start or `$ make down` to stop

---

This repository use [MIT License](https://choosealicense.com/licenses/mit/)
