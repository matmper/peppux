# Commands

Check the list of main commands for development environment.

Make sure you have the `GNU make` dependency installed.
- GNU make: [Documentation](https://www.gnu.org/software/make/manual/make.html)

### Docker
```bash
# Build docker images
$ make build

# Play docker images
$ make up

# Stop docker images
$ make down

# Kill docker images
$ make kill

# Access PHP docker image with tty
$ make tty
```

### Composer
```bash
# Install
$ make composer-install

# Update
$ make composer update
```

### Code Check and Lint
```bash
# Run php checks and tests
$ make composer-check

# Run php unit test
$ make composer-tests

# Run php stan check
$ make composer-phpstan

# Run php code sniffer check
$ make composer-phpcs

# Run php code beautiful and fixer
$ make composer-phpcbf
```
