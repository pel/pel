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
use \lsolesen\pel\Pel;
use \lsolesen\pel\PelJpeg;

class canon_ixus_ii extends UnitTestCase
{

    public function __construct()
    {
        parent::__construct('PEL canon-ixus-ii.jpg Tests');
    }

    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/canon-ixus-ii.jpg');

        $exif = $jpeg->getExif();
        $this->assertIsA($exif, 'lsolesen\pel\PelExif');

        $tiff = $exif->getTiff();
        $this->assertIsA($tiff, 'lsolesen\pel\PelTiff');

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertIsA($ifd0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0. */
        $this->assertEqual(count($ifd0->getEntries()), 8);

        $entry = $ifd0->getEntry(271); // Make
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'Canon');
        $this->assertEqual($entry->getText(), 'Canon');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'Canon DIGITAL IXUS II');
        $this->assertEqual($entry->getText(), 'Canon DIGITAL IXUS II');

        $entry = $ifd0->getEntry(274); // Orientation
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 6);
        $this->assertEqual($entry->getText(), 'right - top');

        $entry = $ifd0->getEntry(282); // XResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 180,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '180/1');

        $entry = $ifd0->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 180,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '180/1');

        $entry = $ifd0->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1089488628);
        $this->assertEqual($entry->getText(), '2004:07:10 19:43:48');

        $entry = $ifd0->getEntry(531); // YCbCrPositioning
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'centered');

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
            1 => 30
        ));
        $this->assertEqual($entry->getText(), '1/30 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 32,
            1 => 10
        ));
        $this->assertEqual($entry->getText(), 'f/3.2');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 2.2);
        $this->assertEqual($entry->getText(), 'Exif Version 2.2');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1089488628);
        $this->assertEqual($entry->getText(), '2004:07:10 19:43:48');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryTime');
        $this->assertEqual($entry->getValue(), 1089488628);
        $this->assertEqual($entry->getText(), '2004:07:10 19:43:48');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $this->assertEqual($entry->getValue(), "\x01\x02\x03\0");
        $this->assertEqual($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37122); // CompressedBitsPerPixel
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 2,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '2/1');

        $entry = $ifd0_0->getEntry(37377); // ShutterSpeedValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntrySRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 157,
            1 => 32
        ));
        $this->assertEqual($entry->getText(), '157/32 sec. (APEX: 5)');

        $entry = $ifd0_0->getEntry(37378); // ApertureValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 107,
            1 => 32
        ));
        $this->assertEqual($entry->getText(), 'f/3.2');

        $entry = $ifd0_0->getEntry(37380); // ExposureBiasValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntrySRational');
        $this->assertEqual($entry->getValue(), array(
            0 => - 1,
            1 => 3
        ));
        $this->assertEqual($entry->getText(), '-0.3');

        $entry = $ifd0_0->getEntry(37381); // MaxApertureValue
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 107,
            1 => 32
        ));
        $this->assertEqual($entry->getText(), '107/32');

        $entry = $ifd0_0->getEntry(37383); // MeteringMode
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 5);
        $this->assertEqual($entry->getText(), 'Pattern');

        $entry = $ifd0_0->getEntry(37385); // Flash
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 16);
        $this->assertEqual($entry->getText(), 'Flash did not fire, compulsory flash mode.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 215,
            1 => 32
        ));
        $this->assertEqual($entry->getText(), '6.7 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUndefined');
        $expected = "\x0e\0\x01\0\x03\0\x2e\0\0\0\x5c\x04\0\0\x02\0\x03\0\x04\0\0\0\xb8\x04\0\0\x03\0\x03\0\x04\0\0\0\xc0\x04\0\0\x04\0\x03\0\x22\0\0\0\xc8\x04\0\0\0\0\x03\0\x06\0\0\0\x0c\x05\0\0\0\0\x03\0\x04\0\0\0\x18\x05\0\0\x12\0\x03\0\x1c\0\0\0\x20\x05\0\0\x13\0\x03\0\x04\0\0\0\x58\x05\0\0\x06\0\x02\0\x20\0\0\0\x60\x05\0\0\x07\0\x02\0\x18\0\0\0\x80\x05\0\0\x08\0\x04\0\x01\0\0\0\x7c\x57\x12\0\x09\0\x02\0\x20\0\0\0\x98\x05\0\0\x10\0\x04\0\x01\0\0\0\0\0\x23\x01\x0d\0\x03\0\x22\0\0\0\xb8\x05\0\0\0\0\0\0\x5c\0\x02\0\0\0\x02\0\0\0\0\0\0\0\x04\0\0\0\x01\0\x02\0\x01\0\0\0\0\0\0\0\0\0\x0f\0\x03\0\x01\0\x01\x40\0\0\0\0\xff\xff\x5a\x01\xad\0\x20\0\x6a\0\xbe\0\0\0\0\0\0\0\0\0\0\0\x01\0\xff\xff\0\0\0\x08\0\x08\0\0\0\0\x03\0\0\0\xff\x7f\0\0\0\0\0\0\x02\0\xd7\0\xd5\0\x9f\0\0\x04\0\0\0\0\0\0\x44\0\0\0\x80\0\x81\0\x6b\0\x9d\0\xf4\xff\x04\0\0\0\0\0\x01\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x01\0\x36\0\0\0\x6a\0\xa1\0\0\0\0\0\x01\0\xfa\0\x01\0\0\0\0\0\0\0\0\0\0\0\x2b\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x09\0\x09\0\x80\x02\xe0\x01\0\x08\0\x01\x71\x01\x2a\0\x8e\xfe\0\0\x72\x01\x8e\xfe\0\0\x72\x01\x8e\xfe\0\0\x72\x01\xd0\xff\xd0\xff\xd0\xff\0\0\0\0\0\0\x30\0\x30\0\x30\0\x01\0\x02\0\0\0\0\0\0\0\0\0\x49\x4d\x47\x3a\x44\x49\x47\x49\x54\x41\x4c\x20\x49\x58\x55\x53\x20\x49\x49\x20\x4a\x50\x45\x47\0\0\0\0\0\0\0\0\x46\x69\x72\x6d\x77\x61\x72\x65\x20\x56\x65\x72\x73\x69\x6f\x6e\x20\x31\x2e\x30\x30\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x44\0\x09\0\xda\x01\xdb\x01\xd1\x01\xd9\x01\xd9\x01\xdb\x01\xdb\x01\xdb\x01\xda\x01\x40\0\0\0\0\0\xa2\xff\x01\0\0\0\x0a\0\0\0\xfb\xff\x0a\0\x20\x03\x6d\0\x01\0\xff\xff\xbb\x03\0\0\0\0\0\0\0\0\0\0\x6c\0\0\0\x06\0";
        $this->assertEqual($entry->getValue(), $expected);
        $this->assertEqual($entry->getText(), '590 bytes unknown MakerNote data');

        $entry = $ifd0_0->getEntry(37510); // UserComment
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryUserComment');

        $expected = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEqual($entry->getValue(), $expected);

        $expected = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEqual($entry->getText(), $expected);

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
        $this->assertEqual($entry->getValue(), 640);
        $this->assertEqual($entry->getText(), '640');

        $entry = $ifd0_0->getEntry(40963); // PixelYDimension
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 480);
        $this->assertEqual($entry->getText(), '480');

        $entry = $ifd0_0->getEntry(41486); // FocalPlaneXResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 640000,
            1 => 208
        ));
        $this->assertEqual($entry->getText(), '640000/208');

        $entry = $ifd0_0->getEntry(41487); // FocalPlaneYResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 480000,
            1 => 156
        ));
        $this->assertEqual($entry->getText(), '480000/156');

        $entry = $ifd0_0->getEntry(41488); // FocalPlaneResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        $entry = $ifd0_0->getEntry(41495); // SensingMethod
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'One-chip color area sensor');

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
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'Manual exposure');

        $entry = $ifd0_0->getEntry(41987); // WhiteBalance
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'Manual white balance');

        $entry = $ifd0_0->getEntry(41988); // DigitalZoomRatio
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 2048,
            1 => 2048
        ));
        $this->assertEqual($entry->getText(), '2048/2048');

        $entry = $ifd0_0->getEntry(41990); // SceneCaptureType
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 0);
        $this->assertEqual($entry->getText(), 'Standard');

        /* Sub IFDs of $ifd0_0. */
        $this->assertEqual(count($ifd0_0->getSubIfds()), 1);
        $ifd0_0_0 = $ifd0_0->getSubIfd(4); // IFD Interoperability
        $this->assertIsA($ifd0_0_0, 'lsolesen\pel\PelIfd');

        /* Start of IDF $ifd0_0_0. */
        $this->assertEqual(count($ifd0_0_0->getEntries()), 4);

        $entry = $ifd0_0_0->getEntry(1); // InteroperabilityIndex
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryAscii');
        $this->assertEqual($entry->getValue(), 'R98');
        $this->assertEqual($entry->getText(), 'R98');

        $entry = $ifd0_0_0->getEntry(2); // InteroperabilityVersion
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryVersion');
        $this->assertEqual($entry->getValue(), 1);
        $this->assertEqual($entry->getText(), 'Interoperability Version 1.0');

        $entry = $ifd0_0_0->getEntry(4097); // RelatedImageWidth
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 640);
        $this->assertEqual($entry->getText(), '640');

        $entry = $ifd0_0_0->getEntry(4098); // RelatedImageLength
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 480);
        $this->assertEqual($entry->getText(), '480');

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
            0 => 180,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '180/1');

        $entry = $ifd1->getEntry(283); // YResolution
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryRational');
        $this->assertEqual($entry->getValue(), array(
            0 => 180,
            1 => 1
        ));
        $this->assertEqual($entry->getText(), '180/1');

        $entry = $ifd1->getEntry(296); // ResolutionUnit
        $this->assertIsA($entry, 'lsolesen\pel\PelEntryShort');
        $this->assertEqual($entry->getValue(), 2);
        $this->assertEqual($entry->getText(), 'Inch');

        /* Sub IFDs of $ifd1. */
        $this->assertEqual(count($ifd1->getSubIfds()), 0);

        $thumb_data = file_get_contents(dirname(__FILE__) . '/canon-ixus-ii-thumb.jpg');
        $this->assertEqual($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
