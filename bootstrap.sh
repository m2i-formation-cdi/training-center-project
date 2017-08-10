#!/usr/bin/env bash


PASSWORD='123'
PHPVERSION='70'



# update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

# memcached
apt-get install -y memcached

# apache et php 
sudo apt-get install -y apache2
sudo apt-get install -y php  
sudo apt-get install -y php-curl php-gd php-mcrypt php-zip php-xsl php-memcached php-xdebug
sudo apt-get install -y libapache2-mod-php

# mysql
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get install -y mysql-server
sudo apt-get install php-mysql

# phpmyadmin
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get install -y phpmyadmin

# virtual host
VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/vagrant_data/web-app/web"
    <Directory "/vagrant_data/web-app/web">
        Options All
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# xdebug
XDEBUG=$(cat <<EOF
[xdebug]
zend_extension="xdebug.so"
xdebug.remote_enable=on
xdebug.remote_connect_back=on
xdebug.idekey = "vagrant"
xdebug.remote_host=localhost
xdebug.remote_port=9000
xdebug.remote_handler="dbgp"
EOF
)
echo "${XDEBUG}" > /etc/php/7.0/apache2/conf.d/20-xdebug.ini


# réécriture d'url
sudo a2enmod rewrite

# lancement d'Apache
service apache2 restart

# Git
sudo apt-get -y install git

# Composer
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer