#!/usr/bin/php5
<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program in the file COPYING; if not, write to the
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */

error_reporting(E_ALL);

/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');

require_once(dirname(__FILE__) . '/../PelDataWindow.php');
require_once(dirname(__FILE__) . '/../PelJpeg.php');
require_once(dirname(__FILE__) . '/../PelTiff.php');

$need = 2;
if ($argv[1] == '-d') {
  Pel::$debug = true;
  $need = 3;
}

if ($argc < $need) {
  printf("Usage: %s [-d] <filename>\n", $argv[0]);
  print("Optional arguments:\n");
  print("  -d        turn debug output on.\n");
  print("Mandatory arguments:\n");
  print("  filename  a JPEG or TIFF image.\n");
  exit(1);
}


/* We typically need lots of RAM to parse TIFF images since they tend
 * to be big and uncompressed. */
ini_set('memory_limit', '32M');

$data = new PelDataWindow(file_get_contents($argv[$need-1]));

if (PelJpeg::isValid($data)) {
  print(new PelJpeg($data));
} elseif (PelTiff::isValid($data)) {
  print(new PelTiff($data));
} else {
  print("Unrecognized image format! The first 16 bytes follow:\n");
  PelConvert::bytesToDump($data->getBytes(0, 16)); 
}

?>