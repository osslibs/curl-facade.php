PHP=php
PHPUNIT=vendor/bin/phpunit
COMPOSER_PHAR=composer.phar

test: $(PHPUNIT)
	$(PHPUNIT) tests

$(COMPOSER_PHAR):
	$(PHP) -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	$(PHP) -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	$(PHP) composer-setup.php
	$(PHP) -r "unlink('composer-setup.php');"

$(PHPUNIT): $(COMPOSER_PHAR)
	$(PHP) $(COMPOSER_PHAR) install
