#!/bin/bash

# make sure we're in the right working directory.
cd "$(dirname $(dirname "$0") )"

ID=$1
if [ -z "$ID" ]; then
	echo No hash provided?
	exit 1;
fi

echo Running $ID

DATAFOLDER=`pwd`/shared-data/$ID

mkdir -p "$DATAFOLDER/logs"

# Testing.
svn export --force https://themes.svn.wordpress.org/twentyten/3.3/ ./shared-data/$ID/test-theme

cd $DATAFOLDER

git clone -q https://github.com/WordPress/theme-review-action.git theme-review-action

cd $DATAFOLDER/theme-review-action

PORT=$( shuf -i 5000-65000 -n 1 )

npm install
# npm run start --skipFolderCopy --pathToTheme=../test-theme --port $PORT
node bin/program.js --skipFolderCopy --pathToTheme=../test-theme --port $PORT

cd $DATAFOLDER

mv $DATAFOLDER/theme-review-action/logs/* $DATAFOLDER/logs/
rm -rf $DATAFOLDER/theme-review-action
