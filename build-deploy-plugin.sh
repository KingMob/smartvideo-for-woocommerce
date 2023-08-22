#!/usr/bin/env bash

set -e

INCLUDES_DIR='includes'

GUTENBERG_DIR='page-builders/gutenberg'
# GUTENBERG_BUILD='pnpm install; pnpm run build;'

DIVI_DIR='page-builders/divi-builder'
# DIVI_BUILD='pnpm install; SKIP_PREFLIGHT_CHECK=true pnpm run build;' 


START_DIR=$(pwd)

echo "Build starting..."
pnpm run build

# Generate optimized autoloader
composer --no-dev -o --strict-psr dump-autoload

cd $INCLUDES_DIR
CWD=$(pwd)

echo "Gutenberg Build..."
cd $GUTENBERG_DIR
pnpm install; 
pnpm run build;

echo "Divi Build..."
cd $CWD
cd $DIVI_DIR
pnpm install; 
# SKIP_PREFLIGHT_CHECK=true is needed for the build to work, since divi-scripts 
# depends on a super-old, uninstallable eslint
SKIP_PREFLIGHT_CHECK=true pnpm run build;


cd $START_DIR
echo "Build done!"