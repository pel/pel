<?php

/*  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004, 2006, 2007  Martin Geisler.
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
 *  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 *  Boston, MA 02110-1301 USA
 */

/* $Id$ */

set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR . get_include_path());

class AsciiTestCase extends UnitTestCase {

  function __construct() {
    include_once 'PelEntryAscii.php';
    parent::__construct('PEL Exif ASCII Tests');
  }

  function testReturnValues() {
    $entry = new PelEntryAscii();
    $pattern = new WantedPatternExpectation('/Missing argument 1 for ' .
                                            'PelEntryAscii::__construct()/');
    $this->assertError($pattern);
    $this->assertError('Undefined variable: tag');

    $entry = new PelEntryAscii(42);
    $this->assertNoErrors();

    $entry = new PelEntryAscii(42, 'foo bar baz');
    $this->assertEqual($entry->getComponents(), 12);
    $this->assertEqual($entry->getValue(), 'foo bar baz');
  }

  function testTime() {
    $arg1 = new WantedPatternExpectation('/Missing argument 1 for ' .
                                         'PelEntryTime::__construct()/');
    $arg2 = new WantedPatternExpectation('/Missing argument 2 for ' .
                                         'PelEntryTime::__construct()/');

    $entry = new PelEntryTime();
    $this->assertError($arg1);
    $this->assertError($arg2);
    $this->assertError('Undefined variable: tag');
    $this->assertError('Undefined variable: timestamp');

    $entry = new PelEntryTime(42);
    $this->assertError($arg2);
    $this->assertError('Undefined variable: timestamp');

    $entry = new PelEntryTime(42, 10);
    $this->assertNoErrors();
    $this->assertEqual($entry->getComponents(), 20);
    $this->assertEqual($entry->getValue(), 10);
    $this->assertEqual($entry->getValue(PelEntryTime::UNIX_TIMESTAMP), 10);
    $this->assertEqual($entry->getValue(PelEntryTime::EXIF_STRING),
                       '1970:01:01 00:00:10');
    $this->assertEqual($entry->getValue(PelEntryTime::JULIAN_DAY_COUNT),
                       2440588 + 10/86400);
    $this->assertEqual($entry->getText(), '1970:01:01 00:00:10');

    // Malformed Exif timestamp.
    $entry->setValue('1970!01-01 00 00 30', PelEntryTime::EXIF_STRING);
    $this->assertEqual($entry->getValue(), 30);

    $entry->setValue(2415021.75, PelEntryTime::JULIAN_DAY_COUNT);
    // This is Jan 1st 1900 at 18:00, outside the range of a UNIX
    // timestamp:
    $this->assertEqual($entry->getValue(), false);
    $this->assertEqual($entry->getValue(PelEntryTime::EXIF_STRING),
                       '1900:01:01 18:00:00');
    $this->assertEqual($entry->getValue(PelEntryTime::JULIAN_DAY_COUNT),
                       2415021.75);

    $entry->setValue('0000:00:00 00:00:00', PelEntryTime::EXIF_STRING);

    $this->assertEqual($entry->getValue(), false);
    $this->assertEqual($entry->getValue(PelEntryTime::EXIF_STRING),
                       '0000:00:00 00:00:00');
    $this->assertEqual($entry->getValue(PelEntryTime::JULIAN_DAY_COUNT),
                       0);

    $entry->setValue('9999:12:31 23:59:59', PelEntryTime::EXIF_STRING);

    $this->assertEqual($entry->getValue(), false);
    $this->assertEqual($entry->getValue(PelEntryTime::EXIF_STRING),
                       '9999:12:31 23:59:59');
    $this->assertEqual($entry->getValue(PelEntryTime::JULIAN_DAY_COUNT),
                       5373484 + 86399/86400);

    // Check day roll-over for SF bug #1699489.
    $entry->setValue('2007:04:23 23:30:00', PelEntryTime::EXIF_STRING);
    $t = $entry->getValue(PelEntryTime::UNIX_TIMESTAMP);
    $entry->setValue($t + 3600);

    $this->assertEqual($entry->getValue(PelEntryTime::EXIF_STRING),
                       '2007:04:24 00:30:00');
  }

  function testCopyright() {
    $entry = new PelEntryCopyright();
    $this->assertEqual($entry->getTag(), PelTag::COPYRIGHT);
    $value = $entry->getValue();
    $this->assertEqual($value[0], '');
    $this->assertEqual($value[1], '');
    $this->assertEqual($entry->getText(false), '');
    $this->assertEqual($entry->getText(true), '');

    $entry->setValue('A');
    $value = $entry->getValue();
    $this->assertEqual($value[0], 'A');
    $this->assertEqual($value[1], '');
    $this->assertEqual($entry->getText(false), 'A (Photographer)');
    $this->assertEqual($entry->getText(true), 'A');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN),
                       'A' . chr(0));

    $entry->setValue('', 'B');
    $value = $entry->getValue();
    $this->assertEqual($value[0], '');
    $this->assertEqual($value[1], 'B');
    $this->assertEqual($entry->getText(false), 'B (Editor)');
    $this->assertEqual($entry->getText(true), 'B');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN),
                       ' ' . chr(0) . 'B' . chr(0));

    $entry->setValue('A', 'B');
    $value = $entry->getValue();
    $this->assertEqual($value[0], 'A');
    $this->assertEqual($value[1], 'B');
    $this->assertEqual($entry->getText(false), 'A (Photographer) - B (Editor)');
    $this->assertEqual($entry->getText(true), 'A - B');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN),
                       'A' . chr(0) . 'B' . chr(0));
  }

}

?>