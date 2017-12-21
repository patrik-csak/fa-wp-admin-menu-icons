.PHONY: clean test testCoverage

os = $(shell uname)
macOs = Darwin

clean:
	rm -rf vendor

test: vendor
	./vendor/bin/phpunit

testCoverage: vendor
	@./vendor/bin/phpunit --coverage-html tests/coverage
	@#  Open coverage report in the browser
	@ \
	if [ $(os) == $(macOs) ]; \
		then open tests/coverage/index.html; \
	fi

vendor:
	composer install
