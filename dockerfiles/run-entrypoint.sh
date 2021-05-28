#!/bin/sh

echo Image built: `cat /.builddate`

# Start docker
dockerd </dev/null &>/dev/null &
PID=$!

# Wait for boot
sleep 5

# Run it.
cd /theme-review-action
npm run start

# Shut down docker
sleep 1
kill $PID