#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
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

/* a printf() variant that appends a newline to the output. */
use lsolesen\pel\Pel;
use lsolesen\pel\PelConvert;
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
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

/*
 * Usage information is printed if an error was found in the command
 * line arguments.
 */
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

/* Any remaining arguments are considered the new description. */
$description = implode(' ', $argv);

/*
 * We typically need lots of RAM to parse TIFF images since they tend
 * to be big and uncompressed.
 */
ini_set('memory_limit', '32M');

/*
 * The input file is now read into a PelDataWindow object. At this
 * point we do not know if the file stores JPEG or TIFF data, so
 * instead of using one of the loadFile methods on PelJpeg or PelTiff
 * we store the data in a PelDataWindow.
 */
println('Reading file "%s".', $input);
$data = new PelDataWindow(file_get_contents($input));

/*
 * The static isValid methods in PelJpeg and PelTiff will tell us in
 * an efficient maner which kind of data we are dealing with.
 */
if (PelJpeg::isValid($data)) {
    /*
     * The data was recognized as JPEG data, so we create a new empty
     * PelJpeg object which will hold it. When we want to save the
     * image again, we need to know which object to same (using the
     * getBytes method), so we store $jpeg as $file too.
     */
    $jpeg = $file = new PelJpeg();

    /*
     * We then load the data from the PelDataWindow into our PelJpeg
     * object. No copying of data will be done, the PelJpeg object will
     * simply remember that it is to ask the PelDataWindow for data when
     * required.
     */
    $jpeg->load($data);

    /*
     * The PelJpeg object contains a number of sections, one of which
     * might be our Exif data. The getExif() method is a convenient way
     * of getting the right section with a minimum of fuzz.
     */
    $exif = $jpeg->getExif();

    if ($exif == null) {
        /*
         * Ups, there is no APP1 section in the JPEG file. This is where
         * the Exif data should be.
         */
        println('No APP1 section found, added new.');

        /*
         * In this case we simply create a new APP1 section (a PelExif
         * object) and adds it to the PelJpeg object.
         */
        $exif = new PelExif();
        $jpeg->setExif($exif);

        /* We then create an empty TIFF structure in the APP1 section. */
        $tiff = new PelTiff();
        $exif->setTiff($tiff);
    } else {
        /*
         * Surprice, surprice: Exif data is really just TIFF data! So we
         * extract the PelTiff object for later use.
         */
        println('Found existing APP1 section.');
        $tiff = $exif->getTiff();
    }
} elseif (PelTiff::isValid($data)) {
    /*
     * The data was recognized as TIFF data. We prepare a PelTiff
     * object to hold it, and record in $file that the PelTiff object is
     * the top-most object (the one on which we will call getBytes).
     */
    $tiff = $file = new PelTiff();
    /* Now load the data. */
    $tiff->load($data);
} else {
    /*
     * The data was not recognized as either JPEG or TIFF data.
     * Complain loudly, dump the first 16 bytes, and exit.
     */
    println('Unrecognized image format! The first 16 bytes follow:');
    PelConvert::bytesToDump($data->getBytes(0, 16));
    exit(1);
}

/*
 * TIFF data has a tree structure much like a file system. There is a
 * root IFD (Image File Directory) which contains a number of entries
 * and maybe a link to the next IFD. The IFDs are chained together
 * like this, but some of them can also contain what is known as
 * sub-IFDs. For our purpose we only need the first IFD, for this is
 * where the image description should be stored.
 */
$ifd0 = $tiff->getIfd();

if ($ifd0 == null) {
    /*
     * No IFD in the TIFF data? This probably means that the image
     * didn't have any Exif information to start with, and so an empty
     * PelTiff object was inserted by the code above. But this is no
     * problem, we just create and inserts an empty PelIfd object.
     */
    println('No IFD found, adding new.');
    $ifd0 = new PelIfd(PelIfd::IFD0);
    $tiff->setIfd($ifd0);
}

/*
 * Each entry in an IFD is identified with a tag. This will load the
 * ImageDescription entry if it is present. If the IFD does not
 * contain such an entry, null will be returned.
 */
$desc = $ifd0->getEntry(PelTag::IMAGE_DESCRIPTION);

/* We need to check if the image already had a description stored. */
if ($desc == null) {
    /* The was no description in the image. */
    println('Added new IMAGE_DESCRIPTION entry with "%s".', $description);

    /*
     * In this case we simply create a new PelEntryAscii object to hold
     * the description. The constructor for PelEntryAscii needs to know
     * the tag and contents of the new entry.
     */
    $desc = new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description);

    /*
     * This will insert the newly created entry with the description
     * into the IFD.
     */
    $ifd0->addEntry($desc);
} else {
    /* An old description was found in the image. */
    println('Updating IMAGE_DESCRIPTION entry from "%s" to "%s".', $desc->getValue(), $description);

    /* The description is simply updated with the new description. */
    $desc->setValue($description);
}

/*
 * At this point the image on disk has not been changed, it is only
 * the object structure in memory which represent the image which has
 * been altered. This structure can be converted into a string of
 * bytes with the getBytes method, and saving this in the output file
 * completes the script.
 */
println('Writing file "%s".', $output);
$file->saveFile($output);
