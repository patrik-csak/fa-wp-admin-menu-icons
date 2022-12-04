composer = php composer.phar
linux = Linux
macOs = Darwin
os = $(shell uname)
phpunit = vendor/bin/phpunit

########################################################################
# Standard targets
# See https://www.gnu.org/software/make/manual/html_node/Standard-Targets.html
########################################################################

.PHONY : all
all: ;

.PHONY : clean
clean:
	@$(RM) cc-test-reporter
	@$(RM) clover.xml
	@$(RM) composer.phar
	@$(RM) -r vendor
	@$(RM) .phpunit.result.cache

########################################################################
# Phony targets
########################################################################

.PHONY : test
test : $(phpunit) ; $(phpunit) tests

.PHONY : test-coverage-code-climate
test-coverage-code-climate: cc-test-reporter clover.xml
	./cc-test-reporter before-build
	./cc-test-reporter after-build --coverage-input-type clover

# Xdebug must be enabled to generate coverage report
.PHONY : test-coverage-html
test-coverage-html: $(phpunit)
	XDEBUG_MODE=coverage $(phpunit) --coverage-html tests/coverage
	@#  Open coverage report in the browser
ifeq ($(os), $(macOs))
	open tests/coverage/index.html;
endif

########################################################################
# Real targets
########################################################################

cc-test-reporter:
ifeq ($(os), $(linux))
	@curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 > ./cc-test-reporter
else ifeq ($(os), $(macOs))
	@curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-darwin-amd64 > ./cc-test-reporter
else
	$(error Operating system '$(os)' not supported)
endif
	@chmod +x ./cc-test-reporter

clover.xml: $(phpunit) ; XDEBUG_MODE=coverage $(phpunit) --coverage-clover clover.xml

composer.phar:
	scripts/download-composer.sh

vendor/%: composer.phar ; $(composer) install

FORCE: ;
