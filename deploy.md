# Ubuntu 24.04.3 LTS 部署步骤（Laravel 12.x）

## 1) 安装系统依赖
```bash
sudo apt update
sudo apt install -y nginx git unzip supervisor
sudo apt install -y php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd php8.3-intl
```

### PHP 安全版本检查

Ubuntu 24.04 的 PHP 软件包必须达到 `8.3.6-0ubuntu0.24.04.13` 或更新版本，
该版本已修复 CVE-2026-109618 和 CVE-2026-109619。
安装依赖后、启动网站前执行：

```bash
for package in php8.3-cli php8.3-common php8.3-fpm; do
    version=$(dpkg-query -W -f='${Version}' "$package") || exit 1
    if ! dpkg --compare-versions "$version" ge '8.3.6-0ubuntu0.24.04.13'; then
        echo "$package $version 尚未包含所需安全补丁，请先更新软件源并升级 PHP。" >&2
        exit 1
    fi
    echo "$package $version: OK"
done
```

如果检查失败，先确认 `noble-security` 或 `noble-updates` 已启用，并检查候选版本：

```bash
sudo apt update
apt-cache policy php8.3-fpm php8.3-cli php8.3-common
apt-mark showhold
```

Ubuntu 回移了安全补丁，`php -v` 仍显示 `8.3.6` 是正常现象，必须比较完整软件包版本。
不要通过 `composer.json` 的 PHP 版本下限判断发行版是否已打补丁，也不要用
`composer update` 代替 PHP 系统升级。

参考：[Ubuntu 安全公告 USN-8948-1](https://ubuntu.com/security/notices/USN-8948-1)、
[PHP 官方安全公告](https://www.php.net/archive/2026.php#2026-10-21-1)。

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

# 上传目录（避免 mkdir permission denied）
sudo mkdir -p public/uploads/images
sudo chown -R www-data:www-data public/uploads
sudo find public/uploads -type d -exec chmod 775 {} \;
sudo find public/uploads -type f -exec chmod 664 {} \;
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

## 9) 代码更新
```bash
sudo systemctl stop nginx

# 使用部署用户拉代码，避免文件属主变成 root
git pull origin <branch>

composer install --no-dev --optimize-autoloader
npm install
npm run build

php artisan migrate --force   # 可选
php artisan route:clear
php artisan view:clear
php artisan optimize
php artisan queue:restart     # 可选（修改了 Job 相关逻辑时执行）

# 重新校正上传目录权限，避免上传文件无法读取或写入
sudo chown -R www-data:www-data /var/www/personal-blog/public/uploads
sudo find /var/www/personal-blog/public/uploads -type d -exec chmod 755 {} \;
sudo find /var/www/personal-blog/public/uploads -type f -exec chmod 644 {} \;

sudo systemctl start nginx
sudo systemctl status nginx
```

## 10) 已有服务器的 PHP 安全更新

先确认软件源的候选版本满足第 1 节的安全要求。升级可能自动重启 PHP-FPM，
请在可接受短暂中断的时段操作，并保留现有 PHP 配置：

```bash
sudo php-fpm8.3 -t
sudo cp -a /etc/php/8.3 "/etc/php/8.3.backup-$(date +%Y%m%d-%H%M%S)"
sudo apt update
sudo apt install --only-upgrade php8.3-cli php8.3-common php8.3-fpm
sudo php-fpm8.3 -t && sudo systemctl restart php8.3-fpm
systemctl is-active php8.3-fpm
```

重新执行第 1 节的软件包版本检查，并验证首页、文章、登录和图片上传。
如有 Supervisor 管理的 Laravel 队列，在项目目录使用部署用户执行
`php artisan queue:restart`，并确认队列进程已重新启动。
软件包升级不会替换已运行进程中的 PHP，必须重启实际提供服务的进程。

## 11) 本地 WSL 环境的 PHP 安全更新

以下命令适用于 Ubuntu 24.04 的本地 CLI 开发环境：

```bash
sudo apt update
sudo apt install --only-upgrade php8.3-cli php8.3-common
dpkg-query -W -f='${Package}\t${Version}\n' php8.3-cli php8.3-common
```

两个软件包均应达到 `8.3.6-0ubuntu0.24.04.13` 或更新版本。
停止并重新启动已有的 `composer run dev`、`php artisan serve` 或队列进程，
然后在项目目录执行 `composer run test`。如果本地还运行 PHP-FPM，请按第 10 节更新和重启。

## 12) Docker PHP 镜像更新

`Dockerfile` 使用包含安全补丁的 `php:8.2.35-apache`，并在构建时检查实际 PHP 版本。
后续更新镜像时，PHP 8.2 分支不得低于 8.2.35；切换分支时应重新核对该分支的修复版本，
同步调整构建检查。PHP 8.2 将于 2026-12-31 结束上游支持，请在此之前安排分支升级。

```bash
docker build --pull -t personal-blog:php-security .
docker run --rm personal-blog:php-security php -v
```

构建成功后，使用新镜像重新创建实际的 Web 容器，并保留原有环境变量、挂载和网络配置。
只重启旧容器不会应用新镜像。仓库的 `docker-compose.yml` 仅定义 MySQL，
`docker compose up -d` 不会构建或替换 PHP Web 容器。
