#!/usr/bin/env bash

IMAGE_NAME=theme-check-run-php

docker run \
    --rm \
    -it \
    --init \
    -v "${PWD}":/app \
    -w /app \
    --env-file=.env.dist \
    --env-file=.env \
    --network=theme-check-run \
    "$IMAGE_NAME" \
        vendor/bin/phinx "$@"
