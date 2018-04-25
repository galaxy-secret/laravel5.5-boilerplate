## laravel5.5-boilerplate

```bash
  composer install 

  composer dumpautoload

  php artisan migrate

  php artisan db:seed --class=RegionsTableSeeder

  php artisan passport:install
```

## gnupg

need [php gnupg](http://pecl.php.net/package/gnupg)

```bash

gpg --homedir /path/to/your/project --import private-key.txt

# update config/gnupg.php
    'gpg' => [
        'gnupg_home' => 'GNUPGHOME=/path/to/your/project/.gnupg',
        'private_key_fingerprint' => 'fingerprint',
        'public_key_fingerprint' => 'fingerprint',
    ],

```
