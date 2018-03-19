.PHONY: ccReportCoverage clean test testCoverageHtml

composer = php composer.phar
linux = Linux
macOs = Darwin
os = $(shell uname)
phpunit = vendor/bin/phpunit

all:
	$(info Usage:)
	$(info `make ccReportCoverage` to send test coverage report to Code Climate)
	$(info `make test` to run tests)
	$(info `make testCoverageHtml` to run tests and generate coverage report (and open the report if on macOs))

ccReportCoverage: cc-test-reporter
	@./cc-test-reporter before-build
	@make clover.xml
	@./cc-test-reporter after-build --coverage-input-type clover

cc-test-reporter:
ifeq ($(os), $(linux))
	@curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 > ./cc-test-reporter
else ifeq ($(os), $(macOs))
	@curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-darwin-amd64 > ./cc-test-reporter
else
	$(error Operating system '$(os)' not supported)
endif
	@chmod +x ./cc-test-reporter

clean:
	rm -f cc-test-reporter
	rm -f clover.xml
	rm -f composer.phar
	rm -rf vendor

clover.xml: vendor
	@$(phpunit) --coverage-clover clover.xml

composer.phar:
	@php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	@php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	@php composer-setup.php
	@php -r "unlink('composer-setup.php');"

test: vendor
	@$(phpunit)

# Xdebug must be enabled to generate coverage report
testCoverageHtml: vendor
	-@$(phpunit) --coverage-html tests/coverage
	@#  Open coverage report in the browser
ifeq ($(os), $(macOs))
	open tests/coverage/index.html;
endif

vendor: composer.phar
	@$(composer) install
