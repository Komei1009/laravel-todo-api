FROM php:8.1-fpm-alpine

ENV TZ Asia/Tokyo

WORKDIR /var/www/

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# see https://readouble.com/laravel/9.x/ja/deployment.html#server-configuration
#
# 以下の拡張は PHP でデフォルトで有効になっているため、個別インストールは不要
# - Ctype
# - Dom
# - Fileinfo
# - Json
# - Pcre
# - Pdo
# - Tokenizer
# - XML
#
# 以下は 拡張元のコンテナでインストールされているため、個別インストールは不要
# see https://github.com/docker-library/php/blob/c5e3d3554953288d901ff32d788d9a84fb89c405/8.1/alpine3.15/fpm/Dockerfile
# - Curl
# - Mbctring
# - Openssl
RUN docker-php-ext-install \
      bcmath \
      pdo_mysql \
    && apk --update --no-cache add \
      autoconf \
      gcc \
      g++ \
      make \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# 設定を優先的に読み込みたいのでプレフィックスとして zz- を付けて読み込むタイミングを最後にする
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zz-app.conf
COPY php.ini $PHP_INI_DIR/conf.d/app.ini
COPY xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

# composer をインストール
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
