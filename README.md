# Dockerised ThemeCheck.run

## Requirements
 - Debian VM
 - Docker
 - [Buildkit enabled in daemon.json](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds)

## To run & update
 - `docker build . -f ./dockerfiles/run -t runner`
 - `docker-compose up -d`

# Containers
## nginx

## db

## php

## manager

## jobs