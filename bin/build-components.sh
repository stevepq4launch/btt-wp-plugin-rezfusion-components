#!/bin/bash
set -e
if [ -e ${GITHUB_TOKEN} ]; then
    echo "Invalid/empty GitHub token."
    exit 1
fi
docker run \
    --rm \
    --env GITHUB_TOKEN=${GITHUB_TOKEN} \
    -v $(pwd):/app/ \
    -w /app/ \
    -t \
    -u node \
    node:10.24.1 \
    bin/build-components-init.sh
