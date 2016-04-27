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


# This small script will update the pel.pot template file in the po
# directory so that it contains the all the strings used in PEL.

echo -n Extracting translatable strings...
xgettext --output=po/pel.pot \
    --keyword=tra            \
    --keyword=fmt            \
    --flag=fmt:1:php-format  \
    Pel*.php
echo done.

for po in po/*.po; do
    echo -n Updating $po:
    msgmerge -v -U $po po/pel.pot
done
