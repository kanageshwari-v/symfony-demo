FROM gitpod/workspace-mysql

USER root

SHELL ["/bin/bash", "-c"]

# Install other needed packages
RUN add-apt-repository -y ppa:ondrej/php
RUN sudo apt update -y
RUN sudo apt upgrade -y
RUN sudo apt install -y php-mysql curl php-curl php-gd php-mbstring php-pear php-apcu php-json php-xdebug build-essential sendmail
RUN pecl install apcu
RUN pecl install uploadprogress

# Install latest composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir /usr/bin --filename composer
RUN php -r "unlink('composer-setup.php');"

# Expose Apache and MySQL
EXPOSE 80
EXPOSE 443
EXPOSE 3306
