# Dockerised ThemeCheck.run

## Requirements
 - Debian VM
 - Docker
 - [Buildkit enabled in daemon.json](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds)

## To run & update
 - `git clone https://github.com/dd32/theme-check.run`
 - `dockerfiles/build-runner.sh`
 - `docker-compose up -d`
 - Visit `http://hostname/`

## To run a test against the theme
`docker run --rm --privileged -v /whatever/logs:/theme-review-action/logs/ -v /whatever/theme:/theme-review-action/test-theme/ runner`

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

## runner
 An image which runs an instance of a theme check on it's input.
 These are queued up by the manager in response to web requests.