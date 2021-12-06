#!/bin/bash

[ "$DEBUG" = "true" ] && set -x

# If asked, we'll ensure that the www-data is set to the same uid/gid as the
# mounted volume. This works around permission issues with virtualbox shared
# folders.
if [[ "$UPDATE_UID_GID" = "true" ]]; then
    echo "Updating www-data uid and gid"

    DOCKER_UID=`stat -c "%u" $MAGENTO_ROOT`
    DOCKER_GID=`stat -c "%g" $MAGENTO_ROOT`

    INCUMBENT_USER=`getent passwd $DOCKER_UID | cut -d: -f1`
    INCUMBENT_GROUP=`getent group $DOCKER_GID | cut -d: -f1`

    echo "Docker: uid = $DOCKER_UID, gid = $DOCKER_GID"
    echo "Incumbent: user = $INCUMBENT_USER, group = $INCUMBENT_GROUP"

    # Once we've established the ids and incumbent ids then we need to free them
    # up (if necessary) and then make the change to www-data.

    [ ! -z "${INCUMBENT_USER}" ] && usermod -u 99$DOCKER_UID $INCUMBENT_USER
    usermod -u $DOCKER_UID www-data

    [ ! -z "${INCUMBENT_GROUP}" ] && groupmod -g 99$DOCKER_GID $INCUMBENT_GROUP
    groupmod -g $DOCKER_GID www-data
fi

# Ensure our Magento directory exists
mkdir -p $MAGENTO_ROOT
chown www-data:www-data $MAGENTO_ROOT

echo $MAGENTO_DB_PASSWORD

PHP_EXT_DIR=/usr/local/etc/php/conf.d
CRON_LOG=/var/log/cron.log

# Setup Magento cron
echo "* * * * * www-data /usr/local/bin/php ${MAGENTO_ROOT}/bin/magento cron:run | grep -v \"Ran jobs by schedule\" >> ${MAGENTO_ROOT}/var/log/magento.cron.log" > /etc/cron.d/magento

# Get rsyslog running for cron output
touch $CRON_LOG
echo "cron.* $CRON_LOG" > /etc/rsyslog.d/cron.conf
service rsyslog start

# Configure Sendmail if required
if [ "$ENABLE_SENDMAIL" == "true" ]; then
    sed -i "s/!SENDMAIL_PATH!/\"\/usr\/local\/bin\/mhsendmail --smtp-addr=mailhog:1025\"/" ${PHP_EXT_DIR}/zz-magento.ini
else
    sed -i "s/!SENDMAIL_PATH!/\"true > \/dev\/null\"/" ${PHP_EXT_DIR}/zz-magento.ini
fi

# Substitute in php.ini values
[ ! -z "${PHP_MEMORY_LIMIT}" ] && sed -i "s/!PHP_MEMORY_LIMIT!/${PHP_MEMORY_LIMIT}/" ${PHP_EXT_DIR}/zz-magento.ini

[ "$PHP_ENABLE_XDEBUG" = "true" ] && \
    docker-php-ext-enable xdebug && \
    echo "Xdebug is enabled"

# Configure composer
[ ! -z "${COMPOSER_GITHUB_TOKEN}" ] && \
    composer config --global github-oauth.github.com $COMPOSER_GITHUB_TOKEN

[ ! -z "${COMPOSER_MAGENTO_USERNAME}" ] && \
    composer config --global http-basic.repo.magento.com \
        $COMPOSER_MAGENTO_USERNAME $COMPOSER_MAGENTO_PASSWORD

exec "$@"
