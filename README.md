# Dockerised ThemeCheck.run

## Requirements
 - Debian VM
 - Docker
 - Node v12+, via nvm?
 - PHP CLI with PDO support
 - SVN
 - GIT

## To run & update
 - `git clone https://github.com/dd32/theme-check.run .`
 - `docker-compose up -d`
 - `screen php bin/manager.php`
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