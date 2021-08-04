#!/bin/bash

# Make sure we're in the right working directory.
cd "$(dirname "$(dirname "$0")")" || exit

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

DATA_DIR="$(pwd)/shared-data/$ID"

function cleanup() {
	rm -rf $DATA_DIR/theme-review-action
	# Docker cleanup?
}
trap cleanup EXIT

mkdir -p "$DATA_DIR/logs"

# Testing.
svn export --force --quiet $SVN ./shared-data/$ID/test-theme

cd $DATA_DIR

git clone -q https://github.com/WordPress/theme-review-action.git theme-review-action

cd $DATA_DIR/theme-review-action

git pull
git checkout run_themechecks_against_theme

PORT=$( shuf -i 5000-65000 -n 1 )

npm install 2>&1 1>/dev/null
# npm run start --skipFolderCopy --pathToTheme=../test-theme --port $PORT
node bin/program.js --skipFolderCopy --pathToTheme=../test-theme --port $PORT

# Move logs
mv $DATA_DIR/theme-review-action/logs/* $DATA_DIR/logs/

ls $DATA_DIR/logs/* | xargs -I% sh -c 'echo ***`basename %`***: && cat %'
