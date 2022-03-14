.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

DC=docker-compose

shortcodes: ## Start containers to develop shortcodes
	${DC} up 

# see https://kinsta.com/blog/gutenberg-blocks/#:~:text=Create%20Block%20is%20an%20officially,by%20create%2Dreact%2Dapp.
blocks: ## Start containers to develop blocks
	${DC} --profile frontend up

build-block: ## Build CSS and JS for a block
	${DC} run --rm node  sh -c "cd movie-list-block && npm install && npm run build"

new-block: ## Adds a new block: make new-block name=movie-detail
	${DC} run --rm node npx @wordpress/create-block --namespace "movie-plugin" --title "Movie List" --category "widgets" ${name}

down: ## Stop all containers
	${DC} down
