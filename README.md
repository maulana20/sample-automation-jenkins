# automation-webhook-provider
automation webhook provider

install
```
$ docker-compose build
$ docker-compose up -d
```

job
```
$ php artisan queue:work
```

dump
```
$ php artisan dump-server
```

optional : ip container
```
$ docker network inspect -f '{{json .Containers}}' NETWORK_ID | jq '.[] | .Name + ":" + .IPv4Address'
```