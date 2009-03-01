<?php

/*  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004, 2005, 2006  Martin Geisler.
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

class UndefinedTestCase extends UnitTestCase {

  function __construct() {
    require_once('PelEntryUndefined.php');
    parent::__construct('PEL Exif Undefined Tests');
  }

  function testReturnValues() {
    $entry = new PelEntryUndefined();
    $pattern = new WantedPatternExpectation('/Missing argument 1 for ' .
                                            'PelEntryUndefined::__construct()/');
    $this->assertError($pattern);
    $this->assertError('Undefined variable: tag');

    $entry = new PelEntryUndefined(42);
    $this->assertNoErrors();

    $entry = new PelEntryUndefined(42, 'foo bar baz');
    $this->assertEqual($entry->getComponents(), 11);
    $this->assertEqual($entry->getValue(), 'foo bar baz');
  }

  function testUsercomment() {
    $entry = new PelEntryUserComment();
    $this->assertEqual($entry->getComponents(), 8);
    $this->assertEqual($entry->getValue(), '');
    $this->assertEqual($entry->getEncoding(), 'ASCII');

    $entry->setValue('Hello!');
    $this->assertEqual($entry->getComponents(), 14);
    $this->assertEqual($entry->getValue(), 'Hello!');
    $this->assertEqual($entry->getEncoding(), 'ASCII');
  }

  function testVersion() {
    $entry = new PelEntryVersion();
    $pattern = new WantedPatternExpectation('/Missing argument 1 for ' .
                                            'PelEntryVersion::__construct()/');
    $this->assertError($pattern);
    $this->assertError('Undefined variable: tag');

    $entry = new PelEntryVersion(42);
    $this->assertNoErrors();

    $this->assertEqual($entry->getValue(), 0.0);

    $entry->setValue(2.0);
    $this->assertEqual($entry->getValue(), 2.0);
    $this->assertEqual($entry->getText(false), 'Version 2.0');
    $this->assertEqual($entry->getText(true), '2.0');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0200');

    $entry->setValue(2.1);
    $this->assertEqual($entry->getValue(), 2.1);
    $this->assertEqual($entry->getText(false), 'Version 2.1');
    $this->assertEqual($entry->getText(true), '2.1');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0210');

    $entry->setValue(2.01);
    $this->assertEqual($entry->getValue(), 2.01);
    $this->assertEqual($entry->getText(false), 'Version 2.01');
    $this->assertEqual($entry->getText(true), '2.01');
    $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0201');

  }

}

?>