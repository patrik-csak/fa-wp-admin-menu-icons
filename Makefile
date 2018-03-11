.PHONY: clean test testCoverage

composer = php composer.phar
macOs = Darwin
os = $(shell uname)
phpunit = vendor/bin/phpunit

all:
	@echo '`make test` to run tests'
	@echo '`make testCoverage` to run tests and generate coverage report'

clean:
	rm -f composer.phar
	rm -rf vendor

composer.phar:
	@php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	@php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	@php composer-setup.php
	@php -r "unlink('composer-setup.php');"

test: vendor
	@$(phpunit)

testCoverage: vendor
	-@$(phpunit) --coverage-html tests/coverage
	@#  Open coverage report in the browser
	@ \
	if [ $(os) == $(macOs) ]; \
		then open tests/coverage/index.html; \
	fi

vendor: composer.phar
	@$(composer) install
