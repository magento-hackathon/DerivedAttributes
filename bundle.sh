#!/usr/bin/env bash
################################################################################
#                                                                              #
# This script is used by Travis CI to create a downloadable build for each     #
# release with all dependencies, for manual installation.                      #
#                                                                              #
################################################################################

set -e
cd $WORKSPACE
RELEASE_DIR=hackathon-derivedattributes-${TRAVIS_TAG}
mkdir -p ${RELEASE_DIR}
cp -rf src/* ${RELEASE_DIR}/
cp -rf vendor/firegento/psr0autoloader/app ${RELEASE_DIR}/
cp -rf vendor/firegento/psr0autoloader/shell ${RELEASE_DIR}/
mkdir -p ${RELEASE_DIR}/lib/SGH/Comparable
cp -rf vendor/sgh/comparable/src/* ${RELEASE_DIR}/lib/SGH/Comparable/
zip -r hackathon-derivedattributes.zip ${RELEASE_DIR}
tar -czf hackathon-derivedattributes.tar.gz ${RELEASE_DIR}
printf "\x1b[32mBundled release ${TRAVIS_TAG}\x1b[0m"