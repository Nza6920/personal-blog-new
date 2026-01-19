# Ubuntu 24.04.3 LTS 部署步骤（Laravel 12.x）

## 1) 安装系统依赖
```bash
sudo apt update
sudo apt install -y nginx git unzip supervisor
sudo apt install -y php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd php8.3-intl
```

## 2) 安装 Composer 与 Node.js
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php

curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

## 3) 拉取代码
```bash
cd /var/www
sudo git clone <your-repo-url> personal-blog
sudo chown -R $USER:$USER /var/www/personal-blog
cd /var/www/personal-blog
```

## 4) 安装依赖并构建资源
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

## 5) 配置环境变量
```bash
cp .env.example .env
php artisan key:generate
```
编辑 `.env`，至少设置：
- `APP_ENV=production`，`APP_DEBUG=false`，`APP_URL=https://your-domain.com`
- 数据库：`DB_HOST`、`DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD`
- Laravel 12.x 常用项：`CACHE_STORE`、`SESSION_DRIVER`、`QUEUE_CONNECTION`、`BROADCAST_CONNECTION`、`FILESYSTEM_DISK`
- 邮件：`MAIL_MAILER` 与发件人信息（如仅记录日志可用 `log`）



## 6) 数据库与权限
```bash
php artisan migrate --force
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```
如需公开存储目录：
```bash
php artisan storage:link
```

## 7) Nginx 配置（基于旧配置，适配 PHP 8.3）
创建 `/etc/nginx/sites-available/personal-blog`：
```nginx
server {
    listen 443 ssl default_server;
    listen [::]:443 ssl default_server;

    # crt证书目录
    ssl_certificate /var/ssl/1_www.your-domain.com_bundle.crt;
    # key证书目录
    ssl_certificate_key /var/ssl/2_www.your-domain.com.key;

    server_name your-domain.com www.your-domain.com;
    root /var/www/personal-blog/public;

    index index.html index.htm index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log /var/log/nginx/personal-blog.log;
    error_log  /var/log/nginx/personal-blog-error.log error;

    sendfile off;
    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }
}

server {
    listen 80 default_server;
    listen [::]:80 default_server;

    # 需要重定向的域名, 替换为你自己的即可
    server_name your-domain.com www.your-domain.com;

    return 301 https://$server_name$request_uri;
}
```
启用并重载：
```bash
sudo ln -s /etc/nginx/sites-available/personal-blog /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 8) 队列与计划任务
如果 `QUEUE_CONNECTION=database`，请配置 Supervisor `/etc/supervisor/conf.d/laravel-queue.conf`：
```ini
[program:laravel-queue]
command=php /var/www/personal-blog/artisan queue:work --sleep=3 --tries=1
directory=/var/www/personal-blog
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/personal-blog/storage/logs/queue.log
```
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-queue
```
计划任务：
```bash
sudo crontab -e
```
添加：
```
* * * * * cd /var/www/personal-blog && php artisan schedule:run >> /dev/null 2>&1
```
