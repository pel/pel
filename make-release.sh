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
# permission to upload these files to SourceForge.  The generated
# files are placed in the current directory.

# Next go to the following sites and update the release information:

# http://freshmeat.net/projects/pel
# http://onlyphp.com/detail-1511.html
# http://hotscripts.com/Detailed/35006.html
# http://php-resource.de/scripte/show/5686/
# http://script.dk/sourcecode.jsp?resourceId=1227
# http://coding.phpground.net/download-mod-707.html
# http://www.scripts.com/php/image-manipulation/pel-php-exif-library

# http://phpfreaks.com/ (not yet listed)
# http://php.resourceindex.com/ (not yet listed)

MAJOR=0
MINOR=4
VERSION=$MAJOR.$MINOR

# Remove old directory, if present
if test -e pel-$VERSION; then
    echo "Removing old pel-$VERSION directory"
    rm -r pel-$VERSION       \
        pel-$VERSION.tar.bz2 \
        pel-$VERSION.tar.gz  \
        pel-$VERSION.zip
fi

# Determine if this is the final run or just a trial
read -p "Tag CVS with 'release-${MAJOR}_${MINOR}' and upload files to SourceForge? [y/N] " -n 1
echo

# Do the tagging of CVS
if [ "$REPLY" == "y" -o "$REPLY" == "Y" ]; then
    echo -n "Tagging CVS with 'release-${MAJOR}_${MINOR}'... "
    cvs -Q tag release-${MAJOR}_${MINOR}
    echo "done."
else
    echo "Skipping tagging."
fi


echo -n "Retrieving CVS snapshot from SourceForge... "
cvs -Q -z3 export -kv -r HEAD -d pel-$VERSION pel
echo "done."

# Generate the ChangeLog, prefixed with a standard header
echo -n "Generating CVS ChangeLog... "
echo "ChangeLog file for PEL: PHP EXIF Library.  A library with support for
reading and writing all EXIF headers of JPEG images using PHP.

Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
Licensed under the GNU GPL, see COPYING for details.

" > pel-$VERSION/ChangeLog
cvs2cl --global-opts -q            \
    --tagdates                     \
    --domain users.sourceforge.net \
    --utc                          \
    --stdout >> pel-$VERSION/ChangeLog
echo "done."


cd pel-$VERSION

# Generate the binary MO files
./update-locales.sh

# Cleanup files that aren't needed in the released package
rm make-release.sh .cvsignore

# Generate the API documentation
echo -n "Running phpDocumentor... "
../../phpdocumentor/phpdoc -q on -s on           \
    -o 'HTML:frames:earthli'                     \
    -ti "PEL: PHP EXIF Library Version $VERSION" \
    -ct 'date' -dn PEL                           \
    -f 'Pel*.php,README,INSTALL,NEWS,ChangeLog'  \
    -t doc
echo "done."

# Add anchors and headers to the HTML ChangeLog so that each release
# notices can link back to it
perl -p -i -e 's|^\d{4}-\d\d-\d\d \d\d:\d\d  tag release-(\d)_(\d)$|</pre>\n\n<div align="center"><h2><a id="v\2.\3"></a>PEL Version \2.\3</h2></div>\n<pre>\n|' doc/ric_ChangeLog.html

# Leave the package directory
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


# Upload the compressed files and API documentation, if allowed
if [ "$REPLY" == "y" -o "$REPLY" == "Y" ]; then
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
    echo "Skipping upload."
fi

# The End --- PEL has now been packaged!
