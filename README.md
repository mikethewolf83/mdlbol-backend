# MdlBol Backend

Lumen RESTful API application as a backend for MdlBol Frontend

## Installation and configuration

Follow the steps below for production

1- Copy the .env.example file as .env

2- Edit the .env file with the following options:
```bash
APP_NAME=mdlbol-backend
APP_ENV=
APP_KEY=
APP_DEBUG=false
APP_URL=
APP_TIMEZONE=

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
3- Then create the API KEY for use in the .env file like this: 
```bash
./artisan key:generate
```
Be sure to copy/paste the generated key (whithout the "base64:" part) in API_KEY variable

4- Update the APP_ENV variable to production

5- Execute the following:
```bash
./artisan jwt:secret
```

## License

This application is licensed under the [MIT license](https://opensource.org/licenses/MIT).
