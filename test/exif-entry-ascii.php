<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers of JPEG images using PHP.
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


class AsciiTestCase extends UnitTestCase {

  function __construct() {
    require_once('../PelExifEntryAscii.php');
    parent::__construct('PEL EXIF ASCII Tests');
  }

  function testReturnValues() {
    $entry = new PelExifEntryAscii();
    $this->assertError('Missing argument 1 for PelExifEntryAscii::__construct()');

    $entry = new PelExifEntryAscii(42);
    $this->assertNoErrors();

    $entry = new PelExifEntryAscii(42, 'foo bar baz');
    $this->assertEqual($entry->getComponents(), 12);
    $this->assertEqual($entry->getValue(), 'foo bar baz');
  }

  function testTime() {
    $entry = new PelExifEntryTime();
    $this->assertError('Missing argument 1 for PelExifEntryTime::__construct()');

    $entry = new PelExifEntryTime(42);
    $this->assertNoErrors();
    $this->assertEqual($entry->getValue(), time());
    $this->assertEqual($entry->getComponents(), 20);

    $entry = new PelExifEntryTime(42, 10);
    $this->assertEqual($entry->getValue(), 10);
    $this->assertEqual($entry->getText(), '1970:01:01 00:00:10');
  }

  function testCopyright() {
    $entry = new PelExifEntryCopyright();
    $this->assertEqual($entry->getTag(), PelExifTag::COPYRIGHT);
    $this->assertEqual($entry->getPhotographer(), '');
    $this->assertEqual($entry->getEditor(), '');
    $this->assertEqual($entry->getText(false), '');
    $this->assertEqual($entry->getText(true), '');

    $entry->setValue('A');
    $this->assertEqual($entry->getPhotographer(), 'A');
    $this->assertEqual($entry->getEditor(), '');
    $this->assertEqual($entry->getText(false), 'A (Photographer)');
    $this->assertEqual($entry->getText(true), 'A');
    $this->assertEqual($entry->getBytes(), 'A' . chr(0));

    $entry->setValue('', 'B');
    $this->assertEqual($entry->getPhotographer(), '');
    $this->assertEqual($entry->getEditor(), 'B');
    $this->assertEqual($entry->getText(false), 'B (Editor)');
    $this->assertEqual($entry->getText(true), 'B');
    $this->assertEqual($entry->getBytes(), ' ' . chr(0) . 'B' . chr(0));

    $entry->setValue('A', 'B');
    $this->assertEqual($entry->getPhotographer(), 'A');
    $this->assertEqual($entry->getEditor(), 'B');
    $this->assertEqual($entry->getText(false), 'A (Photographer) - B (Editor)');
    $this->assertEqual($entry->getText(true), 'A - B');
    $this->assertEqual($entry->getBytes(), 'A' . chr(0) . 'B' . chr(0));
  }
  
}