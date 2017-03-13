FROM ubuntu:latest

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get -y install git apache2 php php-cli curl php-curl php-mbstring vim supervisor libapache2-mod-php php-mysql php-mcrypt
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/www/html/index.html

RUN a2enmod rewrite
RUN a2enmod php7.0

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

ADD . /var/www/
ADD supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD slim-apache.conf /etc/apache2/sites-available/000-default.conf
RUN cd /var/www && composer install

RUN echo "ServerName avidbrain" >> /etc/apache2/apache2.conf

EXPOSE 80
CMD ["/usr/bin/supervisord"]

