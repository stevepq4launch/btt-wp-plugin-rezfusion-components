#!/bin/bash
set -e
if [ -z "$1" ]; then
    exit 1
fi
rm -rf release-temp-dir/
rm -f release.zip
rm -f release-*.zip
mkdir -p release-temp-dir/rezfusion-components/
rsync -av src includes assets queries templates dist rezfusion-components.php LICENSE.txt CHANGELOG.md vendor release-temp-dir/rezfusion-components/
cd release-temp-dir/
zip -r ../release-${1}.zip rezfusion-components/
rm -rf ../release-temp-dir/
exit 0
