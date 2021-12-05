FROM wordpress:5.8.2-php7.4-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

RUN apt-get update
RUN apt-get install -y npm

WORKDIR "/var/www/html"

ENV WORDPRESS_DB_HOST=$WORDPRESS_DB_HOST
ENV WORDPRESS_DB_USER=$WORDPRESS_DB_USER
ENV WORDPRESS_DB_PASSWORD=$WORDPRESS_DB_PASSWORD
ENV WORDPRESS_DB_NAME=$WORDPRESS_DB_NAME
ENV WORDPRESS_TABLE_PREFIX=$WORDPRESS_TABLE_PREFIX
ENV WORDPRESS_DEBUG=$WORDPRESS_DEBUG

ENV NODE_ENV=dev