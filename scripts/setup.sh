#!/usr/bin/env bash
# Functions
function retry {
  local n=1
  local max=5
  local delay=5
  while true; do
    "$@" && break || {
      if [[ $n -lt $max ]]; then
        ((n++))
        echo "Command failed. Attempt $n/$max:"
        sleep $delay;
      else
        fail "The command has failed after $n attempts."
      fi
    }
  done
}

function fail {
  echo $1 >&2
  exit 1
}


# Start setting up
docker-compose up -d &&
retry docker-compose exec php-fpm php bin/console doctrine:schema:update --force &&
retry docker-compose exec php-fpm curl -XDELETE "http://elastic:changeme@elasticsearch:9200/rides" &&
retry docker-compose exec php-fpm curl -XPUT "http://elastic:changeme@elasticsearch:9200/rides" -H 'Content-Type: application/json' -d'
{
  "settings": {}
}'