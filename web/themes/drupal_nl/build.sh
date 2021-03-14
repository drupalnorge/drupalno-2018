#!/bin/bash

# This scripts purpose is to generate all the necessary for the project to successfully run
# e.g. scss -> css, js -> minifiy/transpilation, composer install, etc.

# Function for error catching.
# @see http://linuxcommand.org/lc3_wss0140.php
error_exit () {
  echo "$1" 1>&2
  exit 1
}

# Path of this script.
scriptPath=$(dirname $0)
pushd $scriptPath || exit 1

# Run nvm version check
if [ -f $HOME/.nvm/nvm.sh ]; then
  source $HOME/.nvm/nvm.sh
fi

# Get the required node version from .nvmrc
required_node_version=$(<.nvmrc)

# Enforce the version
nvm use $required_node_version || (nvm install $required_node_version && nvm use $required_node_version || error_exit "nvm failed.")

echo "Create theme"

# npm install
npm ci || error_exit "Npm install failed."

# Build project theme.
npm run build || error_exit "Npm task build failed."

popd
