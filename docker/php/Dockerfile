FROM alpine:edge

LABEL maintainer="Janosch Kocsis <jk@coloso.de>"

RUN apk add --update \
    php7-fpm \
    php7-apcu \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-gd \
    php7-iconv \
    php7-imagick \
    php7-json \
    php7-intl \
    php7-mcrypt \
    php7-fileinfo \
    php7-mbstring \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-xml \
    php7-zlib \
    php7-phar \
    php7-tokenizer \
    php7-session \
    php7-simplexml \
    php7-xdebug \
    php7-zip \
    make \
    curl \
    nodejs \
    yarn \
    g++

ENV     C_INCLUDE_PATH /usr/include/glib-2.0:/usr/lib/glib-2.0/include
RUN     apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing \
        vips-tools vips-dev glib-dev php7-dev php7-pear build-base libxml2-dev

RUN pecl install -o -f redis && rm -rf /tmp/pear

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/* && \
    curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

ADD php.ini /etc/php7/conf.d/
ADD php.ini /etc/php7/cli/conf.d/
ADD php-fpm.conf /etc/php7/php-fpm.d/
#ADD xdebug.ini  /etc/php7/conf.d/

WORKDIR /var/www/symfony

RUN adduser -D -g 'www' www \
    && chown -R www:www /var/www

CMD ["php-fpm7", "-F"]

EXPOSE 9001
