FROM nginx:1.18

ADD etc/vhost.conf /etc/nginx/conf.d/default.conf

ENV DEBUG false
ENV FPM_HOST fpm
ENV FPM_PORT 9000
ENV MAGENTO_ROOT /app
ENV MAGENTO_RUN_MODE developer
ENV UPLOAD_MAX_FILESIZE 64M

ADD docker-entrypoint.sh /docker-entrypoint.sh
RUN ["chmod", "+x", "/docker-entrypoint.sh"]
ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["nginx", "-g", "daemon off;"]
