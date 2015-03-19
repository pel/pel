<?php

/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2005, 2006 Martin Geisler.
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
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../../autoload.php';
    require_once '../../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;


class leica_d_lux extends UnitTestCase
{

    public function __construct()
    {
        parent::__construct('PEL leica-d-lux.jpg Tests');
    }

    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/leica-d-lux.jpg');

        $exif = $jpeg->getExif();
        $this->assertIsA($exif, 'lsolesen\pel\PelExif');

        $tiff = $exif->getTiff();
        $this->assertIsA($tiff, 'lsolesen\pel\PelTiff');

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertIsA($ifd0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0. */
        $this->assertEqual(count($ifd0->getEntries()), 10);

        $entry = $ifd0->getEntry(271); // Make
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'LEICA');
        $this->assertEqual($entry->getText(), 'LEICA');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'D-LUX');
        $this->assertEqual($entry->getText(), 'D-LUX');

        $entry = $ifd0->getEntry(274); // Orientation
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'top - left');

        $entry = $ifd0->getEntry(282); // XResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 72,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '72/1');

        $entry = $ifd0->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 72,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '72/1');

        $entry = $ifd0->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd0->getEntry(305); // Software
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'Ver1.06');
        $this->assertEqual($entry->getText(), 'Ver1.06');

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1099994128);
        $this->assertEqual($entry->getText(), '2004:11:09 09:55:28');

        $entry = $ifd0->getEntry(531); // YCbCrPositioning
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'co-sited');

        $entry = $ifd0->getEntry(50341); // PrintIM
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x50\x72\x69\x6e\x74\x49\x4d\0\x30\x32\x35\x30\0\0\x0e\0\x01\0\x16\0\x16\0\x02\0\0\0\0\0\x03\0\x64\0\0\0\x07\0\0\0\0\0\x08\0\0\0\0\0\x09\0\0\0\0\0\x0a\0\0\0\0\0\x0b\0\xac\0\0\0\x0c\0\0\0\0\0\x0d\0\0\0\0\0\x0e\0\xc4\0\0\0\0\x01\x05\0\0\0\x01\x01\x01\0\0\0\x10\x01\x80\0\0\0\x09\x11\0\0\x10\x27\0\0\x0b\x0f\0\0\x10\x27\0\0\x37\x05\0\0\x10\x27\0\0\xb0\x08\0\0\x10\x27\0\0\x01\x1c\0\0\x10\x27\0\0\x5e\x02\0\0\x10\x27\0\0\x8b\0\0\0\x10\x27\0\0\xcb\x03\0\0\x10\x27\0\0\xe5\x1b\0\0\x10\x27\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '(undefined)');

        /* Sub IFDs of $ifd0. */
        $this->assertEqual(count($ifd0->getSubIfds()), 1);
        $ifd0_0 = $ifd0->getSubIfd(2); // IFD Exif
        $this->assertIsA($ifd0_0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0_0. */
        $this->assertEqual(count($ifd0_0->getEntries()), 37);

        $entry = $ifd0_0->getEntry(33434); // ExposureTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 10,
            1 => 1000
        ));
        $this->assertEqual($entry->getText(), '1/100 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 97,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), 'f/9.7');

        $entry = $ifd0_0->getEntry(34850); // ExposureProgram
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Normal program');

        $entry = $ifd0_0->getEntry(34855); // ISOSpeedRatings
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 100);
        $this->assertEqual($entry->getText(), '100');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 2.2);
        $this->assertEqual($entry->getText(), 'Exif Version 2.2');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1099994128);
        $this->assertEqual($entry->getText(), '2004:11:09 09:55:28');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1099994128);
        $this->assertEqual($entry->getText(), '2004:11:09 09:55:28');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01\x02\x03\0" . '');
        $this->assertEqual($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37122); // CompressedBitsPerPixel
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 21,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '21/10');

        $entry = $ifd0_0->getEntry(37377); // ShutterSpeedValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntrySRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 6644,
            1 => 1000
        ));
        $this->assertEqual($entry->getText(), '6644/1000 sec. (APEX: 10)');

        $entry = $ifd0_0->getEntry(37378); // ApertureValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 66,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), 'f/9.8');

        $entry = $ifd0_0->getEntry(37380); // ExposureBiasValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntrySRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 0,
            1 => 100
        ));
        $this->assertEqual($entry->getText(), '0.0');

        $entry = $ifd0_0->getEntry(37381); // MaxApertureValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 30,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '30/10');

        $entry = $ifd0_0->getEntry(37383); // MeteringMode
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 3);
        $this->assertEqual($entry->getText(), 'Spot');

        $entry = $ifd0_0->getEntry(37384); // LightSource
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'Daylight');

        $entry = $ifd0_0->getEntry(37385); // Flash
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 24);
        $this->assertEqual($entry->getText(), 'Flash did not fire, auto mode.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 88,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '8.8 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x4c\x45\x49\x43\x41\0\0\0\x0b\0\x01\0\x03\0\x01\0\0\0\x03\0\0\0\x02\0\x07\0\x04\0\0\0\x30\x31\x30\x30\x03\0\x03\0\x01\0\0\0\x01\0\0\0\x07\0\x03\0\x01\0\0\0\x01\0\0\0\x0f\0\x01\0\x02\0\0\0\0\x10\0\0\x1a\0\x03\0\x01\0\0\0\x02\0\0\0\x1c\0\x03\0\x01\0\0\0\x02\0\0\0\x1f\0\x03\0\x01\0\0\0\x01\0\0\0\x20\0\x03\0\x01\0\0\0\x02\0\0\0\x21\0\x07\0\x72\0\0\0\x5e\x04\0\0\x22\0\x03\0\x01\0\0\0\0\0\0\0\x57\x42\x02\x62\x01\x36\0\xb9\0\x92\0\xa8\0\x8c\0\xdc\0\xa0\0\x4b\x01\x9c\x01\xd5\x02\x3b\x01\x1c\x02\x44\x01\x1d\x0b\xab\x1b\x6c\x16\xb8\0\0\x41\x46\x01\x96\x04\x8e\x20\x06\0\0\x53\x54\0\0\0\0\0\0\x01\x24\0\0\0\0\0\0\0\x05\0\x05\0\0\x41\x45\x06\xa7\0\x4c\0\0\x02\x28\x09\x01\0\x93\x01\x44\0\0\x08\x08\x08\x08\x03\x03\0\0\0\xe0\0\0\x20\x20\0\x0a\0\0\x45\x50\x01\x0a\0\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '256 bytes unknown MakerNote data');

        $entry = $ifd0_0->getEntry(40960); // FlashPixVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');

        $entry = $ifd0_0->getEntry(40961); // ColorSpace
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'sRGB');

        $entry = $ifd0_0->getEntry(40962); // PixelXDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryLong');
        $this->assertEqual($entry->getValue(), 640);
        $this->assertEqual($entry->getText(), '640');

        $entry = $ifd0_0->getEntry(40963); // PixelYDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryLong');
        $this->assertEqual($entry->getValue(), 480);
        $this->assertEqual($entry->getText(), '480');

        $entry = $ifd0_0->getEntry(41495); // SensingMethod
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'One-chip color area sensor');

        $entry = $ifd0_0->getEntry(41728); // FileSource
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x03");
        $this->assertEqual($entry->getText(), 'DSC');

        $entry = $ifd0_0->getEntry(41729); // SceneType
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01");
        $this->assertEqual($entry->getText(), 'Directly photographed');

        $entry = $ifd0_0->getEntry(41730); // CFAPattern
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\0\x02\0\x02\0\x01\x01\x02");
        $this->assertEqual($entry->getText(), '(undefined)');

        $entry = $ifd0_0->getEntry(41985); // CustomRendered
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Normal process');

        $entry = $ifd0_0->getEntry(41986); // ExposureMode
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Auto exposure');

        $entry = $ifd0_0->getEntry(41987); // WhiteBalance
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Auto white balance');

        $entry = $ifd0_0->getEntry(41988); // DigitalZoomRatio
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 0,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '0/10');

        $entry = $ifd0_0->getEntry(41989); // FocalLengthIn35mmFilm
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 53);
        $this->assertEqual($entry->getText(), '53');

        $entry = $ifd0_0->getEntry(41990); // SceneCaptureType
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Standard');

        $entry = $ifd0_0->getEntry(41991); // GainControl
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41992); // Contrast
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41993); // Saturation
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41994); // Sharpness
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41996); // SubjectDistanceRange
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Close view');

        /* Sub IFDs of $ifd0_0. */
        $this->assertEqual(count($ifd0_0->getSubIfds()), 1);
        $ifd0_0_0 = $ifd0_0->getSubIfd(4); // IFD Interoperability
        $this->assertIsA($ifd0_0_0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0_0_0. */
        $this->assertEqual(count($ifd0_0_0->getEntries()), 2);

        $entry = $ifd0_0_0->getEntry(1); // InteroperabilityIndex
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'R98');
        $this->assertEqual($entry->getText(), 'R98');

        $entry = $ifd0_0_0->getEntry(2); // InteroperabilityVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'Interoperability Version 1.0');

        /* Sub IFDs of $ifd0_0_0. */
        $this->assertEqual(count($ifd0_0_0->getSubIfds()), 0);

        $this->assertEqual($ifd0_0_0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd0_0_1 = $ifd0_0_0->getNextIfd();
        $this->assertNull($ifd0_0_1);
        /* End of IFD $ifd0_0_0. */

        $this->assertEqual($ifd0_0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd0_1 = $ifd0_0->getNextIfd();
        $this->assertNull($ifd0_1);
        /* End of IFD $ifd0_0. */

        $this->assertEqual($ifd0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd1 = $ifd0->getNextIfd();
        $this->assertIsA($ifd1, 'lsolesen\pel\PelIfd');
        /* End of IFD $ifd0. */

        /* Start of IDF $ifd1. */
        $this->assertEqual(count($ifd1->getEntries()), 5);

        $entry = $ifd1->getEntry(259); // Compression
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 6);
        $this->assertEqual($entry->getText(), 'JPEG compression');

        $entry = $ifd1->getEntry(282); // XResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 72,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '72/1');

        $entry = $ifd1->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 72,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '72/1');

        $entry = $ifd1->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd1->getEntry(531); // YCbCrPositioning
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'co-sited');

        /* Sub IFDs of $ifd1. */
        $this->assertEqual(count($ifd1->getSubIfds()), 0);

        $thumb_data = file_get_contents(dirname(__FILE__) . '/leica-d-lux-thumb.jpg');
        $this->assertEqual($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
