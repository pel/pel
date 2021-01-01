#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2006, 2007 Martin Geisler.
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
namespace Pel\examples;

use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;

/**
 * a printf() variant that appends a newline to the output.
 */
function println($args)
{
    $args = func_get_args();
    $fmt = array_shift($args);
    vprintf($fmt . "\n", $args);
}

/* Make PEL speak the users language, if it is available. */
setlocale(LC_ALL, '');

$argv = $_SERVER['argv'];

/*
 * Store the name of the script in $prog and remove this first part of
 * the command line.
 */
$prog = array_shift($argv);
$error = false;

/*
 * The next argument could be -d to signal debug mode where lots of
 * extra information is printed out when the image is parsed.
 */
if (isset($argv[0]) && $argv[0] == '-d') {
    Pel::setDebug(true);
    array_shift($argv);
}

/* The mandatory input filename. */
if (isset($argv[0])) {
    $input = array_shift($argv);
} else {
    $error = true;
}

/* The mandatory output filename. */
if (isset($argv[0])) {
    $output = array_shift($argv);
} else {
    $error = true;
}

/* The mandatory scale factor. */
if (isset($argv[0])) {
    $scale = array_shift($argv);
} else {
    $error = true;
}

/*
 * Usage information is printed if an error was found in the command
 * line arguments.
 */
if ($error) {
    println('Usage: %s [-d] <input> <output> <scale>', $prog);
    println('Optional arguments:');
    println('  -d    turn debug output on.');
    println('Mandatory arguments:');
    println('  input   the input filename, a JPEG image.');
    println('  output  filename for saving the changed image.');
    println('  scale   scale factor, say 0.5 to resize to half the ' . 'original size.');
    exit(1);
}

/* The input file is now loaded into a PelJpeg object. */
println('Reading file "%s".', $input);
$input_jpeg = new PelJpeg($input);

/*
 * The input image is already loaded, so we can reuse the bytes stored
 * in $input_jpeg when creating the Image resource.
 */
$original = ImageCreateFromString($input_jpeg->getBytes());
if ($original === false) {
    throw new \Exception('Can\'t create image from string');
}
$original_w = ImagesX($original);
$original_h = ImagesY($original);

$scaled_w = $original_w * $scale;
$scaled_h = $original_h * $scale;

/* Now create the scaled image. */
$scaled = ImageCreateTrueColor($scaled_w, $scaled_h);
if ($original === false) {
    throw new \Exception('Can\'t create true color image from scaled resources');
}
ImageCopyResampled($scaled, $original, 0, 0, 0, 0, $scaled_w, $scaled_h, $original_w, $original_h);

/*
 * We want the raw JPEG data from $scaled. Luckily, one can create a
 * PelJpeg object from an image resource directly:
 */
$output_jpeg = new PelJpeg($scaled);

/* Retrieve the original Exif data in $jpeg (if any). */
$exif = $input_jpeg->getExif();

/* If no Exif data was present, then $exif is null. */
if ($exif != null) {
    $output_jpeg->setExif($exif);
}

/* We can now save the scaled image. */
println('Writing file "%s".', $output);
$output_jpeg->saveFile($output);
