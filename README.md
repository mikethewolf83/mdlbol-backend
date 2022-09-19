# MdlBol Backend

Lumen RESTful API application as a backend for MdlBol Frontend

## App dependencies

* Web server such as Apache HTTP Server or Nginx or any other with PHP support
* PHP "^7.3|^8.0" with support for MariaDB or MySQL databases
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* MariaDB Server "^10.4" minimum, or MySQL "^5.7" minimum

## Installation and configuration

Follow the steps below for  a production environment

1- Copy the .env.example file as .env if not exists

2- Edit the .env file with the following options:
```bash
APP_NAME=mdlbol-backend
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=
APP_TIMEZONE=America/Havana

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

3- Be sure to declare de app URL in the APP_URL variable key

4- Run the following to install app dependencies
```bash
composer install
```

5- Then create the API KEY for use in the .env file like this: 
```bash
./artisan key:generate
```
Be sure to copy/paste the generated key (whithout the "base64:" part) in API_KEY variable

6- Update the APP_ENV variable to production

7- Execute the following:
```bash
./artisan jwt:secret
```

8- Create a virtual host config to point the public folder

## License

This application is licensed under the [MIT license](https://opensource.org/licenses/MIT).
