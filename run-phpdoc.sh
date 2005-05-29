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


# This small script simply runs phpDocumentor on the PEL sources.  It
# takes two optional arguments on the command line, the first of which
# should be a version number to include in the documentation.  The
# second argument should be the full path to the `phpdoc' script.

if [[ -z $1 ]]; then
    VERSION=""
else
    VERSION=" Version $1"
fi

if [[ -z $2 ]]; then
    PHPDOC="../phpdocumentor/phpdoc"
else
    PHPDOC=$2
fi    

echo -n "Running phpDocumentor... "
$PHPDOC                                                             \
    --quiet               "on"                                      \
    --sourcecode          "on"                                      \
    --title               "PEL: PHP EXIF Library$VERSION"           \
    --output              "HTML:frames:earthli"                     \
    --customtags          "date"                                    \
    --defaultpackagename  "PEL"                                     \
    --directory           "tutorials"                               \
    --filename            "Pel*.php,README,INSTALL,NEWS,ChangeLog"  \
    --target              "doc"
echo "done."
