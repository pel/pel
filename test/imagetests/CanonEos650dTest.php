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

use \lsolesen\pel\Pel;
use \lsolesen\pel\PelJpeg;
use PHPUnit\Framework\TestCase;

class CanonEos650dTest extends TestCase
{
    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/canon-eos-650d.jpg');

        $exif = $jpeg->getExif();
        $this->assertInstanceOf('lsolesen\pel\PelExif', $exif);

        $tiff = $exif->getTiff();
        $this->assertInstanceOf('lsolesen\pel\PelTiff', $tiff);

        /* The first IFD. */
        $ifd0 = $tiff->getIfd();
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0);

        /* Start of IDF $ifd0. */
        $this->assertEquals(count($ifd0->getEntries()), 9);

        $entry = $ifd0->getEntry(271); // Make
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'Canon');
        $this->assertEquals($entry->getText(), 'Canon');

        $entry = $ifd0->getEntry(272); // Model
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'Canon EOS 650D');
        $this->assertEquals($entry->getText(), 'Canon EOS 650D');

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

        $entry = $ifd0->getEntry(306); // DateTime
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), 1509974253);
        $this->assertEquals($entry->getText(), '2017:11:06 13:17:33');

        /* Sub IFDs of $ifd0. */
        $this->assertEquals(count($ifd0->getSubIfds()), 2);
        $ifd0_0 = $ifd0->getSubIfd(2); // IFD Exif
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0_0);

        /* Start of IDF $ifd0_0. */
        $this->assertEquals(count($ifd0_0->getEntries()), 29);

        $entry = $ifd0_0->getEntry(33434); // ExposureTime
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 1,
            1 => 800
        ]);
        $this->assertEquals($entry->getText(), '1/800 sec.');

        $entry = $ifd0_0->getEntry(33437); // FNumber
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 63,
            1 => 10
        ]);
        $this->assertEquals($entry->getText(), 'f/6.3');

        $entry = $ifd0_0->getEntry(36864); // ExifVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryVersion', $entry);
        $this->assertEquals($entry->getValue(), 2.3);
        $this->assertEquals($entry->getText(), 'Exif Version 2.3');

        $entry = $ifd0_0->getEntry(36867); // DateTimeOriginal
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), 1497623444);
        $this->assertEquals($entry->getText(), '2017:06:16 14:30:44');

        $entry = $ifd0_0->getEntry(36868); // DateTimeDigitized
        $this->assertInstanceOf('lsolesen\pel\PelEntryTime', $entry);
        $this->assertEquals($entry->getValue(), 1497623444);
        $this->assertEquals($entry->getText(), '2017:06:16 14:30:44');

        $entry = $ifd0_0->getEntry(37121); // ComponentsConfiguration
        $this->assertInstanceOf('lsolesen\pel\PelEntryUndefined', $entry);
        $this->assertEquals($entry->getValue(), "\x01\x02\x03\0");
        $this->assertEquals($entry->getText(), 'Y Cb Cr -');

        $entry = $ifd0_0->getEntry(37378); // ApertureValue
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 352256,
            1 => 65536
        ]);
        $this->assertEquals($entry->getText(), 'f/6.4');

        $entry = $ifd0_0->getEntry(37380); // ExposureBiasValue
        $this->assertInstanceOf('lsolesen\pel\PelEntrySRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 0,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '0.0');

        $entry = $ifd0_0->getEntry(37383); // MeteringMode
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 5);
        $this->assertEquals($entry->getText(), 'Pattern');

        $entry = $ifd0_0->getEntry(37385); // Flash
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 16);
        $this->assertEquals($entry->getText(), 'Flash did not fire, compulsory flash mode.');

        $entry = $ifd0_0->getEntry(37386); // FocalLength
        $this->assertInstanceOf('lsolesen\pel\PelEntryRational', $entry);
        $this->assertEquals($entry->getValue(), [
            0 => 600,
            1 => 1
        ]);
        $this->assertEquals($entry->getText(), '600.0 mm');

        $entry = $ifd0_0->getEntry(37500); // MakerNote
        $this->assertNull($entry);

        $entry = $ifd0_0->getEntry(37510); // UserComment
        $this->assertInstanceOf('lsolesen\pel\PelEntryUserComment', $entry);

        $expected = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEquals($entry->getValue(), $expected);

        $expected = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        $this->assertEquals($entry->getText(), $expected);

        $entry = $ifd0_0->getEntry(40960); // FlashPixVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryVersion', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'FlashPix Version 1.0');

        $entry = $ifd0_0->getEntry(40961); // ColorSpace
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 1);
        $this->assertEquals($entry->getText(), 'sRGB');

        $entry = $ifd0_0->getEntry(41488); // FocalPlaneResolutionUnit
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 2);
        $this->assertEquals($entry->getText(), 'Inch');

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
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Auto white balance');

        $entry = $ifd0_0->getEntry(41990); // SceneCaptureType
        $this->assertInstanceOf('lsolesen\pel\PelEntryShort', $entry);
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), 'Standard');

        /* Sub IFDs of $ifd0_0. */
        $this->assertEquals(count($ifd0_0->getSubIfds()), 2);
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
        $this->assertEquals($entry->getValue(), 0);
        $this->assertEquals($entry->getText(), '0');

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

        $thumb_data = file_get_contents(dirname(__FILE__) . '/canon-eos-650d-thumb.jpg');
        $this->assertEquals($ifd1->getThumbnailData(), $thumb_data);

        /* Next IFD. */
        $ifd2 = $ifd1->getNextIfd();
        $this->assertNull($ifd2);
        /* End of IFD $ifd1. */

        /* Start of IDF $ifd0_mn  */
        $ifd0_mn = $ifd0_0->getSubIfd(5); // IFD MakerNotes
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0_mn);

        $entry = $ifd0_mn->getEntry(6); // ImageType
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'Canon EOS 650D');

        $entry = $ifd0_mn->getEntry(7); // FirmwareVersion
        $this->assertInstanceOf('lsolesen\pel\PelEntryAscii', $entry);
        $this->assertEquals($entry->getValue(), 'Firmware Version 1.0.4');

        /* Start of IDF $ifd0_mn_cs. */
        $ifd0_mn_cs = $ifd0_mn->getSubIfd(6); // CameraSettings
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd0_mn_cs);
        $this->assertEquals(count($ifd0_mn_cs->getEntries()), 37);

        $entry = $ifd0_mn_cs->getEntry(1); // MacroMode
        $this->assertInstanceOf('lsolesen\pel\PelEntrySShort', $entry);
        $this->assertEquals($entry->getValue(), '2');
        $this->assertEquals($entry->getText(), 'Normal');

        $entry = $ifd0_mn_cs->getEntry(9); // RecordMode
        $this->assertInstanceOf('lsolesen\pel\PelEntrySShort', $entry);
        $this->assertEquals($entry->getValue(), '6');
        $this->assertEquals($entry->getText(), 'CR2');

        $entry = $ifd0_mn_cs->getEntry(22); // LensModel
        $this->assertInstanceOf('lsolesen\pel\PelEntrySShort', $entry);
        $this->assertEquals($entry->getValue(), 747);
        // Tamron 150-600mm G2
        $this->assertEquals($entry->getText(), 'Canon EF 100-400mm f/4.5-5.6L IS II USM or Tamron Lens');

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
