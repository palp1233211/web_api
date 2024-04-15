# syntax=docker/dockerfile:1

# 使用官方的 Nginx 镜像作为基础镜像
FROM nginx:latest

# 安装系统依赖
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    bash-completion \
    rlwrap \
    procps \
    coreutils

# 配置 bash-completion
RUN echo "if [ -f /etc/bash_completion ]; then\n    . /etc/bash_completion\nfi" >> /etc/bash.bashrc


