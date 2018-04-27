#inesa take out

#### deploy

``` bash
 composer install 

 composer dumpautoload

 php artisan migrate

 php artisan db:seed --class=RegionsTableSeeder
 
 php artisan passport:install
 
```

#### gnupg

``` bash
gpg --homedir /path/to/your/project --import private-key.txt
```

change config/gnupg.php 

``` php
    'gpg' => [
        'gnupg_home' => 'GNUPGHOME=/path/to/your/project/.gnupg',
        'private_key_fingerprint' => 'fingerprint',
        'public_key_fingerprint' => 'fingerprint',
    ],
```

#### redis

* change config/database.php or .env

```php
    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],
```

* change config/queue.php

```php
        'sync' => [
            'driver' => 'redis',
        ],
        ...
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => '{default}',
            'retry_after' => 90,
        ],
```

* start queue work

```bash
php artisan queue:work redis 
```
