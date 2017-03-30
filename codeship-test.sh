#!/usr/bin/env bash

composer install --no-scripts
./vendor/bin/phpunit --report-useless-tests tests

