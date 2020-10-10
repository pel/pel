<?php

/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006, 2007 Martin Geisler.
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

namespace Pel\Test;

use lsolesen\pel\Pel;
use lsolesen\pel\PelEntryByte;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelTiff;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelFormat;
use lsolesen\pel\PelEntrySByte;
use lsolesen\pel\PelEntryShort;
use lsolesen\pel\PelEntrySShort;
use lsolesen\pel\PelEntryLong;
use lsolesen\pel\PelEntrySLong;
use lsolesen\pel\PelEntryAscii;
use PHPUnit\Framework\TestCase;

class WriteEntryTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        Pel::setStrictParsing(true);
    }

    /**
     * @dataProvider writeEntryProvider
     */
    public function testWriteRead(array $entries)
    {
        $ifd = new PelIfd(PelIfd::IFD0);
        $this->assertTrue($ifd->isLastIfd());

        foreach ($entries as $entry) {
            $ifd->addEntry($entry);
        }

        $tiff = new PelTiff();
        $this->assertNull($tiff->getIfd());
        $tiff->setIfd($ifd);
        $this->assertNotNull($tiff->getIfd());

        $exif = new PelExif();
        $this->assertNull($exif->getTiff());
        $exif->setTiff($tiff);
        $this->assertNotNull($exif->getTiff());

        $jpeg = new PelJpeg(dirname(__FILE__) . '/images/no-exif.jpg');
        $this->assertNull($jpeg->getExif());
        $jpeg->setExif($exif);
        $this->assertNotNull($jpeg->getExif());

        $jpeg->saveFile('test-output.jpg');
        $this->assertTrue(file_exists('test-output.jpg'));
        $this->assertTrue(filesize('test-output.jpg') > 0);

        /* Now read the file and see if the entries are still there. */
        $jpeg = new PelJpeg('test-output.jpg');

        $exif = $jpeg->getExif();
        $this->assertInstanceOf('lsolesen\pel\PelExif', $exif);

        $tiff = $exif->getTiff();
        $this->assertInstanceOf('lsolesen\pel\PelTiff', $tiff);

        $ifd = $tiff->getIfd();
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd);

        $this->assertEquals($ifd->getType(), PelIfd::IFD0);
        $this->assertTrue($ifd->isLastIfd());

        foreach ($entries as $entry) {
            $ifdEntry = $ifd->getEntry($entry->getTag());
            if ($ifdEntry->getFormat() == PelFormat::ASCII) {
                $ifdValue = $ifd->getEntry($entry->getTag())->getValue();
                $entryValue = $entry->getValue();
                // cut off after the first nul byte
                // since $ifdValue comes from parsed ifd,
                // it is already cut off
                $canonicalEntry = strstr($entryValue, "\0", true);
                // if no nul byte found, use original value
                if ($canonicalEntry === false) {
                    $canonicalEntry = $entryValue;
                }
                $this->assertEquals($ifdValue, $canonicalEntry);
            } else {
                $this->assertEquals($ifdEntry
                ->getValue(), $entry->getValue());
            }
        }

        unlink('test-output.jpg');
    }

    public function writeEntryProvider()
    {
        return [
            'PEL Byte Read/Write Tests' => [
                [
                    new PelEntryByte(0xF001, 0),
                    new PelEntryByte(0xF002, 1),
                    new PelEntryByte(0xF003, 2),
                    new PelEntryByte(0xF004, 253),
                    new PelEntryByte(0xF005, 254),
                    new PelEntryByte(0xF006, 255),
                    new PelEntryByte(0xF007, 0, 1, 2, 253, 254, 255),
                    new PelEntryByte(0xF008),
                ],
            ],
            'PEL SByte Read/Write Tests' => [
                [
                    new PelEntrySByte(0xF101, - 128),
                    new PelEntrySByte(0xF102, - 127),
                    new PelEntrySByte(0xF103, - 1),
                    new PelEntrySByte(0xF104, 0),
                    new PelEntrySByte(0xF105, 1),
                    new PelEntrySByte(0xF106, 126),
                    new PelEntrySByte(0xF107, 127),
                    new PelEntrySByte(0xF108, - 128, - 1, 0, 1, 127),
                    new PelEntrySByte(0xF109),
                ],
            ],
            'PEL Short Read/Write Tests' => [
                [
                    new PelEntryShort(0xF201, 0),
                    new PelEntryShort(0xF202, 1),
                    new PelEntryShort(0xF203, 2),
                    new PelEntryShort(0xF204, 65533),
                    new PelEntryShort(0xF205, 65534),
                    new PelEntryShort(0xF206, 65535),
                    new PelEntryShort(0xF208, 0, 1, 65534, 65535),
                    new PelEntryShort(0xF209),
                ],
            ],
            'PEL SShort Read/Write Tests' => [
                [
                    new PelEntrySShort(0xF301, - 32768),
                    new PelEntrySShort(0xF302, - 32767),
                    new PelEntrySShort(0xF303, - 1),
                    new PelEntrySShort(0xF304, 0),
                    new PelEntrySShort(0xF305, 1),
                    new PelEntrySShort(0xF306, 32766),
                    new PelEntrySShort(0xF307, 32767),
                    new PelEntrySShort(0xF308, - 32768, - 1, 0, 1, 32767),
                    new PelEntrySShort(0xF309),
                ],
            ],
            'PEL Long Read/Write Tests' => [
                [
                    new PelEntryLong(0xF401, 0),
                    new PelEntryLong(0xF402, 1),
                    new PelEntryLong(0xF403, 2),
                    new PelEntryLong(0xF404, 4294967293),
                    new PelEntryLong(0xF405, 4294967294),
                    new PelEntryLong(0xF406, 4294967295),
                    new PelEntryLong(0xF408, 0, 1, 4294967295),
                    new PelEntryLong(0xF409),
                ],
            ],
            'PEL SLong Read/Write Tests' => [
                [
                    new PelEntrySLong(0xF501, - 2147483648),
                    new PelEntrySLong(0xF502, - 2147483647),
                    new PelEntrySLong(0xF503, - 1),
                    new PelEntrySLong(0xF504, 0),
                    new PelEntrySLong(0xF505, 1),
                    new PelEntrySLong(0xF506, 2147483646),
                    new PelEntrySLong(0xF507, 2147483647),
                    new PelEntrySLong(0xF508, - 2147483648, 0, 2147483647),
                    new PelEntrySLong(0xF509),
                ],
            ],
            'PEL Ascii Read/Write Tests' => [
                [
                    new PelEntryAscii(0xF601),
                    new PelEntryAscii(0xF602, ''),
                    new PelEntryAscii(0xF603, 'Hello World!'),
                    new PelEntryAscii(0xF604, "\x00\x01\x02...\xFD\xFE\xFF"),
                ],
            ],
        ];
    }

    /**
     * Tests loading and writing back a TIFF image file.
     */
    public function testTiffLoadSave()
    {
        $file_uri = dirname(__FILE__) . '/images/sample-1.tiff';

        $data = @exif_read_data($file_uri);
        $this->assertEquals(1, $data['Orientation']);
        $this->assertEquals(2, $data['PhotometricInterpretation']);

        $tiff = new PelTiff($file_uri);
        $ifd = $tiff->getIfd();
        $this->assertInstanceOf('lsolesen\pel\PelIfd', $ifd);
        $orientation = $ifd->getEntry(PelTag::ORIENTATION);
        $this->assertEquals(1, $orientation->getValue());
        $photometric_interpretation = $ifd->getEntry(PelTag::PHOTOMETRIC_INTERPRETATION);
        $this->assertEquals(2, $photometric_interpretation->getValue());
        $bits_per_sample = $ifd->getEntry(PelTag::BITS_PER_SAMPLE);
        $this->assertEquals([8, 8, 8, 8], $bits_per_sample->getValue());

        $orientation->setValue(4);
        $photometric_interpretation->setValue(4);
        $bits_per_sample->setValueArray([7, 6, 5, 4]);

        $out_uri = dirname(__FILE__) . '/images/output.sample-1.tiff';
        $tiff->saveFile($out_uri);

        $data_reload = @exif_read_data($out_uri);
        $this->assertEquals(4, $data_reload['Orientation']);
        $this->assertEquals(4, $data_reload['PhotometricInterpretation']);
        $this->assertEquals([7, 6, 5, 4], $data_reload['BitsPerSample']);
        unlink($out_uri);
    }
}
