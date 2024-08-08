# rapp

## Cách chạy ở local
1. c//omposer require laravel/jetstream
2. php artisan jetstream:install livewire 
3. npm install
4. npm run dev
5. composer require stripe/stripe-php
6. composer require barryvdh/laravel-dompdf
7. composer require realrashid/sweet-alaert

## cach deploy len heroku
cần có tài khoản heroku
### 1.1 `đăng nhập`
    heroku login
### 1.2 `khởi tạo 1 repo ở local`
    git init -b main
    git add .
    git commit -m "new laravel project"
### 1.3 `tạo procfile`
    echo "web: heroku-php-apache2 public/" > Procfile
    git add .
    git commit -m "Procfile for Heroku"
### 1.4 `create app`
    heroku create thanhyk14
### 1.5 `add build package`
    heroku buildpacks:add --index 1 heroku/nodejs
    heroku buildpacks:add --index 2 heroku/php

### 1.6 `git push heroku main` <deploy>

### 1.7 `config`
chạy cái này trước

    heroku config:set APP_NAME=app
    heroku config:set APP_ENV=production
    heroku config:set APP_KEY=base64:h1ee74tBoTw5x8gJGaYF3K2zjB5rW2i5OPClUumEjtA=
    heroku config:set APP_DEBUG=true
    heroku config:set APP_URL=https://demo-30-7-2023-75ad8092021d.herokuapp.com/
    `heroku buildpacks:remove heroku/nodejs`¹

mysql://be9443265c3eb0:492defba@us-cdbr-east-06.cleardb.net/heroku_3399bac60271e97?reconnect=true

        heroku config:set DB_CONNECTION=mysql
        heroku config:set DB_HOST=us-cdbr-east-06.cleardb.net
        heroku config:set DB_PORT=3306
        heroku config:set DB_DATABASE=heroku_3399bac60271e97
        heroku config:set DB_USERNAME=be9443265c3eb0
        heroku config:set DB_PASSWORD=492defba
        run migrate and import file sql
        heroku run php artisan migrate
        đang import file sql

