#!/bin/sh

# Start docker
dockerd </dev/null &>/dev/null &
PID=$!

DOCKER_HOST="unix:///var/run/docker.sock"

# Wait for boot
sleep 5

# Run command.
$@

# Shut down docker
sleep 1
kill $PID