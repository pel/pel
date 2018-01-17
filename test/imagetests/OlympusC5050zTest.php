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

namespace Pel\Test\imagetests;

use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;
use PHPUnit\Framework\TestCase;

class OlympusC5050zTest extends TestCase
{
    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/olympus-c5050z.jpg');

        $exif = $jpeg->getExif();
        $this->assertInstanceOf('lsolesen\pel\PelExif', $exif);

        $tiff = $exif->getTiff();
        $this->assertInstanceOf('lsolesen\pel\PelTiff', $tiff);

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0);

        /* Start of IDF $ifd0. */
        $this->assertEquals(count($ifd0->getEntries()), 11);

        $entry = $ifd0->getEntry(270); // ImageDescription
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'OLYMPUS DIGITAL CAMERA         ');
        $this->assertEquals($entry->getText(), 'OLYMPUS DIGITAL CAMERA         ');

        $entry = $ifd0->getEntry(271); // Make
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'OLYMPUS OPTICAL CO.,LTD');
        $this->assertEquals($entry->getText(), 'OLYMPUS OPTICAL CO.,LTD');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'C5050Z');
        $this->assertEquals($entry->getText(), 'C5050Z');

        $entry = $ifd0->getEntry(274); // Orientation
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'top - left');

        $entry = $ifd0->getEntry(282); // XResolution
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 72,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '72/1');

        $entry = $ifd0->getEntry(283); // YResolution
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 72,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '72/1');

        $entry = $ifd0->getEntry(296); // ResolutionUnit
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 2);
        $this->assertEquals($entry->getText(), 'Inch');

        $entry = $ifd0->getEntry(305); // Software
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'v558-83');
        $this->assertEquals($entry->getText(), 'v558-83');

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), false);
        $this->assertEquals($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0->getEntry(531); // YCbCrPositioning
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 2);
        $this->assertEquals($entry->getText(), 'co-sited');

        $entry = $ifd0->getEntry(50341); // PrintIM
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $expected = "\x50\x72\x69\x6e\x74\x49\x4d\0\x30\x32\x35\x30\0\0\x14\0\x01\0\x14\0\x14\0\x02\0\x01\0\0\0\x03\0\x88\0\0\0\x07\0\0\0\0\0\x08\0\0\0\0\0\x09\0\0\0\0\0\x0a\0\0\0\0\0\x0b\0\xd0\0\0\0\x0c\0\0\0\0\0\x0d\0\0\0\0\0\x0e\0\xe8\0\0\0\0\x01\x01\0\0\0\x01\x01\xff\0\0\0\x02\x01\x83\0\0\0\x03\x01\x83\0\0\0\x04\x01\x80\0\0\0\x05\x01\x83\0\0\0\x06\x01\x83\0\0\0\x07\x01\x80\x80\x80\0\x10\x01\x80\0\0\0\x09\x11\0\0\x10\x27\0\0\x0b\x0f\0\0\x10\x27\0\0\x97\x05\0\0\x10\x27\0\0\xb0\x08\0\0\x10\x27\0\0\x01\x1c\0\0\x10\x27\0\0\x5e\x02\0\0\x10\x27\0\0\x8b\0\0\0\x10\x27\0\0\xcb\x03\0\0\x10\x27\0\0\xe5\x1b\0\0\x10\x27\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEquals($entry->getValue(), $expected);
        $this->assertEquals($entry->getText(), '(undefined)');

        /* Sub IFDs of $ifd0. */
        $this->assertEquals(count($ifd0->getSubIfds()), 1);
        $ifd0_0 = $ifd0->getSubIfd(2); // IFD Exif
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0_0);

        /* Start of IDF $ifd0_0. */
        $this->assertEquals(count($ifd0_0->getEntries()), 32);

        $entry = $ifd0_0->getEntry(33434); // ExposureTime
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 10,
            1 => 40
        ]);
        $this->assertEquals($entry->getText(), '1/4 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 26,
            1 => 10
        ]);
        $this->assertEquals($entry->getText(), 'f/2.6');

        $entry = $ifd0_0->getEntry(34850); // ExposureProgram
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 2);
        $this->assertEquals($entry->getText(), 'Normal program');

        $entry = $ifd0_0->getEntry(34855); // ISOSpeedRatings
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 64);
        $this->assertEquals($entry->getText(), '64');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryVersion', $entry);
        $this->assertEquals($entry->getValue(), 2.2);
        $this->assertEquals($entry->getText(), 'Exif Version 2.2');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), false);
        $this->assertEquals($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), false);
        $this->assertEquals($entry->getText(), '0000:00:00 00:00:00');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $this->assertEquals($entry->getValue(), "\x01\x02\x03\0");
        $this->assertEquals($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37122); // CompressedBitsPerPixel
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 2,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '2/1');

        $entry = $ifd0_0->getEntry(37380); // ExposureBiasValue
        $this->assertInstanceOf('lsolesen\pel\PelEntrySRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 0,
            1 => 10
        ]);
        $this->assertEquals($entry->getText(), '0.0');

        $entry = $ifd0_0->getEntry(37381); // MaxApertureValue
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 28,
            1 => 10
        ]);
        $this->assertEquals($entry->getText(), '28/10');

        $entry = $ifd0_0->getEntry(37383); // MeteringMode
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 5);
        $this->assertEquals($entry->getText(), 'Pattern');

        $entry = $ifd0_0->getEntry(37384); // LightSource
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Unknown');

        $entry = $ifd0_0->getEntry(37385); // Flash
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 16);
        $this->assertEquals($entry->getText(), 'Flash did not fire, compulsory flash mode.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 213,
            1 => 10
        ]);
        $this->assertEquals($entry->getText(), '21.3 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $expected = "\x4f\x4c\x59\x4d\x50\0\x01\0\x10\0\0\x02\x04\0\x03\0\0\0\xd6\x05\0\0\x01\x02\x03\0\x01\0\0\0\x01\0\0\0\x02\x02\x03\0\x01\0\0\0\0\0\0\0\x03\x02\x03\0\x01\0\0\0\0\0\0\0\x04\x02\x05\0\x01\0\0\0\xe2\x05\0\0\x05\x02\x05\0\x01\0\0\0\xea\x05\0\0\x06\x02\x08\0\x06\0\0\0\xf2\x05\0\0\x07\x02\x02\0\x08\0\0\0\xfe\x05\0\0\x08\x02\x02\0\x34\0\0\0\x06\x06\0\0\x09\x02\x07\0\x20\0\0\0\x42\x06\0\0\0\x03\x03\0\x01\0\0\0\0\0\0\0\x01\x03\x03\0\x01\0\0\0\0\0\0\0\x02\x03\x03\0\x01\0\0\0\x01\0\0\0\x03\x03\x03\0\x01\0\0\0\0\0\0\0\x04\x03\x03\0\x01\0\0\0\0\0\0\0\0\x0f\x07\0\xfe\0\0\0\x62\x06\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x64\0\0\0\x64\0\0\0\x88\x03\0\0\x64\0\0\0\x03\0\x0d\0\x12\0\x19\0\x38\0\x49\0\x53\x58\x35\x35\x38\0\0\0\x5b\x70\x69\x63\x74\x75\x72\x65\x49\x6e\x66\x6f\x5d\x20\x52\x65\x73\x6f\x6c\x75\x74\x69\x6f\x6e\x3d\x31\x20\x5b\x43\x61\x6d\x65\x72\x61\x20\x49\x6e\x66\x6f\x5d\x20\x54\x79\x70\x65\x3d\x53\x58\x35\x35\x38\0\0\0\0\0\0\0\0\0\x4f\x4c\x59\x4d\x50\x55\x53\x20\x44\x49\x47\x49\x54\x41\x4c\x20\x43\x41\x4d\x45\x52\x41\0\xff\xff\xff\xff\xff\xff\xff\xff\xff\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x31\xcf\x13\0\0\0\0\x01\xe8\x48\0\0\x03\xb5\0\x01\xe5\xd3\0\0\x14\x55\0\0\x14\x55\x01\0\x1f\0\x0b\xa9\0\x12\x03\x31\x01\0\x01\xc0\x01\xe6\x01\xfc\x01\xe9\xd0\0\0\xe8\x11\x4a\0\0\x14\x14\0\0\0\0\0\0\0\0\0\0\0\0\0\0\x0b\x1c\0\0\x40\0\x0b\x19\0\0\0\x67\0\0\0\x67\0\xe8\x16\x49\0\0\0\x12\0\x03\xcb\xa6\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\x19\x61\x12\x31\0\x76\x01\x3f\x01\xcf\x02\x59\x01\x15\x02\0\x02\x9c\0\x30\x0b\x95\x0d\x14\x02\0\0\xc9\x03\x8b\x02\0\x01\x6e\x03\x93\x03\xed\x01\x72\x01\0\xd0\x5b\0\x0c\0\x0c\0\x02\x03\x52\0\x01\0\0\0\0\0\x09\0\x32\0\x0a\0\0\0\x01\0\x48\0\x87\0\x64\0\x78\x0e\x0e\x0e\x0e\x11\x11\x11\x11\0\0\0\0\0\0\x14\x1d\x0e\x17\0\0\x0a\0\x1b\0\0\x1a\0\0\0\0\x01\0\x32\x0f\x42\x40\x0f\0\0\x64\x2a\x20\0\0";
        $this->assertEquals($entry->getValue(), $expected);
        $this->assertEquals($entry->getText(), '600 bytes unknown MakerNote data');

        $entry = $ifd0_0->getEntry(37510); // UserComment
        $this->assertInstanceOf('lsolesen\pel\PelEntryUserComment', $entry);
        $this->assertEquals($entry->getValue(), '                                                                                                                     ');
        $this->assertEquals($entry->getText(), '                                                                                                                     ');

        $entry = $ifd0_0->getEntry(40960); // FlashPixVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryVersion', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'FlashPix Version 1.0');

        $entry = $ifd0_0->getEntry(40961); // ColorSpace
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'sRGB');

        $entry = $ifd0_0->getEntry(40962); // PixelXDimension
        $this->assertInstanceOf('lsolesen\pel\PelEntryLong', $entry);
        $this->assertEquals($entry->getValue(), 640);
        $this->assertEquals($entry->getText(), '640');

        $entry = $ifd0_0->getEntry(40963); // PixelYDimension
        $this->assertInstanceOf('lsolesen\pel\PelEntryLong', $entry);
        $this->assertEquals($entry->getValue(), 480);
        $this->assertEquals($entry->getText(), '480');

        $entry = $ifd0_0->getEntry(41728); // FileSource
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $this->assertEquals($entry->getValue(), "\x03");
        $this->assertEquals($entry->getText(), 'DSC');

        $entry = $ifd0_0->getEntry(41729); // SceneType
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $this->assertEquals($entry->getValue(), "\x01");
        $this->assertEquals($entry->getText(), 'Directly photographed');

        $entry = $ifd0_0->getEntry(41985); // CustomRendered
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Normal process');

        $entry = $ifd0_0->getEntry(41986); // ExposureMode
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Auto exposure');

        $entry = $ifd0_0->getEntry(41987); // WhiteBalance
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'Manual white balance');

        $entry = $ifd0_0->getEntry(41988); // DigitalZoomRatio
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 0,
            1 => 100
        ]);
        $this->assertEquals($entry->getText(), '0/100');

        $entry = $ifd0_0->getEntry(41990); // SceneCaptureType
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Standard');

        $entry = $ifd0_0->getEntry(41991); // GainControl
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41992); // Contrast
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41993); // Saturation
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Normal');

        $entry = $ifd0_0->getEntry(41994); // Sharpness
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Normal');

        /* Sub IFDs of $ifd0_0. */
        $this->assertEquals(count($ifd0_0->getSubIfds()), 1);
        $ifd0_0_0 = $ifd0_0->getSubIfd(4); // IFD Interoperability
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0_0_0);

        /* Start of IDF $ifd0_0_0. */
        $this->assertEquals(count($ifd0_0_0->getEntries()), 2);

        $entry = $ifd0_0_0->getEntry(1); // InteroperabilityIndex
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'R98');
        $this->assertEquals($entry->getText(), 'R98');

        $entry = $ifd0_0_0->getEntry(2); // InteroperabilityVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryVersion', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'Interoperability Version 1.0');

        /* Sub IFDs of $ifd0_0_0. */
        $this->assertEquals(count($ifd0_0_0->getSubIfds()), 0);

        $this->assertEquals($ifd0_0_0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd0_0_1 = $ifd0_0_0->getNextIfd();
        $this->assertNull($ifd0_0_1);
        /* End of IFD $ifd0_0_0. */

        $this->assertEquals($ifd0_0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd0_1 = $ifd0_0->getNextIfd();
        $this->assertNull($ifd0_1);
        /* End of IFD $ifd0_0. */

        $this->assertEquals($ifd0->getThumbnailData(), '');

        /* Next IFD. */
        $ifd1 = $ifd0->getNextIfd();
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd1);
        /* End of IFD $ifd0. */

        /* Start of IDF $ifd1. */
        $this->assertEquals(count($ifd1->getEntries()), 4);

        $entry = $ifd1->getEntry(259); // Compression
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 6);
        $this->assertEquals($entry->getText(), 'JPEG compression');

        $entry = $ifd1->getEntry(282); // XResolution
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 72,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '72/1');

        $entry = $ifd1->getEntry(283); // YResolution
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 72,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '72/1');

        $entry = $ifd1->getEntry(296); // ResolutionUnit
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 2);
        $this->assertEquals($entry->getText(), 'Inch');

        /* Sub IFDs of $ifd1. */
        $this->assertEquals(count($ifd1->getSubIfds()), 0);

        $thumb_data = file_get_contents(dirname(__FILE__) . '/olympus-c5050z-thumb.jpg');
        $this->assertEquals($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
