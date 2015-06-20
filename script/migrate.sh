#!/bin/sh

# Apply new migrations
# ./script/migrate migrations:migrate

# Rollback latest migration
# ./script/migrate.sh migrations:migrate prev

# get the list of clients

# generate the connections list (differs by environment)

# loop through each, running the migrations

php ./migrations/doctrine-migrations.phar $@ --configuration=./migrations/configuration.yaml --db-configuration=./migrations/connections/client_demo.php