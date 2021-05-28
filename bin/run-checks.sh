#!/bin/bash

# make sure we're in the right working directory.
cd "$(dirname $(dirname "$0") )"

ID=$1
if [ -z "$ID" ]; then
	echo No hash provided?
	exit 1;
fi

echo Running $ID

mkdir -p ./shared-data/$ID/logs

# Testing.
svn export --force https://themes.svn.wordpress.org/twentyten/3.3/ ./shared-data/$ID/test-theme

docker run \
	--rm -ti \
	-v /var/run/docker.sock:/var/run/docker.sock \
	-v `pwd`/shared-data/:`pwd`/shared-data/ \
	-v `pwd`/shared-data/.npm:$HOME/.npm \
	-v $HOME/.wp-env:$HOME/.wp-env \
	runner `pwd` $ID $HOME

echo FIN