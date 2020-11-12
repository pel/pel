#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the file COPYING; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA 02110-1301 USA
 */

/*
 * An example of how PEL can be used. The script will read the Exif
 * timestamps in the files given, and rename the files based on that.
 * Should there be several files with the same timestamp --- the
 * resolution of the Exif timestamp is one second, so a burst of
 * images will typically have identical timestamps --- then the next
 * available time will be used.
 */

/* a printf() variant that appends a newline to the output. */
use lsolesen\pel\Pel;
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelTiff;

function println($args)
{
    $args = func_get_args();
    $fmt = array_shift($args);
    vprintf($fmt . "\n", $args);
}

/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');


$prog = array_shift($argv);
$error = false;

/* Accept the optional -d command line argument. */
if (isset($argv[0]) && $argv[0] == '-d') {
    Pel::setDebug(true);
    array_shift($argv);
}

/*
 * Print usage information if there are no more command line
 * arguments.
 */
if (empty($argv)) {
    println('Usage: %s [-d] <file> ...', $prog);
    println('Optional arguments:');
    println('  -d        turn debug output on.');
    println('Mandatory arguments:');
    println('  file ...  one or more file names.');
    println();
    println('The files will be renamed based on their Exif timestamp.');
    exit(1);
}

/*
 * We typically need lots of RAM to parse TIFF images since they tend
 * to be big and uncompressed.
 */
ini_set('memory_limit', '32M');

foreach ($argv as $file) {
    println('Reading file "%s".', $file);
    $data = new PelDataWindow(file_get_contents($file));

    if (PelJpeg::isValid($data)) {
        $jpeg = new PelJpeg();
        $jpeg->load($data);
        $app1 = $jpeg->getExif();
        $tiff = $app1->getTiff();
    } elseif (PelTiff::isValid($data)) {
        $tiff = new PelTiff($data);
    } else {
        println('Unrecognized image format! Skipping.');
        continue;
    }

    $ifd0 = $tiff->getIfd();
    $entry = $ifd0->getEntry(PelTag::DATE_TIME);

    if ($entry == null) {
        println('Skipping %s because no DATE_TIME tag was found.', $file);
        continue;
    }

    $time = $entry->getValue();

    do {
        $new = gmdate('Y:m:d-H:i:s', $time) . strchr($file, '.');
        println('Trying file name %s', $new);
        $time ++;
    } while (file_exists($new));

    rename($file, $new);
}
