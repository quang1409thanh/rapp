# 1.Sử dụng ở máy
nếu sử dụng clone repo từ github thì làm như sau
1. clone project về
2. cài đặt cái module cần thiết trong file composer.json và package.json
bằng các câu lệnh như 
   
    `composer install`
    `npm install`
    `npm run dev`   
    `npm run build`
3. hiện tại do chưa biết nguyên nhân lỗi navabar ở đâu
nên lưu ý gói cài đặt này sẽ ghi đè thư mục public/build
chính vì vậy phải giữ lại thư mục này sau đấy thay thế sau khi chạy các câu lệnh trên
4. cấu hình file `.env` rất quan rọng
# 2.deploy lên heroku hay 1 infinity
## 1. heroku
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
    heroku create
### 1.5 `add build package`
heroku buildpacks:add --index 1 heroku/nodejs
heroku buildpacks:add --index 2 heroku/php

### 1.6 `git push heroku main` <deploy>

### 1.7 `config`
    heroku config:set APP_NAME=app
    heroku config:set APP_ENV=production
    heroku config:set APP_KEY=base64:h1ee74tBoTw5x8gJGaYF3K2zjB5rW2i5OPClUumEjtA=
    heroku config:set APP_DEBUG=true
    heroku config:set APP_URL=https://thanhyk14-2647b9f55072.herokuapp.com/
    

mysql://bd7c54bc68b525:3e33ed23@us-cdbr-east-06.cleardb.net/heroku_805239cc0002cbe?reconnect=true
    heroku config:set DB_CONNECTION=mysql
    heroku config:set DB_HOST=us-cdbr-east-06.cleardb.net
    heroku config:set DB_PORT=3306
    heroku config:set DB_DATABASE=heroku_805239cc0002cbe
    heroku config:set DB_USERNAME=bd7c54bc68b525
    heroku config:set DB_PASSWORD=3e33ed23
    run migrate and import file sql
    đang import file sql
## 2. infinity 
    - up thư mục của mình lên thư mục htdocs
    - cấu trúc thư mục như sau
    ở trên máy:
    root_app/
    ├── node_modules/
    ├── public/
    │   ├── build
    │   ├── .htaccess
    │   ├── index.php
    │   └── other folder
    ├── .env
    ├── composer.json
    ├── package.json
    └── other file 
    sau khi update lên infinity
    sẽ có cấu trúc như sau
    htdocs/
    ├── build
    ├── .htaccess
    ├── index.php
    └── root_app/
        ├── node_modules/
        ├── vendor/
        ├── .env
        ├── composer.json
        ├── package.json
        └── other file 
    cấu hình lại như sau
    - cấu hình file .env đến cơ sở dữ liệu, đường dẫn phù hợp, local -> production
    - cấu hình một số thứ như sau
1. file .htaccess thêm 
    - `RewriteEngine OnRewriteRule (.*) /public/$1 [L]`
2. cấu hình đến file 
    - `index.php`
    - `__DIR__.'/../`=> `__DIR__.'/root_app/`
2. file .env
    - cấu hình tất cả các thứ liên quan đến db
    -   `APP_NAME=app_name`
        `APP_ENV=production`
        `APP_DEBUG=true`
        `APP_URL=link_app`
