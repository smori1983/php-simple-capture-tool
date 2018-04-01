#!/usr/bin/env bash
set -Ceu

setup_directory="${HOME}/webdriver"

mkdir -p ${setup_directory}

wget https://chromedriver.storage.googleapis.com/2.37/chromedriver_linux64.zip --directory-prefix=${setup_directory}

unzip ${setup_directory}/chromedriver_linux64.zip -d ${setup_directory}

rm ${setup_directory}/chromedriver_linux64.zip

${setup_directory}/chromedriver &
