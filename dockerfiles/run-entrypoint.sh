#!/bin/sh
DATAFOLDER="$1/shared-data/$2"
ID=$2
HOME=$3

echo RUN ID: $ID

if [ ! -d "$DATAFOLDER" ]; then
	echo Data folder doesn\'t exist: $DATAFOLDER
	sh
	exit 1;
fi

cd $DATAFOLDER

git clone -q https://github.com/WordPress/theme-review-action.git theme-review-action

cd theme-review-action

# `npm run start ` isn't working with check:structure
cp ../test-theme . -R

PORT=$( shuf -i 5000-65000 -n 1 )

npm install
# npm run start --skipFolderCopy --pathToTheme=../test-theme --port $PORT
node bin/program.js --skipFolderCopy --pathToTheme=../test-theme --port $PORT

cd $DATAFOLDER

mv ./theme-review-action/logs/* ./logs/
rm -rf ./theme-review-action