#!/bin/bash
set -e

TEST_PARAMS=''
export TEST_LOG=0

while getopts ":rl" o; do
    case "${o}" in
    r)
        TEST_PARAMS="--log-junit=build/junit.xml --coverage-html=build/coverage-report"
        ;;
    l)
        TEST_LOG=1
        ;;
    *)
        echo "Invalid parameter."
        exit 1
        ;;
    esac

done

php run-before-test.php
vendor/bin/paratest ${TEST_PARAMS} -p8 --runner=WrapperRunner ./tests
