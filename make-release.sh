#!/bin/sh
#
#  PEL: PHP Exif Library.  A library with support for reading and
#  writing all Exif headers in JPEG and TIFF images using PHP.
#
#  Copyright (C) 2004, 2005, 2006  Martin Geisler.
#
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 2 of the License, or
#  (at your option) any later version.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program in the file COPYING; if not, write to the
#  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
#  Boston, MA 02110-1301 USA

# $Id$


# This small script retrieves the latest version of PEL, packs it up
# into two tarballs (gz and bz2) and a zip file, and then asks for
# permission to upload these files to SourceForge.  The generated
# files are placed in the current directory.


# Fix the locale to C, e.g. untranslated.
export LC_ALL=C


# Paths used below
BUILD_BASE="build-base.$$"
PHPDOC_PATH='phpdoc'



# Create the base directory for the build or bail out if it already
# exists
if [[ -d $BUILD_BASE ]]; then
    echo "The build directory $BUILD_BASE already exists!"
    exit
else
    echo "Building the release in $BUILD_BASE"
    mkdir $BUILD_BASE
fi

cd $BUILD_BASE


echo -n "Exporting trunk from SourceForge... "
svn export https://pel.svn.sourceforge.net/svnroot/pel/trunk pel || exit
echo "done."

# Grab version number from ChangeLog...
PREFIX='PEL Version'
MIDDLE='[0-9]+\.[0-9]+(\.[0-9]+(-[0-9a-z]+)?)?'
DATE=$(date -u '+%B %-d.. %Y')
REGEXP="$PREFIX $MIDDLE  $DATE"

OFFSET=$(grep -n -E -m 1 "$REGEXP" pel/NEWS | cut -d ':' -f 1)
if [[ -z $OFFSET ]]; then
    echo "Found no version from today in NEWS, creating SVN version."
    VERSION='svn' #$(date -u '+svn-%Y-%m-%d')
else
    echo "Offset: $OFFSET"
    VERSION=$(head -n $OFFSET pel/NEWS | tail -n 1 | cut -d ' ' -f 3)
    echo "Found match for today in NEWS: $VERSION."

    LINE=$(head -n $OFFSET pel/NEWS | tail -n 1)
    STARS=$(head -n $((OFFSET+1)) pel/NEWS | tail -n 1)
    if [[ ${#LINE} != ${#STARS} ]]; then
        echo "Aborting because of bad underlining:"
        echo
        echo "$LINE"
        echo "$STARS"
        exit
    fi
fi

mv pel pel-$VERSION

if [[ $VERSION == "svn" ]]; then
    echo "Skipping tagging since this is a SVN snapshot."
else
    read -p "Create SVN tag? [y/N] " -n 1
    echo

    if [[ $REPLY == "y" ]]; then
        echo -n "Creating SVN tag 'pel-$VERSION'... "
        svn copy \
            https://pel.svn.sourceforge.net/svnroot/pel/trunk \
            https://pel.svn.sourceforge.net/svnroot/pel/tags/pel-$VERSION \
            -m "Tagging PEL version $VERSION."
        echo "done."
    else
        echo "Skipping tagging by user request."
    fi
fi

cd pel-$VERSION

# Generate the ChangeLog, prefixed with a standard header
echo -n "Generating SVN ChangeLog... "
echo "ChangeLog file for PEL: PHP Exif Library.  A library with support for
reading and writing Exif headers in JPEG and TIFF images using PHP.

Copyright (C) 2004, 2005, 2006  Martin Geisler.
Licensed under the GNU GPL, see COPYING for details.

" > ChangeLog
svn2cl --include-rev --group-by-day --separate-daylogs  \
    --reparagraph --authors=authors.xml --stdout        \
    https://pel.svn.sourceforge.net/svnroot/pel/trunk/ >> ChangeLog || exit
echo "done."


#echo -n "Marking releases in ChangeLog... "
#sed -re '/./{H;$!d;};x;/tags/s|tags/pel-([0-9]+\.[0-9]+).*|PEL Version \1|'
#echo "done."


# Generate the binary MO files
./update-locales.sh


# Generate the API documentation
./run-phpdoc.sh $VERSION $PHPDOC_PATH


# Cleanup files that aren't needed in the released package
rm make-release.sh authors.xml
rm -r tutorials


# Add anchors and headers to the HTML ChangeLog so that each release
# notices can link back to it

#sed -i -re 's|^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}  tag release-([0-9])_([0-9])$|</pre>\n\n<div align="center"><h2 id="v\1.\2">PEL Version \1.\2</h2></div>\n\n<pre>\n|g' doc/ric_ChangeLog.html

# Leave the pel-$VERSION directory
cd ..

mv pel-$VERSION/test/image-tests image-tests

echo -n "Creating pel-image-tests-$VERSION.tar.gz... "
tar -cz image-tests -f pel-image-tests-$VERSION.tar.gz
echo "done."

echo -n "Creating pel-image-tests-$VERSION.tar.bz2... "
tar -cj image-tests -f pel-image-tests-$VERSION.tar.bz2
echo "done."

echo -n "Creating pel-images-$VERSION.zip... "
zip -qr pel-image-tests-$VERSION.zip image-tests
echo "done."

echo -n "Creating pel-$VERSION.tar.gz... "
tar -cz pel-$VERSION -f pel-$VERSION.tar.gz
echo "done."

echo -n "Creating pel-$VERSION.tar.bz2... "
tar -cj pel-$VERSION -f pel-$VERSION.tar.bz2
echo "done."

echo -n "Creating pel-$VERSION.zip... "
zip -qr pel-$VERSION.zip pel-$VERSION
echo "done."


# Upload the compressed files and API documentation, if allowed
if [[ $VERSION != "svn" && ( $REPLY == "y" || $REPLY == "Y" ) ]]; then
    echo -n "Uploading files to SourceForge for release... "
    ncftpput upload.sourceforge.net /incoming \
        pel-$VERSION.tar.gz                   \
        pel-$VERSION.tar.bz2                  \
        pel-$VERSION.zip                      \
        pel-image-tests-$VERSION.tar.gz       \
        pel-image-tests-$VERSION.tar.bz2      \
        pel-image-tests-$VERSION.zip
    echo "done."

    echo -n "Uploading API documentation to SourceForge... "
    scp -C -q -r pel-$VERSION/doc \
        shell.sourceforge.net:/home/groups/p/pe/pel/htdocs
    echo "done."
else
    echo "Skipping upload."
fi

echo "All done. The $BUILD_BASE directory can be removed at any time."

# The End --- PEL has now been packaged (and maybe even released)!
