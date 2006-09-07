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

# Next go to the following sites and update the release information:

# http://freshmeat.net/projects/pel
# http://onlyphp.com/detail-1511.html
# http://hotscripts.com/Detailed/35006.html
# http://php-resource.de/scripte/show/5686/
# http://scriptsearch.com/details/11255.html
# http://needscripts.com/Resource/27087.html
# http://php.resourceindex.com/detail/04003.html
# http://script.dk/sourcecode.jsp?resourceId=1227
# http://coding.phpground.net/download-mod-707.html
# http://scripts.com/php-scripts/image-manipulation-scripts/pel-php-exif-library


# Grab version number from ChangeLog...
PREFIX='PEL Version'
MIDDLE='[0-9]+\.[0-9]+(\.[0-9]+(-[0-9a-z]+)?)?'
DATE=$(date -u '+%B %-d.. %Y')
REGEXP="$PREFIX $MIDDLE  $DATE"

if OFFSET=$(grep -n -E -m 1 "$REGEXP" NEWS | cut -d ':' -f 1); then
    VERSION=$(head -n $OFFSET NEWS | tail -n 1 | cut -d ' ' -f 3)
    echo "Found match for today in NEWS: $VERSION."

    LINE=$(head -n $OFFSET NEWS | tail -n 1)
    STARS=$(head -n $((OFFSET+1)) NEWS | tail -n 1)
    if [ ${#LINE} != ${#STARS} ]; then
        echo "Aborting because of bad underlining:"
        echo
        echo "$LINE"
        echo "$STARS"
        exit
    fi
else
    echo "Found no version from today in NEWS, creating SVN version."
    VERSION='svn' #$(date -u '+svn-%Y-%m-%d')
fi

exit

# Determine if this is the final run or just a trial
read -p "Create SVN tag and upload files to SourceForge? [y/N] " -n 1
echo

if [ $REPLY == "y" -a $VERSION != "svn" ]; then
    SVN_URL="tags/$VERSION"
else
    SVN_URL="trunk"
fi

# Remove old directories, if present
if test -e pel-$VERSION; then
    echo "Removing old pel-$VERSION directory and files"
    rm -r pel-$VERSION pel-$VERSION.{tar.bz2,tar.gz,zip}
fi

if test -e image-tests; then
    echo "Removing old pel-image-tests directory and files"
    rm -r image-tests pel-image-tests-$VERSION.{tar.bz2,tar.gz,zip}
fi


if [ $VERSION != 'svn' ]; then
    if [ $SVN_URL != "trunk" ]; then
        echo -n "Creating SVN tag 'pel-$VERSION'... "
        svn copy https://svn.sourceforge.net/svnroot/pel/trunk \
                 https://svn.sourceforge.net/svnroot/pel/$SVN_URL \
            -m "Tagging PEL version $VERSION."
        echo "done."
    else
        echo "Skipping tagging."
    fi
else
    echo "Skipping tagging since this is a SVN snapshot."
fi

echo -n "Exporting $SVN_URL from SourceForge into pel-$VERSION... "
svn export https://svn.sourceforge.net/svnroot/pel/$SVN_URL pel-$VERSION || exit
# Export with Windows line endings for zip files
#svn export https://svn.sourceforge.net/svnroot/pel/$SVN_URL pel-$VERSION


cd pel-$VERSION

# Generate the ChangeLog, prefixed with a standard header
echo -n "Generating SVN ChangeLog... "
echo "ChangeLog file for PEL: PHP Exif Library.  A library with support for
reading and writing Exif headers in JPEG and TIFF images using PHP.

Copyright (C) 2004, 2005, 2006  Martin Geisler.
Licensed under the GNU GPL, see COPYING for details.

" > ChangeLog || exit
svn2cl \
    --include-rev \
    --group-by-day \
    --separate-daylogs \
    --reparagraph \
    --authors=authors.xml \
    --stdout \
    --strip-prefix=trunk/
    https://svn.sourceforge.net/svnroot/pel/ >> ChangeLog
echo "done."

#echo -n "Marking releases in ChangeLog... "
#sed -re '/./{H;$!d;};x;/tags/s|tags/pel-([0-9]+\.[0-9]+).*|PEL Version \1|'
#echo "done."


# Generate the binary MO files
./update-locales.sh


# Generate the API documentation
./run-phpdoc.sh $VERSION '../../../PhpDocumentor/phpdoc'


# Cleanup files that aren't needed in the released package
rm make-release.sh users
rm -r tutorials


# Add anchors and headers to the HTML ChangeLog so that each release
# notices can link back to it

#sed -i -re 's|^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}  tag release-([0-9])_([0-9])$|</pre>\n\n<div align="center"><h2 id="v\1.\2">PEL Version \1.\2</h2></div>\n\n<pre>\n|g' doc/ric_ChangeLog.html

# Leave the package directory
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
if [ $REPLY == "y" -o $REPLY == "Y" ]; then
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

# The End --- PEL has now been packaged (and maybe even released)!
