#!/bin/sh
#
#  PEL: PHP Exif Library.  A library with support for reading and
#  writing all Exif headers of JPEG images using PHP.
#
#  Copyright (C) 2004, 2006  Martin Geisler
#
# For licensing, see LICENSE.md distributed with this source code.

# $Id$


# This small script simply runs phpDocumentor on the PEL sources.  It
# takes two optional arguments on the command line, the first of which
# should be a version number to include in the documentation.  The
# second argument should be the full path to the `phpdoc' script.

if [ -z $1 ]; then
    VERSION=""
else
    VERSION=" Version $1"
fi

if [ -z $2 ]; then
    PHPDOC="phpdoc"
else
    PHPDOC=$2
fi

# The ChangeLog file might not be here yet, but phpDocumentor fails if
# it is missing...
touch ChangeLog

echo "Running phpDocumentor... "
$PHPDOC                                                             \
    --sourcecode          "on"                                      \
    --title               "PEL: PHP Exif Library$VERSION"           \
    --customtags          "date"                                    \
    --defaultpackagename  "PEL"                                     \
    --directory           "tutorials"                               \
    --filename            "Pel*.php,README,INSTALL,NEWS,TODO,ChangeLog"  \
    --target              "doc"
