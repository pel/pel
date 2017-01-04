#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */

/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');

require_once '../autoload.php';
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;

$prog = array_shift($argv);
$file = '';

while (! empty($argv)) {
    switch ($argv[0]) {
        case '-d':
            Pel::setDebug(true);
            break;
        case '-s':
            Pel::setStrictParsing(true);
            break;
        default:
            $file = $argv[0];
            break;
    }
    array_shift($argv);
}

if (empty($file)) {
    printf("Usage: %s [-d] [-s] <filename>\n", $prog);
    print("Optional arguments:\n");
    print("  -d        turn debug output on.\n");
    print("  -s        turn strict parsing on (halt on errors).\n");
    print("Mandatory arguments:\n");
    print("  filename  a JPEG or TIFF image.\n");
    exit(1);
}

if (! is_readable($file)) {
    printf("Unable to read %s!\n", $file);
    exit(1);
}

/*
 * We typically need lots of RAM to parse TIFF images since they tend
 * to be big and uncompressed.
 */
ini_set('memory_limit', '32M');

$data = new PelDataWindow(file_get_contents($file));

if (PelJpeg::isValid($data)) {
    $img = new PelJpeg();
} elseif (PelTiff::isValid($data)) {
    $img = new PelTiff();
} else {
    print("Unrecognized image format! The first 16 bytes follow:\n");
    PelConvert::bytesToDump($data->getBytes(0, 16));
    exit(1);
}

/* Try loading the data. */
$img->load($data);

print($img);

/* Deal with any exceptions: */
if (count(Pel::getExceptions()) > 0) {
    print("\nThe following errors were encountered while loading the image:\n");
    foreach (Pel::getExceptions() as $e) {
        print("\n" . $e->__toString());
    }
}
