FROM nginx:1.18

RUN openssl req -x509 -nodes -days 365 \
    -subj "/C=CA/ST=QC/O=Company, Inc./CN=mydomain.com" \
    -addext "subjectAltName=DNS:mydomain.com" \
    -newkey rsa:2048 \
    -keyout /etc/ssl/private/magento.key \
    -out /etc/ssl/certs/magento.pem

ADD etc/vhost.conf /etc/nginx/conf.d/default.conf

ADD docker-entrypoint.sh /docker-entrypoint.sh
RUN ["chmod", "+x", "/docker-entrypoint.sh"]
ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["nginx", "-g", "daemon off;"]
