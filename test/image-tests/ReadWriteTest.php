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

use lsolesen\pel\Pel;
use lsolesen\pel\PelEntryByte;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelTiff;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelEntrySByte;
use lsolesen\pel\PelEntryShort;
use lsolesen\pel\PelEntrySShort;
use lsolesen\pel\PelEntryLong;
use lsolesen\pel\PelEntrySLong;
use lsolesen\pel\PelEntryAscii;

abstract class WriteEntryTestCase extends \PHPUnit_Framework_TestCase
{
    protected $entries = array();

    public function testWriteRead()
    {
        Pel::setStrictParsing(true);

        $ifd = new PelIfd(PelIfd::IFD0);
        $this->assertTrue($ifd->isLastIfd());

        foreach ($this->entries as $entry) {
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

        $jpeg = new PelJpeg(dirname(__FILE__) . '/no-exif.jpg');
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

        foreach ($this->entries as $entry) {
            $this->assertEquals($ifd->getEntry($entry->getTag())
                ->getValue(), $entry->getValue());
        }

        unlink('test-output.jpg');
    }
}

class WriteByteTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntryByte(0xF001, 0);
        $this->entries[] = new PelEntryByte(0xF002, 1);
        $this->entries[] = new PelEntryByte(0xF003, 2);
        $this->entries[] = new PelEntryByte(0xF004, 253);
        $this->entries[] = new PelEntryByte(0xF005, 254);
        $this->entries[] = new PelEntryByte(0xF006, 255);

        $this->entries[] = new PelEntryByte(0xF007, 0, 1, 2, 253, 254, 255);
        $this->entries[] = new PelEntryByte(0xF008);

        parent::__construct('PEL Byte Read/Write Tests');
    }
}

class WriteSByteTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntrySByte(0xF101, - 128);
        $this->entries[] = new PelEntrySByte(0xF102, - 127);
        $this->entries[] = new PelEntrySByte(0xF103, - 1);
        $this->entries[] = new PelEntrySByte(0xF104, 0);
        $this->entries[] = new PelEntrySByte(0xF105, 1);
        $this->entries[] = new PelEntrySByte(0xF106, 126);
        $this->entries[] = new PelEntrySByte(0xF107, 127);

        $this->entries[] = new PelEntrySByte(0xF108, - 128, - 1, 0, 1, 127);
        $this->entries[] = new PelEntrySByte(0xF109);

        parent::__construct('PEL SByte Read/Write Tests');
    }
}

class WriteShortTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntryShort(0xF201, 0);
        $this->entries[] = new PelEntryShort(0xF202, 1);
        $this->entries[] = new PelEntryShort(0xF203, 2);
        $this->entries[] = new PelEntryShort(0xF204, 65533);
        $this->entries[] = new PelEntryShort(0xF205, 65534);
        $this->entries[] = new PelEntryShort(0xF206, 65535);

        $this->entries[] = new PelEntryShort(0xF208, 0, 1, 65534, 65535);
        $this->entries[] = new PelEntryShort(0xF209);

        parent::__construct('PEL Short Read/Write Tests');
    }
}

class WriteSShortTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntrySShort(0xF301, - 32768);
        $this->entries[] = new PelEntrySShort(0xF302, - 32767);
        $this->entries[] = new PelEntrySShort(0xF303, - 1);
        $this->entries[] = new PelEntrySShort(0xF304, 0);
        $this->entries[] = new PelEntrySShort(0xF305, 1);
        $this->entries[] = new PelEntrySShort(0xF306, 32766);
        $this->entries[] = new PelEntrySShort(0xF307, 32767);

        $this->entries[] = new PelEntrySShort(0xF308, - 32768, - 1, 0, 1, 32767);
        $this->entries[] = new PelEntrySShort(0xF309);

        parent::__construct('PEL SShort Read/Write Tests');
    }
}

class WriteLongTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntryLong(0xF401, 0);
        $this->entries[] = new PelEntryLong(0xF402, 1);
        $this->entries[] = new PelEntryLong(0xF403, 2);
        $this->entries[] = new PelEntryLong(0xF404, 4294967293);
        $this->entries[] = new PelEntryLong(0xF405, 4294967294);
        $this->entries[] = new PelEntryLong(0xF406, 4294967295);

        $this->entries[] = new PelEntryLong(0xF408, 0, 1, 4294967295);
        $this->entries[] = new PelEntryLong(0xF409);

        parent::__construct('PEL Long Read/Write Tests');
    }
}

class WriteSLongTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntrySLong(0xF501, - 2147483648);
        $this->entries[] = new PelEntrySLong(0xF502, - 2147483647);
        $this->entries[] = new PelEntrySLong(0xF503, - 1);
        $this->entries[] = new PelEntrySLong(0xF504, 0);
        $this->entries[] = new PelEntrySLong(0xF505, 1);
        $this->entries[] = new PelEntrySLong(0xF506, 2147483646);
        $this->entries[] = new PelEntrySLong(0xF507, 2147483647);

        $this->entries[] = new PelEntrySLong(0xF508, - 2147483648, 0, 2147483647);
        $this->entries[] = new PelEntrySLong(0xF509);

        parent::__construct('PEL SLong Read/Write Tests');
    }
}

class WriteAsciiTestCase extends WriteEntryTestCase
{
    public function __construct()
    {
        $this->entries[] = new PelEntryAscii(0xF601);
        $this->entries[] = new PelEntryAscii(0xF602, '');
        $this->entries[] = new PelEntryAscii(0xF603, 'Hello World!');
        $this->entries[] = new PelEntryAscii(0xF604, "\x00\x01\x02...\xFD\xFE\xFF");

        parent::__construct('PEL Ascii Read/Write Tests');
    }
}
