#!/usr/bin/env sh
set -ev

mkdir --parents "${HOME}/bin"

# Ugly hack
echo "memory_limit=-1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini

composer install --no-interaction --prefer-dist
composer require --no-interaction --dev phpunit/phpunit 


php_ver=$(php -v |cut -f 2 -d ' ' |cut -f1-2 -d '.' | head -n 1)

if [ ${php_ver} == "5.6" ]
then
    wget http://codeception.com/php5/codecept.phar  --output-document="${HOME}/bin/codecept"
else
    wget http://codeception.com/codecept.phar  --output-document="${HOME}/bin/codecept"
fi

chmod u+x "${HOME}/bin/codecept"

# Coveralls client install
wget https://github.com/satooshi/php-coveralls/releases/download/v1.0.1/coveralls.phar --output-document="${HOME}/bin/coveralls"
chmod u+x "${HOME}/bin/coveralls"


# for selenium
sudo apt-get install xvfb
sudo apt-get install chromium-browser

# 2.12 for travis only, 2.29 for ubuntu desktop
wget http://chromedriver.storage.googleapis.com/2.12/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
mv chromedriver ${HOME}/bin/

composer require --no-interaction --dev se/selenium-server-standalone '^2.52'