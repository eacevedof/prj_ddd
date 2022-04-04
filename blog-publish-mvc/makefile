help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

remlogs: ## remove logs
	rm -fr ./logs/custom/*.log

server: ## dumpdb
	php -S localhost:2000 -t ./public
