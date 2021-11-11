#!/bin/bash
set -e
if [ -z "$1" ]; then
    exit 1
fi
sed -i 's/shields.io\/badge\/version-\([0-9]\+\.\?\)\{0,3\}-blue/shields.io\/badge\/version-'${1}'-blue/g' README.md
sed -i 's/img.shields.io\/badge\/Last%20update-\([0-9-]\+\)-yellow/img.shields.io\/badge\/Last%20update-'${2}'-yellow/g' README.md
exit 0
