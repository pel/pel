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


abstract class NumberTestCase extends UnitTestCase {

  private $min;
  private $max;
  protected $num;

  function __construct($min, $max) {
    $this->min = $min;
    $this->max = $max;
    parent::__construct('PEL Exif Number Tests');
  }
  
  function testOverflow() {
    $this->num->setValue(0);
    $this->assertEqual($this->num->getValue(), 0);

    $caught = false;
    try {
      $this->num->setValue($this->min-1);
    } catch (PelOverflowException $e) {
      $caught = true;
    }
    $this->assertTrue($caught);
    $this->assertEqual($this->num->getValue(), 0);

    $caught = false;
    try {
      $this->num->setValue($this->max+1);
    } catch (PelOverflowException $e) {
      $caught = true;
    }
    $this->assertTrue($caught);
    $this->assertEqual($this->num->getValue(), 0);

    $caught = false;
    try {
      $this->num->setValue(0, $this->max+1);
    } catch (PelOverflowException $e) {
      $caught = true;
    }
    $this->assertTrue($caught);
    $this->assertEqual($this->num->getValue(), 0);

    $caught = false;
    try {
      $this->num->setValue(0, $this->min-1);
    } catch (PelOverflowException $e) {
      $caught = true;
    }
    $this->assertTrue($caught);
    $this->assertEqual($this->num->getValue(), 0);

  }


  function testReturnValues() {
    $this->num->setValue(1, 2, 3);
    $this->assertEqual($this->num->getValue(), array(1, 2, 3));
    
    $this->num->setValue(1);
    $this->assertEqual($this->num->getValue(), 1);

    $this->num->setValue();
    $this->assertEqual($this->num->getValue(), array());

    $this->num->setValue($this->max);
    $this->assertEqual($this->num->getValue(), $this->max);

    $this->num->setValue($this->min);
    $this->assertEqual($this->num->getValue(), $this->min);
  }

}

/* The just defined class should be ignored by SimpleTest since it's
 * an abstract base class for the real tests defined below. */
SimpleTestOptions::ignore('NumberTestCase');

class ByteTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryByte.php');
    $this->num = new PelEntryByte(42);
    parent::__construct(0, 255);
  }
}

class SByteTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryByte.php');
    $this->num = new PelEntrySByte(42);
    parent::__construct(-128, 127);
  }
}

class ShortTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryShort.php');
    $this->num = new PelEntryShort(42);
    parent::__construct(0, 65535);
  }
}

class SShortTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryShort.php');
    $this->num = new PelEntrySShort(42);
    parent::__construct(-32768, 32767);
  }
}

class LongTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryLong.php');
    $this->num = new PelEntryLong(42);
    parent::__construct(0, 4294967295);
  }
}

class SLongTestCase extends NumberTestCase {
  function __construct() {
    require_once('../PelEntryLong.php');
    $this->num = new PelEntrySLong(42);
    parent::__construct(-2147483648, 2147483647);
  }
}

?>