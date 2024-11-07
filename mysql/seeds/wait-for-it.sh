#!/usr/bin/env bash
# wait-for-it.sh

set -e

host="$1"
shift
cmd="$@"

until mysql -h "$host" -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -e 'select 1'; do
    >&2 echo "MySQL is unavailable - sleeping"
    sleep 1
done

>&2 echo "MySQL is up - executing command"
exec $cmd