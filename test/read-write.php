<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program in the file COPYING; if not, write to the
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */


abstract class WriteEntryTestCase extends UnitTestCase {

  protected $entries = array();

  function testWriteRead() {

    $ifd = new PelIfd();
    $this->assertTrue($ifd->isLastIfd());

    foreach ($this->entries as $entry) {
      $ifd->addEntry($entry);
    }

    $tiff = new PelTiff();
    $this->assertNull($tiff->getIfd());
    $tiff->setIfd($ifd);
    $this->assertNotNull($tiff->getIfd());

    $app1 = new PelExif();
    $this->assertNull($app1->getTiff());
    $app1->setTiff($tiff);
    $this->assertNotNull($app1->getTiff());


    $jpeg = new PelJpeg();
    $jpeg->loadFile('images/no-exif.jpg');

    $this->assertNull($jpeg->getSection(PelJpegMarker::APP1));
    $jpeg->insertSection(PelJpegMarker::APP1, $app1, 2);
    $this->assertNotNull($jpeg->getSection(PelJpegMarker::APP1));

    file_put_contents('test-output.jpg', $jpeg->getBytes());
    $this->assertTrue(file_exists('test-output.jpg'));
    $this->assertTrue(filesize('test-output.jpg') > 0);

    /* Now read the file and see if the entries are still there. */

    $jpeg = new PelJpeg();
    $jpeg->loadFile('test-output.jpg');
    
    $app1 = $jpeg->getSection(PelJpegMarker::APP1);
    $tiff = $app1->getTiff();

    $ifd = $tiff->getIfd();
    $this->assertTrue($ifd->isLastIfd());

    foreach ($this->entries as $entry) {
      $this->assertEqual($ifd->getEntry($entry->getTag())->getValue(),
                         $entry->getValue());
    }

    unlink('test-output.jpg');
  }

}

/* The just defined class should be ignored by SimpleTest since it's
 * an abstract base class for the real tests defined below. */
SimpleTestOptions::ignore('WriteEntryTestCase');


class WriteByteTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryByte.php');

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

class WriteSByteTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryByte.php');

    $this->entries[] = new PelEntrySByte(0xF101, -128);
    $this->entries[] = new PelEntrySByte(0xF102, -127);
    $this->entries[] = new PelEntrySByte(0xF103, -1);
    $this->entries[] = new PelEntrySByte(0xF104, 0);
    $this->entries[] = new PelEntrySByte(0xF105, 1);
    $this->entries[] = new PelEntrySByte(0xF106, 126);
    $this->entries[] = new PelEntrySByte(0xF107, 127);

    $this->entries[] = new PelEntrySByte(0xF108, -128, -1, 0, 1, 127);
    $this->entries[] = new PelEntrySByte(0xF109);

    parent::__construct('PEL SByte Read/Write Tests');
  }
}

class WriteShortTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryShort.php');

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

class WriteSShortTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryShort.php');

    $this->entries[] = new PelEntrySShort(0xF301, -32768);
    $this->entries[] = new PelEntrySShort(0xF302, -32767);
    $this->entries[] = new PelEntrySShort(0xF303, -1);
    $this->entries[] = new PelEntrySShort(0xF304, 0);
    $this->entries[] = new PelEntrySShort(0xF305, 1);
    $this->entries[] = new PelEntrySShort(0xF306, 32766);
    $this->entries[] = new PelEntrySShort(0xF307, 32767);

    $this->entries[] = new PelEntrySShort(0xF308, -32768, -1, 0, 1, 32767);
    $this->entries[] = new PelEntrySShort(0xF309);

    parent::__construct('PEL SShort Read/Write Tests');
  }
}

class WriteLongTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryLong.php');

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

class WriteSLongTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryLong.php');

    $this->entries[] = new PelEntrySLong(0xF501, -2147483648);
    $this->entries[] = new PelEntrySLong(0xF502, -2147483647);
    $this->entries[] = new PelEntrySLong(0xF503, -1);
    $this->entries[] = new PelEntrySLong(0xF504, 0);
    $this->entries[] = new PelEntrySLong(0xF505, 1);
    $this->entries[] = new PelEntrySLong(0xF506, 2147483646);
    $this->entries[] = new PelEntrySLong(0xF507, 2147483647);

    $this->entries[] = new PelEntrySLong(0xF508, -2147483648, 0, 2147483647);
    $this->entries[] = new PelEntrySLong(0xF509);

    parent::__construct('PEL SLong Read/Write Tests');
  }
}

class WriteAsciiTestCase extends WriteEntryTestCase {
  function __construct() {
    require_once('../PelEntryAscii.php');

    $this->entries[] = new PelEntryAscii(0xF601);
    $this->entries[] = new PelEntryAscii(0xF602, '');
    $this->entries[] = new PelEntryAscii(0xF603, 'Hello World!');

    $this->entries[] = new PelEntryTime(PelTag::DATE_TIME);
    $this->entries[] = new PelEntryTime(PelTag::DATE_TIME_ORIGINAL, 0);
    $this->entries[] = new PelEntryTime(PelTag::DATE_TIME_DIGITIZED,
                                        123456789);

    $this->entries[] = new PelEntryCopyright(PelTag::COPYRIGHT, 'Foo', 'Bar');

    parent::__construct('PEL Ascii Read/Write Tests');
  }
}



?>