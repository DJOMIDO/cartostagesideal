# 使用官方 PHP Apache 镜像
FROM php:8.1-apache

# 安装必要扩展
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 启用 Apache 重写模块
RUN a2enmod rewrite

# 复制 Apache 配置文件
COPY ./config/apache.conf /etc/apache2/sites-available/000-default.conf

# 复制项目源代码到容器中
COPY ./src/ /var/www/html/

# 设置工作目录
WORKDIR /var/www/html
