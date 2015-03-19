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

class olympus_c50z extends UnitTestCase
{

    public function __construct()
    {
        parent::__construct('PEL olympus-c50z.jpg Tests');
    }

    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/olympus-c50z.jpg');

        $exif = $jpeg->getExif();
        $this->assertIsA($exif, 'lsolesen\pel\PelExif');

        $tiff = $exif->getTiff();
        $this->assertIsA($tiff, 'lsolesen\pel\PelTiff');

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertIsA($ifd0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0. */
        $this->assertEqual(count($ifd0->getEntries()), 11);

        $entry = $ifd0->getEntry(270); // ImageDescription
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'OLYMPUS DIGITAL CAMERA         ');
        $this->assertEqual($entry->getText(), 'OLYMPUS DIGITAL CAMERA         ');

        $entry = $ifd0->getEntry(271); // Make
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'OLYMPUS OPTICAL CO.,LTD');
        $this->assertEqual($entry->getText(), 'OLYMPUS OPTICAL CO.,LTD');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'X-2,C-50Z       ');
        $this->assertEqual($entry->getText(), 'X-2,C-50Z       ');

        $entry = $ifd0->getEntry(274); // Orientation
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'top - left');

        $entry = $ifd0->getEntry(282); // XResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 144,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '144/1');

        $entry = $ifd0->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 144,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '144/1');

        $entry = $ifd0->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd0->getEntry(305); // Software
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), '28-1012                        ');
        $this->assertEqual($entry->getText(), '28-1012                        ');

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), false);
        $this->assertEqual($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0->getEntry(531); // YCbCrPositioning
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'co-sited');

        $entry = $ifd0->getEntry(50341); // PrintIM
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x50\x72\x69\x6e\x74\x49\x4d\0\x30\x32\x35\x30\0\0\x14\0\x01\0\x12\0\x12\0\x02\0\x01\0\0\0\x03\0\x88\0\0\0\x07\0\0\0\0\0\x08\0\0\0\0\0\x09\0\0\0\0\0\x0a\0\0\0\0\0\x0b\0\xd0\0\0\0\x0c\0\0\0\0\0\x0d\0\0\0\0\0\x0e\0\xe8\0\0\0\0\x01\x01\0\0\0\x01\x01\xff\0\0\0\x02\x01\x80\0\0\0\x03\x01\x80\0\0\0\x04\x01\x80\0\0\0\x05\x01\x80\0\0\0\x06\x01\x80\0\0\0\x07\x01\x80\x80\x80\0\x10\x01\x80\0\0\0\x09\x11\0\0\x10\x27\0\0\x0b\x0f\0\0\x10\x27\0\0\x97\x05\0\0\x10\x27\0\0\xb0\x08\0\0\x10\x27\0\0\x01\x1c\0\0\x10\x27\0\0\x5e\x02\0\0\x10\x27\0\0\x8b\0\0\0\x10\x27\0\0\xcb\x03\0\0\x10\x27\0\0\xe5\x1b\0\0\x10\x27\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '(undefined)');

        /* Sub IFDs of $ifd0. */
        $this->assertEqual(count($ifd0->getSubIfds()), 1);
        $ifd0_0 = $ifd0->getSubIfd(2); // IFD Exif
        $this->assertIsA($ifd0_0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0_0. */
        $this->assertEqual(count($ifd0_0->getEntries()), 30);

        $entry = $ifd0_0->getEntry(33434); // ExposureTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 1,
            1 => 80
        ));
        $this->assertEqual($entry->getText(), '1/80 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 45,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), 'f/4.5');

        $entry = $ifd0_0->getEntry(34850); // ExposureProgram
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 5);
        $this->assertEqual($entry->getText(), 'Creative program (biased toward depth of field)');

        $entry = $ifd0_0->getEntry(34855); // ISOSpeedRatings
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 80);
        $this->assertEqual($entry->getText(), '80');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 2.2);
        $this->assertEqual($entry->getText(), 'Exif Version 2.2');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), false);
        $this->assertEqual($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), false);
        $this->assertEqual($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01\x02\x03\0");
        $this->assertEqual($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37380); // ExposureBiasValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntrySRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 0,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '0.0');

        $entry = $ifd0_0->getEntry(37381); // MaxApertureValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 300,
            1 => 100
        ));
        $this->assertEqual($entry->getText(), '300/100');

        $entry = $ifd0_0->getEntry(37383); // MeteringMode
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 5);
        $this->assertEqual($entry->getText(), 'Pattern');

        $entry = $ifd0_0->getEntry(37384); // LightSource
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Unknown');

        $entry = $ifd0_0->getEntry(37385); // Flash
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 25);
        $this->assertEqual($entry->getText(), 'Flash fired, auto mode.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 1883,
            1 => 100
        ));
        $this->assertEqual($entry->getText(), '18.8 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x4f\x4c\x59\x4d\x50\0\x01\0\x3e\0\0\x02\x04\0\x03\0\0\0\x24\x0f\0\0\x01\x02\x03\0\x01\0\0\0\x02\0\0\0\x02\x02\x03\0\x01\0\0\0\0\0\0\0\x03\x02\x03\0\x01\0\0\0\0\0\0\0\x04\x02\x05\0\x01\0\0\0\x38\x0f\0\0\x05\x02\x05\0\x01\0\0\0\x40\x0f\0\0\x06\x02\x08\0\x06\0\0\0\x48\x0f\0\0\x07\x02\x02\0\x06\0\0\0\x54\x0f\0\0\x09\x02\x07\0\x20\0\0\0\x5a\x0f\0\0\0\x10\x0a\0\x01\0\0\0\x7c\x0f\0\0\x01\x10\x0a\0\x01\0\0\0\x84\x0f\0\0\x02\x10\x0a\0\x01\0\0\0\x8c\x0f\0\0\x03\x10\x0a\0\x01\0\0\0\x94\x0f\0\0\x04\x10\x03\0\x01\0\0\0\0\0\0\0\x05\x10\x03\0\x02\0\0\0\0\0\0\0\x06\x10\x0a\0\x01\0\0\0\xa4\x0f\0\0\x09\x10\x03\0\x01\0\0\0\x01\0\0\0\x0a\x10\x03\0\x01\0\0\0\0\0\0\0\x0b\x10\x03\0\x01\0\0\0\0\0\0\0\x0c\x10\x05\0\x01\0\0\0\xb8\x0f\0\0\x0d\x10\x03\0\x01\0\0\0\x1c\0\x51\x01\x0e\x10\x03\0\x01\0\0\0\x51\x01\x02\0\x0f\x10\x03\0\x01\0\0\0\x02\0\0\0\x10\x10\x03\0\x01\0\0\0\0\0\0\0\x11\x10\x03\0\x09\0\0\0\x36\x10\0\0\x12\x10\x03\0\x04\0\0\0\x48\x10\0\0\x13\x10\x03\0\x01\0\0\0\0\0\0\0\x14\x10\x03\0\x01\0\0\0\0\0\x01\0\x15\x10\x03\0\x02\0\0\0\x01\0\0\0\x16\x10\x03\0\x01\0\0\0\0\0\x70\x01\x17\x10\x03\0\x02\0\0\0\x70\x01\x40\0\x18\x10\x03\0\x02\0\0\0\x26\x01\x40\0\x1a\x10\x02\0\x20\0\0\0\xdc\x0f\0\0\x1b\x10\x04\0\x01\0\0\0\0\0\0\0\x1c\x10\x04\0\x01\0\0\0\0\0\0\0\x1d\x10\x04\0\x01\0\0\0\xe8\xb8\x03\0\x1e\x10\x04\0\x01\0\0\0\0\0\0\0\x1f\x10\x04\0\x01\0\0\0\0\0\0\0\x20\x10\x04\0\x01\0\0\0\0\0\0\0\x21\x10\x04\0\x01\0\0\0\xb0\x27\0\0\x22\x10\x04\0\x01\0\0\0\x20\x6e\x0f\x04\x23\x10\x0a\0\x01\0\0\0\x1c\x10\0\0\x24\x10\x03\0\x01\0\0\0\x36\0\0\0\x25\x10\x0a\0\x01\0\0\0\x28\x10\0\0\x26\x10\x03\0\x01\0\0\0\0\0\0\0\x27\x10\x03\0\x01\0\0\0\0\0\0\0\x28\x10\x03\0\x01\0\0\0\0\0\x64\x01\x29\x10\x03\0\x01\0\0\0\x02\0\0\x02\x2a\x10\x03\0\x01\0\0\0\0\x02\x18\0\x2b\x10\x03\0\x06\0\0\0\x54\x10\0\0\x2c\x10\x03\0\x02\0\0\0\x0a\0\0\0\x2d\x10\x03\0\x01\0\0\0\0\x08\0\0\x2e\x10\x04\0\x01\0\0\0\0\x0a\0\0\x2f\x10\x04\0\x01\0\0\0\x80\x07\0\0\x30\x10\x03\0\x01\0\0\0\x02\0\0\0\x31\x10\x04\0\x08\0\0\0\x74\x10\0\0\x33\x10\x04\0\xd0\x02\0\0\xa0\x10\0\0\x38\x10\x03\0\x01\0\0\0\0\0\0\0\x3b\x10\x03\0\x01\0\0\0\x21\x01\xbe\x01\x3c\x10\x03\0\x01\0\0\0\xbe\x01\0\0\x3d\x10\x0a\0\x01\0\0\0\xe4\x1b\0\0\x3e\x10\x0a\0\x01\0\0\0\xec\x1b\0\0\0\0\0\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '758 bytes unknown MakerNote data');

        $entry = $ifd0_0->getEntry(37510); // UserComment
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUserComment');
        $this->assertEqual($entry->getValue(), '                                                                                                                     ');
        $this->assertEqual($entry->getText(), '                                                                                                                     ');

        $entry = $ifd0_0->getEntry(40960); // FlashPixVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');

        $entry = $ifd0_0->getEntry(40961); // ColorSpace
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'sRGB');

        $entry = $ifd0_0->getEntry(40962); // PixelXDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2560);
        $this->assertEqual($entry->getText(), '2560');

        $entry = $ifd0_0->getEntry(40963); // PixelYDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1920);
        $this->assertEqual($entry->getText(), '1920');

        $entry = $ifd0_0->getEntry(41728); // FileSource
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x03");
        $this->assertEqual($entry->getText(), 'DSC');

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
            0 => 100,
            1 => 100
        ));
        $this->assertEqual($entry->getText(), '100/100');

        $entry = $ifd0_0->getEntry(41990); // SceneCaptureType
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Portrait');

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
        $this->assertEqual(count($ifd1->getEntries()), 4);

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

        /* Sub IFDs of $ifd1. */
        $this->assertEqual(count($ifd1->getSubIfds()), 0);

        $thumb_data = file_get_contents(dirname(__FILE__) . '/olympus-c50z-thumb.jpg');
        $this->assertEqual($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
