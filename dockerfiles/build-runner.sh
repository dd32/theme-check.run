#!/bin/sh
# This is a dockerfile, but a script file.. because.. I could.. but also because..
# .. the build process needs to use `--privileged` which isn't available during `docker build`.

# make sure we're in the right working directory.
cd "$(dirname "$0")"

# Cleanup any previous attempts.
docker kill runner_build_tmp
docker rm runner_build_tmp

# FROM ... Build the base image
docker build . -f runner_base -t runner

# ... Boot a container
docker run -d --privileged --name runner_build_tmp runner_base

# RUN ... Install deps.
docker exec runner_build_tmp apk update
docker exec runner_build_tmp apk add --no-cache docker-compose git subversion openssh-client nodejs npm curl

# RUN ... cache the actions and deps.
docker exec runner_build_tmp git clone https://github.com/WordPress/theme-review-action.git /theme-review-action
docker exec -w /theme-review-action runner_build_tmp npm install

# RUN ... Boot wp-env up to cache the docker images
# This also doesn't work.. the image is no longer containing it afterwards.
# docker exec -w /theme-review-action runner_build_tmp npm run wp-env start
# docker exec -w /theme-review-action runner_build_tmp npm run wp-env stop
# docker exec -w /theme-review-action runner_build_tmp npm run wp-env clean

# Testing only.
docker exec runner_build_tmp svn export https://themes.svn.wordpress.org/twentyten/3.3/ /theme-review-action/test-theme

docker exec runner_build_tmp sh -c 'date>/.builddate'

# COPY ... Override the image entrypoint with our own
docker cp run-entrypoint.sh runner_build_tmp:/usr/local/bin/dockerd-entrypoint.sh

# Stop the container, tag it, cleanup.
docker stop runner_build_tmp
docker commit runner_build_tmp runner:latest
docker rm runner_build_tmp
