#!/bin/sh

vendor/bin/phpunit --colors -c app/tests/phpunit.xml app/tests
vendor/bin/phpcs app --colors --ignore=build,vendor,node_modules,tmp --standard=PSR2 -p