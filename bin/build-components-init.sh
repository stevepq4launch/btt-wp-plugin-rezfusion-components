#!/bin/bash
set -e
if [ -e ${GITHUB_TOKEN} ]; then
    echo "Invalid/empty GitHub token."
    exit 1
fi
mkdir ~/.ssh/
touch ~/.ssh/ssh_config
echo "StrictHostKeyChecking no" >>~/.ssh/ssh_config
touch ~/.npmrc
echo -e "@PropertyBrands:registry=https://npm.pkg.github.com\n//npm.pkg.github.com/:_authToken=${GITHUB_TOKEN}" >~/.npmrc
git config --global url."https://${GITHUB_TOKEN}@github.com/PropertyBrands/".insteadOf ssh://git@github.com/PropertyBrands/
npm install
npm run build
