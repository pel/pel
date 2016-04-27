#!/bin/sh
#
#  PEL: PHP Exif Library.  A library with support for reading and
#  writing all Exif headers in JPEG and TIFF images using PHP.
#
#  Copyright (C) 2004  Martin Geisler.
#
# Dual licensed. For the full copyright and license information, please view
# the COPYING.MIT and COPYING.GPL files that are distributed with this source code.

# $Id$


# This script will generate the binary MO files from the PO files
# found in the po subdirectory.

cd po
echo -n "Generating MO files... "
for lang in *.po; do
    dir=../locale/${lang%.po}/LC_MESSAGES
    mkdir -p $dir
    msgfmt --output-file $dir/pel.mo $lang
done
echo "done."
cd ..
