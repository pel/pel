<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2007 Martin Geisler.
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
 * Contributed by Andac Aydin (aandac@gmx.de).
 * This example shows how one can add GPS information to a JPEG image.
 * Any Exif information in the image will be overwritten by the new
 * information.
 * This example includes two functions:
 * - convertDecimalTpDMS() converts decimal GPS coordinates (how you use them
 * in Google Maps for example) to the conventional coordinate-system
 * used in Exif data.
 * - addGpsInfo() adds several Exif tags to your JPEG file.
 */
require_once '../autoload.php';

use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;

/**
 * Convert a decimal degree into degrees, minutes, and seconds.
 *
 * @param
 *            int the degree in the form 123.456. Must be in the interval
 *            [-180, 180].
 *
 * @return array a triple with the degrees, minutes, and seconds. Each
 *         value is an array itself, suitable for passing to a
 *         PelEntryRational. If the degree is outside the allowed interval,
 *         null is returned instead.
 */
function convertDecimalToDMS($degree)
{
    if ($degree > 180 || $degree < - 180) {
        return null;
    }

    $degree = abs($degree); // make sure number is positive
                            // (no distinction here for N/S
                            // or W/E).

    $seconds = $degree * 3600; // Total number of seconds.

    $degrees = floor($degree); // Number of whole degrees.
    $seconds -= $degrees * 3600; // Subtract the number of seconds
                                 // taken by the degrees.

    $minutes = floor($seconds / 60); // Number of whole minutes.
    $seconds -= $minutes * 60; // Subtract the number of seconds
                               // taken by the minutes.

    $seconds = round($seconds * 100, 0); // Round seconds with a 1/100th
                                         // second precision.

    return [
        [
            $degrees,
            1
        ],
        [
            $minutes,
            1
        ],
        [
            $seconds,
            100
        ]
    ];
}

/**
 * Add GPS information to an image basic metadata.
 * Any old Exif data
 * is discarded.
 *
 * @param
 *            string the input filename.
 *
 * @param
 *            string the output filename. An updated copy of the input
 *            image is saved here.
 *
 * @param
 *            string image description.
 *
 * @param
 *            string user comment.
 *
 * @param
 *            string camera model.
 *
 * @param
 *            float longitude expressed as a fractional number of degrees,
 *            e.g. 12.345�. Negative values denotes degrees west of Greenwich.
 *
 * @param
 *            float latitude expressed as for longitude. Negative values
 *            denote degrees south of equator.
 *
 * @param
 *            float the altitude, negative values express an altitude
 *            below sea level.
 *
 * @param
 *            string the date and time.
 */
function addGpsInfo($input, $output, $description, $comment, $model, $longitude, $latitude, $altitude, $date_time)
{
    /* Load the given image into a PelJpeg object */
    $jpeg = new PelJpeg($input);

    /*
     * Create and add empty Exif data to the image (this throws away any
     * old Exif data in the image).
     */
    $exif = new PelExif();
    $jpeg->setExif($exif);

    /*
     * Create and add TIFF data to the Exif data (Exif data is actually
     * stored in a TIFF format).
     */
    $tiff = new PelTiff();
    $exif->setTiff($tiff);

    /*
     * Create first Image File Directory and associate it with the TIFF
     * data.
     */
    $ifd0 = new PelIfd(PelIfd::IFD0);
    $tiff->setIfd($ifd0);

    /*
     * Create a sub-IFD for holding GPS information. GPS data must be
     * below the first IFD.
     */
    $gps_ifd = new PelIfd(PelIfd::GPS);
    $ifd0->addSubIfd($gps_ifd);

    /*
     * The USER_COMMENT tag must be put in a Exif sub-IFD under the
     * first IFD.
     */
    $exif_ifd = new PelIfd(PelIfd::EXIF);
    $exif_ifd->addEntry(new PelEntryUserComment($comment));
    $ifd0->addSubIfd($exif_ifd);

    $inter_ifd = new PelIfd(PelIfd::INTEROPERABILITY);
    $ifd0->addSubIfd($inter_ifd);

    $ifd0->addEntry(new PelEntryAscii(PelTag::MODEL, $model));
    $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
    $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description));

    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));

    /*
     * Use the convertDecimalToDMS function to convert the latitude from
     * something like 12.34� to 12� 20' 42"
     */
    list ($hours, $minutes, $seconds) = convertDecimalToDMS($latitude);

    /* We interpret a negative latitude as being south. */
    $latitude_ref = ($latitude < 0) ? 'S' : 'N';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));

    /* The longitude works like the latitude. */
    list ($hours, $minutes, $seconds) = convertDecimalToDMS($longitude);
    $longitude_ref = ($longitude < 0) ? 'W' : 'E';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));

    /*
     * Add the altitude. The absolute value is stored here, the sign is
     * stored in the GPS_ALTITUDE_REF tag below.
     */
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
        abs($altitude),
        1
    ]));
    /*
     * The reference is set to 1 (true) if the altitude is below sea
     * level, or 0 (false) otherwise.
     */
    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));

    /* Finally we store the data in the output file. */
    file_put_contents($output, $jpeg->getBytes());
}
