# Dockerised ThemeCheck.run

## Requirements
 - Debian VM
 - Docker
 - Node v12+, via nvm?
 - SVN
 - GIT
 - [Buildkit enabled in daemon.json](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds)

## To run & update
 - `git clone https://github.com/dd32/theme-check.run .`
 - `docker-compose up -d`
 - Visit `http://hostname/`

# Containers
## nginx
 The minimal web front end
## php
 The PHP execution container for the web front end
## db
 A database host used for communication between php and manager
## manager
 A PHP script which monitors the runs requested, and runs a docker container for each requested run.
 Is responsible for creating a temporary directory of the theme files that will be mounted into the runner.