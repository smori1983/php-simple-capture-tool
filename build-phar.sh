#!/usr/bin/env bash
set -Ceu

file_dir=$(cd $(dirname $0);pwd)

cd ${file_dir}

mkdir -p build

if [ ! -f box.phar ]; then
    wget https://github.com/box-project/box2/releases/download/2.7.5/box-2.7.5.phar -O box.phar
fi

php box.phar build
