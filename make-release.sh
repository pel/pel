#!/bin/bash
#
#  PEL: PHP EXIF Library.  A library with support for reading and
#  writing all EXIF headers of JPEG images using PHP.
#
#  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
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
#  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
#  Boston, MA 02111-1307 USA

# $Id$


# This small script retrieves the latest version of PEL, packs it up
# into two tarballs (gz and bz2) and a zip file, and then asks for
# permission to upload these files to SourceForge.  The files are
# placed in the current directory.

MAJOR=0
MINOR=1
VERSION=$MAJOR.$MINOR

echo -n "Retrieving CVS snapshot from SourceForge... "
cvs -Q -z3 export -kv -r HEAD -d pel-$VERSION pel
echo "done."

cd pel-$VERSION

rm make-release.sh

echo -n "Running phpDocumentor... "
../../phpdocumentor/phpdoc -q on -s on \
    -dn PEL                            \
    -ti 'PEL: PHP EXIF Library'        \
    -f '*.php'                         \
    -t doc
echo "done."

cd ..

echo -n "Creating pel-$VERSION.tar.gz... "
tar -cz pel-$VERSION -f pel-$VERSION.tar.gz
echo "done."

echo -n "Creating pel-$VERSION.tar.bz2... "
tar -cj pel-$VERSION -f pel-$VERSION.tar.bz2
echo "done."

echo -n "Creating pel-$VERSION.zip... "
zip -qr pel-$VERSION.zip pel-$VERSION
echo "done."

echo "Tag CVS with 'release-${MAJOR}_${MINOR}' and"
read -p "upload files to SourceForge? [y/N] " -n 1
echo

if [ "x$REPLY" == "xy" -o "x$REPLY" == "xY" ]; then
    echo -n "Tagging CVS with 'release-${MAJOR}_${MINOR}'... "
    cvs -Q tag release-${MAJOR}_${MINOR}
    echo "done."

    echo -n "Uploading files to SourceForge... "
    ncftpput upload.sourceforge.net /incoming \
	pel-$VERSION.tar.gz \
	pel-$VERSION.tar.bz2 \
	pel-$VERSION.zip
    echo "done."
else
    echo "Skipping tagging and upload."
fi
