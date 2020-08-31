#!/bin/bash

set -e
docker-compose exec wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && vendor/bin/phpunit --log-junit build/junit.xml --coverage-html build/coverage-report ./tests"
