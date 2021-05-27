#!/bin/sh

# Start docker
dockerd </dev/null &>/dev/null &
PID=$!

DOCKER_HOST="unix:///var/run/docker.sock"

# Wait for boot
sleep 5

# Run command.
#$@
cd /theme-review-action
npm run start

# Shut down docker
sleep 1
kill $PID