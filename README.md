# CQRS RideSharing demo application
Only for demonstration purposes.

## Pre-requisites

- Docker installed (with memory limit >= 4GB)

## Installation

- Run `composer install`
- Run `./scripts/setup.sh`

## Running

### Web

http://localhost:8080/ride/departure/all
http://localhost:8080/ride/register
```

### CLI

```
docker-compose exec php-fpm php bin/console ride-share:ride:register [departure-lat] [departure-long] [destination-lat] [destination-long] [departure-time]            
```

## Utils
### Rebuilding read models
Clear your read models manually and execute the following command:
```
docker-compose exec php-fpm php bin/console utils:rebuild-read-models
```