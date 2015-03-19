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

class nikon_e950 extends UnitTestCase
{

    public function __construct()
    {
        parent::__construct('PEL nikon-e950.jpg Tests');
    }

    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/nikon-e950.jpg');

        $exif = $jpeg->getExif();
        $this->assertIsA($exif, 'lsolesen\pel\PelExif');

        $tiff = $exif->getTiff();
        $this->assertIsA($tiff, 'lsolesen\pel\PelTiff');

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertIsA($ifd0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0. */
        $this->assertEqual(count($ifd0->getEntries()), 10);

        $entry = $ifd0->getEntry(270); // ImageDescription
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), '          ');
        $this->assertEqual($entry->getText(), '          ');

        $entry = $ifd0->getEntry(271); // Make
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'NIKON');
        $this->assertEqual($entry->getText(), 'NIKON');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'E950');
        $this->assertEqual($entry->getText(), 'E950');

        $entry = $ifd0->getEntry(274); // Orientation
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'top - left');

        $entry = $ifd0->getEntry(282); // XResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 300,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '300/1');

        $entry = $ifd0->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 300,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '300/1');

        $entry = $ifd0->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd0->getEntry(305); // Software
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'v981p-78');
        $this->assertEqual($entry->getText(), 'v981p-78');

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 978276013);
        $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');

        $entry = $ifd0->getEntry(531); // YCbCrPositioning
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'co-sited');

        /* Sub IFDs of $ifd0. */
        $this->assertEqual(count($ifd0->getSubIfds()), 1);
        $ifd0_0 = $ifd0->getSubIfd(2); // IFD Exif
        $this->assertIsA($ifd0_0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0_0. */
        $this->assertEqual(count($ifd0_0->getEntries()), 23);

        $entry = $ifd0_0->getEntry(33434); // ExposureTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 10,
            1 => 1120
        ));
        $this->assertEqual($entry->getText(), '1/112 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 60,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), 'f/6.0');

        $entry = $ifd0_0->getEntry(34850); // ExposureProgram
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Normal program');

        $entry = $ifd0_0->getEntry(34855); // ISOSpeedRatings
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 80);
        $this->assertEqual($entry->getText(), '80');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 2.1);
        $this->assertEqual($entry->getText(), 'Exif Version 2.1');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 978276013);
        $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 978276013);
        $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01\x02\x03\0");
        $this->assertEqual($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37122); // CompressedBitsPerPixel
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 4,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '4/1');

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
            0 => 26,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '26/10');

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
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Flash did not fire.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 158,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), '15.8 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x4e\x69\x6b\x6f\x6e\0\x01\0\x0b\0\x02\0\x02\0\x06\0\0\0\x26\x04\0\0\x03\0\x03\0\x01\0\0\0\x0c\0\0\0\x04\0\x03\0\x01\0\0\0\x01\0\0\0\x05\0\x03\0\x01\0\0\0\0\0\0\0\x06\0\x03\0\x01\0\0\0\0\0\0\0\x07\0\x03\0\x01\0\0\0\0\0\0\0\x08\0\x05\0\x01\0\0\0\x2c\x04\0\0\x09\0\x02\0\x14\0\0\0\x34\x04\0\0\x0a\0\x05\0\x01\0\0\0\x48\x04\0\0\x0b\0\x03\0\x01\0\0\0\0\0\0\0\0\x0f\x04\0\x1e\0\0\0\x50\x04\0\0\0\0\0\0\x30\x38\x2e\x30\x30\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x64\0\0\0\x01\x3e\0\x80\x01\x58\0\0\0\0\xff\x01\0\0\0\0\x0c\xe5\x10\x8c\0\0\0\0\x0a\x5b\0\0\x18\x6a\0\0\x23\x04\0\0\x11\x16\0\0\x11\x16\0\0\x1f\x05\x0c\x9f\0\x2f\0\0\0\0\x01\xcb\x02\x27\x02\x7b\x02\xd8\x03\x6a\x08\x5c\0\0\0\0\x10\x0e\x15\0\0\x01\x60\0\0\x30\0\0\0\x10\0\0\x5b\x18\x02\0\x48\x04\x16\x68\0\x0b\x58\x29\0\x3f\0\0\x15\x19\x15\x1a\x0f\xe1\x42\0\xff\0\x4f\x5d\x32\x0c\xa1\x02\0\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '308 bytes unknown MakerNote data');

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
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryLong');
        $this->assertEqual($entry->getValue(), 1600);
        $this->assertEqual($entry->getText(), '1600');

        $entry = $ifd0_0->getEntry(40963); // PixelYDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryLong');
        $this->assertEqual($entry->getValue(), 1200);
        $this->assertEqual($entry->getText(), '1200');

        $entry = $ifd0_0->getEntry(41728); // FileSource
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x03");
        $this->assertEqual($entry->getText(), 'DSC');

        $entry = $ifd0_0->getEntry(41729); // SceneType
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01");
        $this->assertEqual($entry->getText(), 'Directly photographed');

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
            0 => 300,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '300/1');

        $entry = $ifd1->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 300,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '300/1');

        $entry = $ifd1->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        /* Sub IFDs of $ifd1. */
        $this->assertEqual(count($ifd1->getSubIfds()), 0);

        $thumb_data = file_get_contents(dirname(__FILE__) . '/nikon-e950-thumb.jpg');
        $this->assertEqual($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
