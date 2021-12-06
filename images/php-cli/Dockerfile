FROM php:7.4-cli

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
    unzip \
    sudo \
    cron \
    rsyslog \
    default-mysql-client \
    git \
    libzip-dev \
    libonig-dev

# Configure the gd library
RUN docker-php-ext-configure \
  gd --with-freetype --with-jpeg

# Install required PHP extensions
RUN docker-php-ext-install \
  dom \
  gd \
  intl \
  mbstring \
  pdo_mysql \
  xsl \
  zip \
  soap \
  bcmath \
  pcntl \
  sockets

RUN pecl install -o -f \
  xdebug \
  redis

RUN docker-php-ext-enable redis

ENV DEBUG false
ENV ENABLE_SENDMAIL true
ENV PHP_MEMORY_LIMIT 2G
ENV PHP_ENABLE_XDEBUG false
ENV MAGENTO_ROOT /app
ENV MAGENTO_RUN_MODE developer
ENV UPDATE_UID_GID true

ADD docker-entrypoint.sh /docker-entrypoint.sh
RUN ["chmod", "+x", "/docker-entrypoint.sh"]
ENTRYPOINT ["/docker-entrypoint.sh"]

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_GITHUB_TOKEN ""
ENV COMPOSER_MAGENTO_USERNAME ""
ENV COMPOSER_MAGENTO_PASSWORD ""

VOLUME /root/.composer/cache

# Get composer installed to /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Fix error "imklog: cannot open kernel log (/proc/kmsg)"
RUN sed -i '/imklog/s/^/#/' /etc/rsyslog.conf

ADD etc/php.ini /usr/local/etc/php/conf.d/zz-magento.ini
ADD etc/php-xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini
ADD bin/* /usr/local/bin/

RUN ["chmod", "+x", "/usr/local/bin/magento-installer"]
RUN ["chmod", "+x", "/usr/local/bin/magento"]
RUN ["chmod", "+x", "/usr/local/bin/run-cron"]

WORKDIR ${MAGENTO_ROOT}
CMD ["bash"]
