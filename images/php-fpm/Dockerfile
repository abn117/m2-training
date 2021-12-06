FROM php:7.4-fpm

# Install dependencies
RUN apt-get update \
  && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxslt1-dev \
    sendmail-bin \
    sendmail \
    sudo \
    wget \
    libzip-dev \
    libonig-dev

# Install MailHog
RUN wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
  && sudo chmod +x mhsendmail_linux_amd64 \
  && sudo mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail

# Configure the gd library
RUN docker-php-ext-configure \
  gd --with-freetype --with-jpeg

# Install required PHP extensions
RUN docker-php-ext-install \
  bcmath \
  dom \
  gd \
  intl \
  mbstring \
  pcntl \
  soap \
  sockets \
  pdo_mysql \
  xsl \
  zip

RUN pecl install -o -f \
  xdebug \
  redis

RUN docker-php-ext-enable redis

ENV DEBUG false
ENV ENABLE_SENDMAIL true
ENV PHP_MEMORY_LIMIT 756M
ENV PHP_ENABLE_XDEBUG false
ENV MAGENTO_ROOT /app
ENV MAGENTO_RUN_MODE developer
ENV UPDATE_UID_GID true

ADD etc/php.ini /usr/local/etc/php/conf.d/zz-magento.ini
ADD etc/php-xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini
ADD etc/php-fpm.conf /usr/local/etc/

ADD docker-entrypoint.sh /docker-entrypoint.sh
RUN ["chmod", "+x", "/docker-entrypoint.sh"]
ENTRYPOINT ["/docker-entrypoint.sh"]

WORKDIR ${MAGENTO_ROOT}
CMD ["php-fpm", "-F"]
