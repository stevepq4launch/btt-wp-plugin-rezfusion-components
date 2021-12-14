#!/bin/bash
set -e
CHECK_PASSED=1
REQUIRED_VARIABLES=(
    GITHUB_TOKEN
    WP_BASE_IMAGE
    BLUEPRINT_CHANNEL
    BLUEPRINT_URL
    BLUEPRINT_ENVIRONMENT
)

for VARIABLE_NAME in ${REQUIRED_VARIABLES[*]}; do
    if [ -z ${!VARIABLE_NAME} ]; then
        echo -e "Variable ${VARIABLE_NAME} is missing."
        CHECK_PASSED=0
    fi
done

if [ ${CHECK_PASSED} -eq 0 ]; then
    echo -e "\e[31m(!) Check failed.\e[0m\n"
    exit 1
fi

echo -e "\e[32m(+) Check passed.\e[0m\n"

exit 0
