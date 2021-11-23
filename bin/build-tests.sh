#!/bin/bash

set -e
docker-compose exec -T wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && php build-backend-tests.php"
