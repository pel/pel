<?php

/*  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler.
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

class DataWindowTestCase extends UnitTestCase {

  function __construct() {
    require_once('PelDataWindow.php');
    parent::__construct('PEL Data Window Tests');
  }

  function testReadBytes() {
    $window = new PelDataWindow('abcdefgh');

    $this->assertEqual($window->getSize(), 8);
    $this->assertEqual($window->getBytes(), 'abcdefgh');

    $this->assertEqual($window->getBytes(0), 'abcdefgh');
    $this->assertEqual($window->getBytes(1), 'bcdefgh');
    $this->assertEqual($window->getBytes(7), 'h');
    //$this->assertEqual($window->getBytes(8), '');

    $this->assertEqual($window->getBytes(-1), 'h');
    $this->assertEqual($window->getBytes(-2), 'gh');
    $this->assertEqual($window->getBytes(-7), 'bcdefgh');
    $this->assertEqual($window->getBytes(-8), 'abcdefgh');

    $clone = $window->getClone(2, 4);
    $this->assertEqual($clone->getSize(), 4);
    $this->assertEqual($clone->getBytes(), 'cdef');

    $this->assertEqual($clone->getBytes(0), 'cdef');
    $this->assertEqual($clone->getBytes(1), 'def');
    $this->assertEqual($clone->getBytes(3), 'f');
    //$this->assertEqual($clone->getBytes(4), '');

    $this->assertEqual($clone->getBytes(-1), 'f');
    $this->assertEqual($clone->getBytes(-2), 'ef');
    $this->assertEqual($clone->getBytes(-3), 'def');
    $this->assertEqual($clone->getBytes(-4), 'cdef');


    $caught = false;
    try {
      $clone->getBytes(0, 6);
    } catch (PelDataWindowOffsetException $e) {
      $caught = true;
    }
    $this->assertTrue($caught);

  }

  function testReadIntegers() {
    $window = new PelDataWindow("\x01\x02\x03\x04", PelConvert::BIG_ENDIAN);

    $this->assertEqual($window->getSize(), 4);
    $this->assertEqual($window->getBytes(), "\x01\x02\x03\x04");

    $this->assertEqual($window->getByte(0), 0x01);
    $this->assertEqual($window->getByte(1), 0x02);
    $this->assertEqual($window->getByte(2), 0x03);
    $this->assertEqual($window->getByte(3), 0x04);

    $this->assertEqual($window->getShort(0), 0x0102);
    $this->assertEqual($window->getShort(1), 0x0203);
    $this->assertEqual($window->getShort(2), 0x0304);

    $this->assertEqual($window->getLong(0), 0x01020304);

    $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
    $this->assertEqual($window->getSize(), 4);
    $this->assertEqual($window->getBytes(), "\x01\x02\x03\x04");

    $this->assertEqual($window->getByte(0), 0x01);
    $this->assertEqual($window->getByte(1), 0x02);
    $this->assertEqual($window->getByte(2), 0x03);
    $this->assertEqual($window->getByte(3), 0x04);

    $this->assertEqual($window->getShort(0), 0x0201);
    $this->assertEqual($window->getShort(1), 0x0302);
    $this->assertEqual($window->getShort(2), 0x0403);

    $this->assertEqual($window->getLong(0), 0x04030201);
  }

  function testReadBigIntegers() {
    $window = new PelDataWindow("\x89\xAB\xCD\xEF", PelConvert::BIG_ENDIAN);

    $this->assertEqual($window->getSize(), 4);
    $this->assertEqual($window->getBytes(), "\x89\xAB\xCD\xEF");

    $this->assertEqual($window->getByte(0), 0x89);
    $this->assertEqual($window->getByte(1), 0xAB);
    $this->assertEqual($window->getByte(2), 0xCD);
    $this->assertEqual($window->getByte(3), 0xEF);

    $this->assertEqual($window->getShort(0), 0x89AB);
    $this->assertEqual($window->getShort(1), 0xABCD);
    $this->assertEqual($window->getShort(2), 0xCDEF);

    $this->assertEqual($window->getLong(0), 0x89ABCDEF);

    $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
    $this->assertEqual($window->getSize(), 4);
    $this->assertEqual($window->getBytes(), "\x89\xAB\xCD\xEF");

    $this->assertEqual($window->getByte(0), 0x89);
    $this->assertEqual($window->getByte(1), 0xAB);
    $this->assertEqual($window->getByte(2), 0xCD);
    $this->assertEqual($window->getByte(3), 0xEF);

    $this->assertEqual($window->getShort(0), 0xAB89);
    $this->assertEqual($window->getShort(1), 0xCDAB);
    $this->assertEqual($window->getShort(2), 0xEFCD);

    $this->assertEqual($window->getLong(0), 0xEFCDAB89);


  }

}

?>