#!/bin/bash
set -e
VERSION=$1
if [ -z "$VERSION" ]; then
    exit 1
fi
sed -i 's/\(version:\? \)\([0-9]\+\.\?\)\{0,3\}/\1'${VERSION}'/gi' rezfusion-components.php
sed -i 's/"version": "\([0-9]\+\.\?\)\{0,3\}"/"version": "'${VERSION}'"/gi' package.json
sed -i '0,/"version": "\([0-9]\+\.\?\)\{0,3\}"/{s/"version": "\([0-9]\+\.\?\)\{0,3\}"/"version": "'${VERSION}'"/gi}' package-lock.json
exit 0
