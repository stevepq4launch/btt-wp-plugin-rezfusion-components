#!/bin/bash

set -e

echo "Building environment."
docker build . -t rzfwp:latest
docker-compose up --build -d
sleep 15
echo "Installing WordPress Core...."
docker-compose exec wordpress bash -c "wp core install --allow-root --url=localhost:8080 --title=Rezfusion --admin_user=admin --admin_password=admin --admin_email=info@example.com"
echo "Enable and configure rezfusion hub...."
docker-compose exec wordpress bash -c "wp plugin activate --allow-root rezfusion-components"
docker-compose exec wordpress bash -c \
  "wp option update --allow-root rezfusion_hub_sync_items 1 && wp option update --allow-root rezfusion_hub_env $BLUEPRINT_ENVIRONMENT && wp option update  --allow-root rezfusion_hub_channel $BLUEPRINT_CHANNEL"
docker-compose exec wordpress bash -c "cd /var/www/html/wp-content/plugins/rezfusion-components && composer install"
echo "Your dev site is ready to use and running at http://localhost:8080."

