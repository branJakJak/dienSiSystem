#!/usr/bin/env bash

apt-get update

apt-get install -y apache2
# Remove /var/www default
rm -rf /var/www
# Symlink /vagrant to /var/www
ln -fs /vagrant /var/www
# Add ServerName to httpd.conf
echo "ServerName localhost" > /etc/apache2/httpd.conf
# Setup hosts file
VHOST=$(cat <<EOF
<VirtualHost *:80>
  DocumentRoot "/vagrant/public"
  ServerName localhost
  <Directory "/vagrant/public">
    AllowOverride All
  </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-enabled/000-default
# Enable mod_rewrite
a2enmod rewrite
# Restart apache
service apache2 restart




apt-get install -y libapache2-mod-php5
apt-get install -y python-software-properties
add-apt-repository ppa:ondrej/php5
apt-get update



# Need sudo to run the following, adding root password as "florence"
sudo passwd
florence
sudo
florence
apt-get install -y php5-cli
apt-get install -y php5-mysql
apt-get install -y php5-curl
apt-get install -y php5-mcrypt


apt-get install -y curl


export DEBIAN_FRONTEND=noninteractive
apt-get -q -y install mysql-server-5.5


apt-get install git-core


echo "CREATE DATABASE IF NOT EXISTS dncsyste_dnc" | mysql
echo "CREATE USER 'dnc'@'localhost' IDENTIFIED BY ''" | mysql
echo "GRANT ALL PRIVILEGES ON dncsyste_dnc.* TO 'dnc'@'localhost' IDENTIFIED BY 'dnc' " | mysql
# run migration
cd /var/www/
yiic migrate --interactive=0
# give write permission to some directories
sudo chmod -R 777 /var/www/assets/
sudo chmod -R 777 /var/www/protected/runtime/