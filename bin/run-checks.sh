#!/bin/bash

# Bail when an error occurs
set -e

# Make sure we're in the right working directory.
cd "$(dirname "$(dirname "$0")")"

ID=$1
if [ -z "$ID" ]; then
  echo No hash provided
  exit 1
fi
SVN=$2
if [ -z "$SVN" ]; then
  echo No SVN directory provided
  exit 1
fi

echo "Running job $ID"
echo "Testing against $SVN"

# Prepare and enter working directory.
WORKING_DIR="$(pwd)/shared-data/$ID"
mkdir -p "$WORKING_DIR"
cd "$WORKING_DIR"

function cleanup() {
  echo "Cleaning up"
  # Really make sure wp-env is destroyed.
  # theme-review-action should destroy it, but in case of error, it might not.
  npm run wp-env destroy
  echo "Cleanup done"
}
trap cleanup EXIT

# Checkout theme under test, and theme-review-action.
svn export --force --quiet "$SVN" test-theme
git clone -q https://github.com/WordPress/theme-review-action.git theme-review-action

cd "$WORKING_DIR/theme-review-action"

# Install theme-review-action dependencies.
rm package-lock.json actions/ui-check/package-lock.json
{ npm install >/dev/null; } 2>&1

# Run theme-review-action.
PORT=$(shuf -i 5000-65000 -n 1)
node bin/program.js --skipFolderCopy --pathToTheme=../test-theme --port "$PORT"
