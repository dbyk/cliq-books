#
FROM composer:2.4 AS get-composer
FROM php:7.4-fpm-alpine

WORKDIR /var/app



# Install dependencies
RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
    pcre-dev \
    php7-pear \
    $PHPIZE_DEPS \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql ; \
    docker-php-ext-install pdo_mysql

# todo
# target dev

ARG PSR_VERSION=1.0.0
ARG PHALCON_VERSION=5.0.4
ARG PHALCON_EXT_PATH=php7/64bits
ARG XDEBUG_VERSION=3.1.2

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apk add --no-cache git autoconf build-base pcre-dev re2c

RUN pecl channel-update pecl.php.net \
    && pecl install zephir_parser \
    && pecl install xdebug-${XDEBUG_VERSION}
#    && pecl install phalcon-5.0.4 \


COPY --from=get-composer /usr/bin/composer /usr/local/bin/composer

#RUN curl -OL https://github.com/zephir-lang/zephir/releases/download/0.16.3/zephir.phar

#RUN mv zephir.phar /usr/local/bin/zephir && chmod a+x /usr/local/bin/zephir


#RUN git clone https://github.com/phalcon/cphalcon \

COPY cphalcon cphalcon

WORKDIR cphalcon
RUN cp zephir.phar /usr/local/bin/zephir && chmod a+x /usr/local/bin/zephir
RUN echo $(which zephir)
RUN echo "extension=zephir_parser.so" >> /usr/local/etc/php/conf.d/zephir_parser.ini
RUN git checkout tags/v5.0.4 ./

RUN echo "memory_limit 2G" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN php -i | grep "memory_limit"

RUN zephir fullclean
RUN zephir build

RUN php -m | grep phalcon
RUN echo "extension=phalcon.so" >> /usr/local/etc/php/conf.d/phalcon.ini

WORKDIR /var/app

#RUN pecl clear-cache; \
#    apk del .build-deps git

#RUN #set -xe && \
#   # install PSR
#   curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
#   tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
#   # install Phalcon
#   curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
#   tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
#   docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
#       ${PWD}/php-psr-${PSR_VERSION} \
#       ${PWD}/cphalcon-${PHALCON_VERSION}/ext \
#   && \
#   # remove tmp file
#   rm -r \
#       ${PWD}/v${PSR_VERSION}.tar.gz \
#       ${PWD}/php-psr-${PSR_VERSION} \
#       ${PWD}/v${PHALCON_VERSION}.tar.gz \
#       ${PWD}/cphalcon-${PHALCON_VERSION} \
#   && \
#   php -m