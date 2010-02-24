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

class Bug1730993TestCase extends UnitTestCase {

  function __construct() {
    parent::__construct('Bug1730993 Test');
  }

  function testThisDoesNotWorkAsExpected() {
    $tmpfile = dirname(__FILE__) . '/images/bug1730993_tmp.jpg';
    $bigfile = dirname(__FILE__) . '/images/bug1730993_large.jpg';

    try {
      $jpeg = new PelJpeg($tmpfile); // the error occurs here
      $exif = $jpeg->getExif();
      if ($exif != null) {
        $jpeg1 = new PelJpeg($bigfile);
        $jpeg1->setExif($exif);
        file_put_contents($bigfile, $jpeg1->getBytes());
      }
    } catch (Exception $e) {
        $this->fail('Test should not throw an exception');
    }
  }
}
