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


# This script will generate the binary MO files from the PO files
# found in the po subdirectory.

cd po
echo -n "Generating MO files... "
for lang in *.po; do
    dir=../locale/${lang%.po}/LC_MESSAGES
    mkdir -p $dir
    msgfmt --output-file $dir/PEL.mo $lang    
done
echo "done."
cd ..
