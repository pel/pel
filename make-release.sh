#!/bin/sh
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
MINOR=2
VERSION=$MAJOR.$MINOR

if test -e pel-$VERSION; then
    echo "Removing old pel-$VERSION directory"
    rm -r pel-$VERSION
fi

echo -n "Retrieving CVS snapshot from SourceForge... "
cvs -Q -z3 export -kv -r HEAD -d pel-$VERSION pel
echo "done."

echo -n "Generating CVS ChangeLog... "
echo "ChangeLog file for PEL: PHP EXIF Library.  A library with support for
reading and writing all EXIF headers of JPEG images using PHP.

Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
Licensed under the GNU GPL, see COPYING for details.

" > pel-$VERSION/ChangeLog
cvs2cl --domain users.sourceforge.net --utc --stdout >> pel-$VERSION/ChangeLog
echo "done."


cd pel-$VERSION

rm make-release.sh .cvsignore

echo -n "Running phpDocumentor... "
../../phpdocumentor/phpdoc -q on -s on           \
    -o 'HTML:frames:earthli'                     \
    -ti "PEL: PHP EXIF Library Version $VERSION" \
    -ct 'date' -dn PEL                           \
    -f 'Pel*.php,README,INSTALL,NEWS,ChangeLog'  \
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

read -p "Tag CVS with 'release-${MAJOR}_${MINOR}' and upload files to SourceForge? [y/N] " -n 1
echo

if [ "x$REPLY" == "xy" -o "x$REPLY" == "xY" ]; then
    echo -n "Tagging CVS with 'release-${MAJOR}_${MINOR}'... "
    cvs -Q tag release-${MAJOR}_${MINOR}
    echo "done."
    
    echo -n "Uploading files to SourceForge for release... "
    ncftpput upload.sourceforge.net /incoming \
        pel-$VERSION.tar.gz \
        pel-$VERSION.tar.bz2 \
        pel-$VERSION.zip
    echo "done."

    echo -n "Uploading API documentation to SourceForge... "
    scp -C -q -r pel-$VERSION/doc \
        shell.sourceforge.net:/home/groups/p/pe/pel/htdocs
    echo "done."
else
    echo "Skipping tagging and upload."
fi
