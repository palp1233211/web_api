# syntax=docker/dockerfile:1

# Use an official PHP image as a base image
FROM php:7.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    bash-completion \
    rlwrap \
    procps \
    coreutils\
    && docker-php-ext-install mbstring pdo pdo_mysql \
    && pecl install zip-1.19.0 \
    && pecl install xlswriter-1.3.4.1 \
    && pecl install swoole-4.8.0 \
    && pecl install psr-1.0.1 \
    && pecl install redis-4.2.0 \
    && pecl install yaconf-1.1.2 \
    && docker-php-ext-enable xlswriter swoole psr  pdo pdo_mysql redis pdo pdo_mysql mbstring zip yaconf \
    && pecl install phalcon-4.1.2  \
    && docker-php-ext-enable phalcon


# 设置工作目录
WORKDIR /mnt/www

COPY ./php/start.sh /start.sh

RUN chmod +x /start.sh

CMD ["/start.sh"]

