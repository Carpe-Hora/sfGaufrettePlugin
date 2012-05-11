#!/usr/bin/env bash

if [ -z $SYMFONY_VERSION ] ; then
SYMFONY_VERSION="symfony-1.4.17"
fi

git submodule update --init

if [ ! -f "$SYMFONY_VERSION.tgz" ] ; then
wget "http://www.symfony-project.org/get/$SYMFONY_VERSION.tgz"
fi

tar xvf "$SYMFONY_VERSION.tgz"
rm "$SYMFONY_VERSION.tgz"

mkdir -p lib/vendor/
mv "$SYMFONY_VERSION" lib/vendor/symfony
