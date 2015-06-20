#!/bin/sh

vendor/bin/phpunit --colors -c app
echo "Running Code Sniffer"
vendor/bin/phpcs src --colors --ignore=build,vendor,node_modules,tmp --standard=PSR2 -p