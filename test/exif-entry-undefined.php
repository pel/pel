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


class UndefinedTestCase extends UnitTestCase {

  function __construct() {
    require_once('../PelExifEntryUndefined.php');
    parent::__construct('PEL EXIF Undefined Tests');
  }

  function testReturnValues() {
    $entry = new PelExifEntryUndefined();
    $this->assertError('Missing argument 1 for PelExifEntryUndefined::__construct()');

    $entry = new PelExifEntryUndefined(42);
    $this->assertNoErrors();

    $entry = new PelExifEntryUndefined(42, 'foo bar baz');
    $this->assertEqual($entry->getComponents(), 11);
    $this->assertEqual($entry->getValue(), 'foo bar baz');
  }

  function testUsercomment() {
    $entry = new PelExifEntryUserComment();
    $this->assertEqual($entry->getComponents(), 8);
    $this->assertEqual($entry->getValue(), '');
    $this->assertEqual($entry->getEncoding(), 'ASCII');

    $entry->setValue('Hello!');
    $this->assertEqual($entry->getComponents(), 14);
    $this->assertEqual($entry->getValue(), 'Hello!');
    $this->assertEqual($entry->getEncoding(), 'ASCII');
  }

  function testVersion() {
    $entry = new PelExifEntryVersion();
    $this->assertError('Missing argument 1 for PelExifEntryVersion::__construct()');

    $entry = new PelExifEntryVersion(42);
    $this->assertNoErrors();

    $this->assertEqual($entry->getValue(), 0.0);

    $entry->setValue(2.01);
    $this->assertEqual($entry->getValue(), 2.01);
    $this->assertEqual($entry->getText(false), 'Version 2.01');
    $this->assertEqual($entry->getText(true), '2.01');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0201');

    $entry->setValue(2.1);
    $this->assertEqual($entry->getValue(), 2.1);
    $this->assertEqual($entry->getText(false), 'Version 2.1');
    $this->assertEqual($entry->getText(true), '2.1');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0210');
  }
  
}