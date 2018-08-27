#!/usr/bin/env bash

cd "$(dirname "$0")/../"

export PATH="$HOME/.composer/vendor/bin:$PATH"

bin/setup-local-env.sh

npm run build || exit 1

echo Running with the following versions:

docker-compose run --rm wordpress_phpunit php -v
docker-compose run --rm wordpress_phpunit phpunit --version

# Run PHPUnit tests
npm run test-php || exit 1
npm run test-unit-php-multisite || exit 1