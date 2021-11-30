#!/bin/bash
export WP_BASE_IMAGE=rzfwp:latest
export BLUEPRINT_ENVIRONMENT=prd
export BLUEPRINT_CHANNEL="-"
export BLUEPRINT_URL=https://assets.rezfusion.com/bluetent/channels/httpswwwrezfusionhubdemocom/bundle.js
./bin/build.sh
