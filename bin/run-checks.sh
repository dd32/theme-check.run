#!/bin/bash

# make sure we're in the right working directory.
cd "$(dirname $(dirname "$0") )"

ID=$1
if [ -z "$ID" ]; then
	echo No hash provided?
	exit 1;
fi
SVN=$2
if [ -z "$SVN" ]; then
	echo No SVN directory provided
fi

function cleanup() {
	rm -rf $DATAFOLDER/theme-review-action
	# Docker cleanup?
}
trap cleanup EXIT

echo Running job $ID
echo Testing against $SVN

DATAFOLDER=`pwd`/shared-data/$ID

mkdir -p "$DATAFOLDER/logs"

# Testing.
svn export --force --quiet $SVN ./shared-data/$ID/test-theme

cd $DATAFOLDER

git clone -q https://github.com/WordPress/theme-review-action.git theme-review-action

cd $DATAFOLDER/theme-review-action

PORT=$( shuf -i 5000-65000 -n 1 )

npm install 2>&1 1>/dev/null
# npm run start --skipFolderCopy --pathToTheme=../test-theme --port $PORT
node bin/program.js --skipFolderCopy --pathToTheme=../test-theme --port $PORT

# Move logs
mv $DATAFOLDER/theme-review-action/logs/* $DATAFOLDER/logs/

cat $DATAFOLDER/logs/*