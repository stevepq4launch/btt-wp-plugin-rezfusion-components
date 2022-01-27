#!/bin/bash

set -e
echo '' > test-api-cache.json
docker-compose exec -T wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && composer validate"
docker-compose exec -T wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && vendor/bin/phpunit --log-junit build/junit.xml --coverage-html build/coverage-report ./tests"
