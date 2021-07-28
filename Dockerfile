FROM php:7.4-apache

RUN apt-get update; \
	apt-get install -y --no-install-recommends --fix-missing \
    apt-utils \
    gnupg

RUN echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list
RUN echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list
RUN curl -sS --insecure https://www.dotdeb.org/dotdeb.gpg | apt-key add -

RUN apt-get update && apt-get install -y \
	zlib1g-dev \
    libzip-dev \
    git \
	default-mysql-client \
	unzip && \
    docker-php-ext-install sockets pcntl zip && \
	rm -rf /var/lib/apt/lists/*

# Instalacion de Composer de forma global
RUN	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	mv composer.phar /usr/local/bin/composer && \
	php -r "unlink('composer-setup.php');"

COPY ./ ./

RUN	COMPOSER_MEMORY_LIMIT=-1 composer update

# CMD
CMD ["apache2-foreground"]