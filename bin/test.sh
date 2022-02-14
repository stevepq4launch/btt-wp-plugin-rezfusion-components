#!/bin/bash

set -e
docker-compose exec -T wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && composer validate"
docker-compose exec -T wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && bin/paratests.sh"
