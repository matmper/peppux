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
        <img src="https://img.shields.io/badge/license-Apache%202.0-blue.svg" alt="License Apache">
    </a>
</p>

## Documentation

Access: [Peppux - Complete Documentation](https://matmper.github.io/peppux)

## Requeriments
- [Docker](https://www.docker.com/)
- [GNU make](https://www.gnu.org/software/make/)

## Installation for development

Clone repository, copy env and configure it:
```bash
$ cp ./src/.env.example ./src/.env
```

Start docker and run these commands:
```bash
$ make build-first
```

Use `$ make up` to start or `$ make down` to stop

---

This repository use [Apache 2.0 License](https://www.apache.org/licenses/LICENSE-2.0)
