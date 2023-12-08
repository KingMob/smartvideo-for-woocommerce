#!/usr/bin/env bash

# This moves the code into the SVN trunk directory, and builds the plugin zip file

set -e
# set -x

SWARMIFY_PLUGIN_BASE='smartvideo-for-woocommerce'
SWARMIFY_PLUGIN_VERSION='2.1.0'

SOURCE_DIR=.
BUILD_DIR=temp
ZIP_FILE="${SWARMIFY_PLUGIN_BASE}-${SWARMIFY_PLUGIN_VERSION}.zip"


mkdir -p $BUILD_DIR/$SWARMIFY_PLUGIN_BASE
rsync -avz --delete-excluded \
    --exclude='node_modules' \
    --exclude="$BUILD_DIR" \
    --exclude=".DS_Store" \
    --exclude='*.sh' \
    --exclude='*.zip' \
    --exclude='.tool-versions' \
    --exclude='pnpm-lock.yaml' \
    --exclude='README-developers.md' \
    --exclude='SmartVideo/' \
    --include='vendor/autoload*' \
    --include='vendor/automattic/' \
    --include='vendor/composer/' \
    --include='vendor/jetpack-autoloader/' \
    --exclude='vendor/*' \
    --exclude='phpcs-report.xml' \
    --exclude='webpack.config.js' \
    $SOURCE_DIR/* \
    $BUILD_DIR/$SWARMIFY_PLUGIN_BASE/

# Wipe existing zip files
rm -f "./${SWARMIFY_PLUGIN_BASE}*.zip"

# Make new zip file
cd $BUILD_DIR
zip -r ../$ZIP_FILE $SWARMIFY_PLUGIN_BASE
echo "Created ${ZIP_FILE}"
cd -

cp $ZIP_FILE "${SWARMIFY_PLUGIN_BASE}.zip"
echo "Created ${SWARMIFY_PLUGIN_BASE}.zip"

# Copy to plugin subversion trunk
mkdir -p SmartVideo/trunk
rsync -avz --del $BUILD_DIR/$SWARMIFY_PLUGIN_BASE/ SmartVideo/trunk/
echo "Synced to SVN trunk"

# Clean up build dir
rm -r $BUILD_DIR
