#!/usr/bin/env bash

SOURCE_DIR=.
BUILD_DIR=tempzip
ZIP_FILE=smartvideo-woocommerce-plugin.zip

set -e

# First run all widget builders
./build-deploy-plugin.sh

mkdir -p $BUILD_DIR/smartvideo
rsync -avz --delete-excluded \
    --exclude='node_modules' \
    --exclude="$BUILD_DIR" \
    --exclude=".DS_Store" \
    --exclude='*.sh' \
    --exclude='*.zip' \
    --exclude='.tool-versions' \
    --exclude='pnpm-lock.yaml' \
    $SOURCE_DIR/* \
    $BUILD_DIR/smartvideo/

# Wipe existing zip file
[ -e $ZIP_FILE ] && rm $ZIP_FILE

# Make new zip file
cd $BUILD_DIR
zip -r ../$ZIP_FILE smartvideo
cd -

# Copy to plugin subversion trunk
# rsync -avz --del $BUILD_DIR/smartvideo/ SmartVideo/trunk/

# Clean up build dir
rm -r $BUILD_DIR

echo "Created ${ZIP_FILE}"

# pnpm plugin-zip