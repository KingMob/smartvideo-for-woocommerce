#!/usr/bin/env bash

set -e
# set -x

SWARMIFY_PLUGIN_BASE='smartvideo-for-woocommerce'
SWARMIFY_PLUGIN_VERSION='2.1.0'

SOURCE_DIR=.
BUILD_DIR=tempzip
ZIP_FILE="${SWARMIFY_PLUGIN_BASE}-${SWARMIFY_PLUGIN_VERSION}.zip"


# First run all widget builders
./build-deploy-plugin.sh

mkdir -p $BUILD_DIR/$SWARMIFY_PLUGIN_BASE
rsync -avz --delete-excluded \
    --exclude='node_modules' \
    --exclude="$BUILD_DIR" \
    --exclude=".DS_Store" \
    --exclude='*.sh' \
    --exclude='*.zip' \
    --exclude='.tool-versions' \
    --exclude='pnpm-lock.yaml' \
    --include='vendor/autoload*' \
    --include='vendor/automattic/' \
    --include='vendor/composer/' \
    --include='vendor/jetpack-autoloader/' \
    --exclude='vendor/*' \
    --exclude='phpcs-report.xml' \
    $SOURCE_DIR/* \
    $BUILD_DIR/$SWARMIFY_PLUGIN_BASE/

# Wipe existing zip files
rm ./smartvideo-for-woocommerce*.zip

# Make new zip file
cd $BUILD_DIR
zip -r ../$ZIP_FILE $SWARMIFY_PLUGIN_BASE
echo "Created ${ZIP_FILE}"
cd -

cp $ZIP_FILE "${SWARMIFY_PLUGIN_BASE}.zip"
echo "Created ${SWARMIFY_PLUGIN_BASE}.zip"

# Copy to plugin subversion trunk
# rsync -avz --del $BUILD_DIR/smartvideo/ SmartVideo/trunk/

# Clean up build dir
rm -r $BUILD_DIR

echo "Created ${ZIP_FILE}"

# pnpm plugin-zip