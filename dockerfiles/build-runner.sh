#!/bin/sh
# This is a dockerfile, but a script file.. because.. I could.. but also because..
# .. the build process needs to use `--privileged` which isn't available during `docker build`.

# make sure we're in the right working directory.
cd "$(dirname "$0")"

# Cleanup
docker kill runner_build_tmp
docker rm runner_build_tmp

# FROM docker:dind ... Boot a container
docker run -d --privileged --name runner_build_tmp --env DOCKER_HOST="unix:///var/run/docker.sock" docker:dind

# RUN ... Install deps.
docker exec runner_build_tmp apk update
docker exec runner_build_tmp apk add --no-cache docker-compose git subversion openssh-client nodejs npm curl

# COPY ... Override the image entrypoint with our own
docker cp run-entrypoint.sh runner_build_tmp:/usr/local/bin/dockerd-entrypoint.sh

# RUN ... cache the images needed by wp-env
docker exec runner_build_tmp docker pull mariadb
docker exec runner_build_tmp docker pull wordpress
docker exec runner_build_tmp docker pull wordpress:cli
docker exec runner_build_tmp docker pull composer
docker exec runner_build_tmp docker pull wordpressdevelop/phpunit:latest

# RUN ... cache the actions and deps.
docker exec runner_build_tmp git clone https://github.com/WordPress/theme-review-action.git /theme-review-action
docker exec -w /theme-review-action runner_build_tmp npm install

# Testing only.
docker exec runner_build_tmp svn export https://themes.svn.wordpress.org/twentyten/3.3/ /theme-review-action/test-theme

# Stop the container, tag it, cleanup.
docker stop runner_build_tmp
docker commit runner_build_tmp runner:latest
docker rm runner_build_tmp