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

/* a printf() variant that appends a newline to the output. */
function println(/* fmt, args... */) {
    $args = func_get_args();
    $fmt = array_shift($args);
    vprintf($fmt . "\n", $args);
}


/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');

require_once(dirname(__FILE__) . '/../PelDataWindow.php');
require_once(dirname(__FILE__) . '/../PelJpeg.php');
require_once(dirname(__FILE__) . '/../PelTiff.php');

$prog = array_shift($argv);
$error = false;

if (isset($argv[0]) && $argv[0] == '-d') {
  Pel::$debug = true;
  array_shift($argv);
}

if (isset($argv[0])) {
  $input = array_shift($argv);
} else {
  $error = true;
}

if (isset($argv[0])) {
  $output = array_shift($argv);
} else {
  $error = true;
}

if ($error) {
  println('Usage: %s [-d] <input> <output> [desc]', $prog);
  println('Optional arguments:');
  println('  -d    turn debug output on.');
  println('  desc  the new description.');
  println('Mandatory arguments:');
  println('  input   the input file, a JPEG or TIFF image.');
  println('  output  the output file for the changed image.');
  exit(1);
}

$description = implode(' ', $argv);

/* We typically need lots of RAM to parse TIFF images since they tend
 * to be big and uncompressed. */
ini_set('memory_limit', '32M');

println('Reading file "%s".', $input);
$data = new PelDataWindow(file_get_contents($input));

if (PelJpeg::isValid($data)) {
  $jpeg = $file = new PelJpeg($data);
  $app1 = $jpeg->getSection(PelJpegMarker::APP1);
  $tiff = $app1->getTiff();
} elseif (PelTiff::isValid($data)) {
  $tiff = $file = new PelTiff($data);
} else {
  println('Unrecognized image format! The first 16 bytes follow:');
  PelConvert::bytesToDump($data->getBytes(0, 16)); 
}

$ifd0 = $tiff->getIfd();
$desc = $ifd0->getEntry(PelTag::IMAGE_DESCRIPTION);

if ($desc == null) {
  println('Added new IMAGE_DESCRIPTION entry with "%s".', $description);
  $desc = new PelEntryString(PelTag::IMAGE_DESCRIPTION, $description);
  $ifd0->addEntry($desc);
} else {
  println('Updating IMAGE_DESCRIPTION entry from "%s" to "%s".',
          $desc->getValue(), $description);
  $desc->setValue($description);
}

println('Writing file "%s".', $output);
file_put_contents($output, $file->getBytes());


?>