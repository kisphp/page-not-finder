.PHONY: it i t f

COMPOSER=`which composer`
PHP=`which php`

it: i t

i:
	$(COMPOSER) install --prefer-dist

t:
	$(PHP) vendor/bin/phpunit
	$(PHP) vendor/bin/php-cs-fixer fix -v --dry-run

f:
	$(PHP) vendor/bin/php-cs-fixer fix -v
