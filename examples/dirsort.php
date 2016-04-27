#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.LESSER and COPYING files that are distributed with this source code.
 */

/* a printf() variant that appends a newline to the output. */
function println($args)
{
    $args = func_get_args();
    $fmt = array_shift($args);
    vprintf($fmt . "\n", $args);
}

/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');
require_once '../autoload.php';
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;

$prog = array_shift($argv);
$error = false;

if (isset($argv[0]) && $argv[0] == '-d') {
    Pel::$debug = true;
    array_shift($argv);
}

if (empty($argv)) {
    println('Usage: %s [-d] <file> ...', $prog);
    println('Optional arguments:');
    println('  -d        turn debug output on.');
    println('Mandatory arguments:');
    println('  file ...  one or more file names.');
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
        if ($app1 == null) {
            println('Skipping %s because no APP1 section was found.', $file);
            continue;
        }

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

    $new = gmdate('../Y-m/', $time) . $file;

    if (file_exists($new)) {
        die('Aborting, ' . $new . ' exists!');
    }
    println('mv %s %s', $file, $new);

    rename($file, $new);
}
