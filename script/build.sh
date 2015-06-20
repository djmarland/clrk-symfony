#!/bin/sh

vendor/bin/phpunit app/tests
vendor/bin/phpcs app --ignore=build,vendor,node_modules,tmp --standard=PSR2 -p --report=checkstyle --report-file=build/reports/checkstyle.xml
