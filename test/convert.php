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


class ConvertTestCase extends UnitTestCase {

  function __construct() {
    require_once('../PelConvert.php');
    parent::__construct('PEL Conversion Tests');
  }

  function testLong() {
    $l = PelConvert::LITTLE_ENDIAN;
    $b = PelConvert::BIG_ENDIAN;

    $bytes = "\x00\x00\x00\x00";
    $this->assertEqual(PelConvert::bytesToLong($bytes, 0, $l), 0);
    $this->assertEqual(PelConvert::bytesToLong($bytes, 0, $b), 0);

    $bytes = "\xFF\xFF\xFF\xFF";
    $this->assertEqual(PelConvert::bytesToLong($bytes, 0, $l), 4294967295);
    $this->assertEqual(PelConvert::bytesToLong($bytes, 0, $b), 4294967295);
  }
  
  function testSLong() {
    $l = PelConvert::LITTLE_ENDIAN;
    $b = PelConvert::BIG_ENDIAN;
    
    $bytes = "\x00\x00\x00\x00";
    $this->assertEqual(PelConvert::bytesToSLong($bytes, 0, $l), 0);
    $this->assertEqual(PelConvert::bytesToSLong($bytes, 0, $b), 0);

    $bytes = "\xFF\xFF\xFF\xFF";
    $this->assertEqual(PelConvert::bytesToSLong($bytes, 0, $l), -1);
    $this->assertEqual(PelConvert::bytesToSLong($bytes, 0, $b), -1);
  }

  function testShort() {
    $l = PelConvert::LITTLE_ENDIAN;
    $b = PelConvert::BIG_ENDIAN;
    
    $bytes = "\x00\x00";
    $this->assertEqual(PelConvert::bytesToShort($bytes, 0, $l), 0);
    $this->assertEqual(PelConvert::bytesToShort($bytes, 0, $b), 0);

    $bytes = "\xFF\xFF";
    $this->assertEqual(PelConvert::bytesToShort($bytes, 0, $l), 65535);
    $this->assertEqual(PelConvert::bytesToShort($bytes, 0, $b), 65535);
  }
  
  function testSShort() {
    $l = PelConvert::LITTLE_ENDIAN;
    $b = PelConvert::BIG_ENDIAN;
    
    $bytes = "\x00\x00";
    $this->assertEqual(PelConvert::bytesToSShort($bytes, 0, $l), 0);
    $this->assertEqual(PelConvert::bytesToSShort($bytes, 0, $b), 0);

    $bytes = "\xFF\xFF";
    $this->assertEqual(PelConvert::bytesToSShort($bytes, 0, $l), -1);
    $this->assertEqual(PelConvert::bytesToSShort($bytes, 0, $b), -1);
  }
  

}

?>