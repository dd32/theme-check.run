# Dockerised ThemeCheck.run

## Requirements
 - Debian VM
 - User Namespacing enabled, se https://github.com/puppeteer/puppeteer/blob/main/docs/troubleshooting.md#recommended-enable-user-namespace-cloning
 - Chromium installed, to install the dependancies Chromium in puppeteer will require
 - Docker
 - Node v14, via nvm
 - PHP CLI with PDO support
 - Composer
 - SVN
 - GIT

## To run & update
 - `git clone https://github.com/dd32/theme-check.run .`
 - `cp .env.dist .env`
 - `composer install`
 - `docker-compose up -d`
 - `bin/migrations-development migrate`
 - `DATABASE_HOST=127.0.0.1 php bin/manager.php`
 - Visit `http://hostname/`

# Containers
## nginx
 The minimal web front end
## php
 The PHP execution container for the web front end
## db
 A database host used for communication between php and manager

# Bin Scripts
## manager.php
 A PHP script which monitors the runs requested, and runs a docker container for each requested run.
 Is responsible for creating a temporary directory of the theme files that will be mounted into the runner.
 This must be run on the host system. Can't be within a docker image.
## run-checks.sh
 The script responsible for booting up a check run.
 This script must be run on the host. can't be within a docker image.
