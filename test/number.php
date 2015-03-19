<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
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
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}

use \lsolesen\pel\PelEntryByte;
use \lsolesen\pel\Pel;
use \lsolesen\pel\PelEntrySByte;
use \lsolesen\pel\PelEntryShort;
use \lsolesen\pel\PelEntrySShort;
use \lsolesen\pel\PelEntryLong;
use \lsolesen\pel\PelEntrySLong;
use \lsolesen\pel\PelEntryRational;
use \lsolesen\pel\PelEntrySRational;
use \lsolesen\pel\PelEntryUndefined;
use \lsolesen\pel\PelOverflowException;

abstract class NumberTestCase extends UnitTestCase
{

    private $min;

    private $max;

    protected $num;

    public function __construct($min, $max)
    {
        Pel::setStrictParsing(true);
        $this->min = $min;
        $this->max = $max;
        parent::__construct('PEL Exif Number Tests');
    }

    public function testOverflow()
    {
        $this->num->setValue(0);
        $this->assertEqual($this->num->getValue(), 0);

        $caught = false;
        try {
            $this->num->setValue($this->min - 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($this->num->getValue(), 0);

        $caught = false;
        try {
            $this->num->setValue($this->max + 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($this->num->getValue(), 0);

        $caught = false;
        try {
            $this->num->setValue(0, $this->max + 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($this->num->getValue(), 0);

        $caught = false;
        try {
            $this->num->setValue(0, $this->min - 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($this->num->getValue(), 0);
    }

    public function testReturnValues()
    {
        $this->num->setValue(1, 2, 3);
        $this->assertEqual($this->num->getValue(), array(
            1,
            2,
            3
        ));
        $this->assertEqual($this->num->getText(), '1, 2, 3');

        $this->num->setValue(1);
        $this->assertEqual($this->num->getValue(), 1);
        $this->assertEqual($this->num->getText(), '1');

        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryNumber::setValue()/');
        $this->expectError($pattern);
        $this->num->setValue();

        $this->num->setValue($this->max);
        $this->assertEqual($this->num->getValue(), $this->max);
        $this->assertEqual($this->num->getText(), $this->max);

        $this->num->setValue($this->min);
        $this->assertEqual($this->num->getValue(), $this->min);
        $this->assertEqual($this->num->getText(), $this->min);
    }
}

class ByteTestCase extends NumberTestCase
{

    public function __construct()
    {
        $this->num = new PelEntryByte(42);
        parent::__construct(0, 255);
    }
}

class SByteTestCase extends NumberTestCase
{

    public function __construct()
    {
        $this->num = new PelEntrySByte(42);
        parent::__construct(- 128, 127);
    }
}

class ShortTestCase extends NumberTestCase
{

    public function __construct()
    {
        $this->num = new PelEntryShort(42);
        parent::__construct(0, 65535);
    }
}

class SShortTestCase extends NumberTestCase
{

    public function __construct()
    {

        $this->num = new PelEntrySShort(42);
        parent::__construct(- 32768, 32767);
    }
}

class LongTestCase extends NumberTestCase
{

    public function __construct()
    {

        $this->num = new PelEntryLong(42);
        parent::__construct(0, 4294967295);
    }
}

class SLongTestCase extends NumberTestCase
{

    public function __construct()
    {

        $this->num = new PelEntrySLong(42);
        parent::__construct(- 2147483648, 2147483647);
    }
}

class RationalTestCase extends UnitTestCase
{

    public function __construct()
    {

        parent::__construct('PEL Exif Rational Tests');
    }

    public function testOverflow()
    {
        $entry = new PelEntryRational(42, array(
            1,
            2
        ));
        $this->assertEqual($entry->getValue(), array(
            1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                3,
                4
            ), array(
                - 1,
                2
            ), array(
                7,
                8
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                3,
                4
            ), array(
                1,
                4294967296
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                3,
                4
            ), array(
                4294967296,
                1
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            1,
            2
        ));
    }

    public function testReturnValues()
    {
        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryRational::__construct()/');
        $this->expectError($pattern);
        $pattern = new PatternExpectation('/Undefined variable: tag/');
        $this->expectError($pattern);
        $entry = new PelEntryRational();

        $entry = new PelEntryRational(42);
        $this->assertEqual($entry->getValue(), array());
        $this->assertEqual($entry->getText(), '');

        $entry->setValue(array(
            1,
            2
        ), array(
            3,
            4
        ), array(
            5,
            6
        ));
        $this->assertEqual($entry->getValue(), array(
            array(
                1,
                2
            ),
            array(
                3,
                4
            ),
            array(
                5,
                6
            )
        ));
        $this->assertEqual($entry->getText(), '1/2, 3/4, 5/6');

        $entry->setValue(array(
            7,
            8
        ));
        $this->assertEqual($entry->getValue(), array(
            7,
            8
        ));
        $this->assertEqual($entry->getText(), '7/8');

        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryNumber::setValue()/');
        $this->expectError($pattern);
        $entry->setValue();

        $entry->setValue(array(
            0,
            4294967295
        ));
        $this->assertEqual($entry->getValue(), array(
            0,
            4294967295
        ));
        $this->assertEqual($entry->getText(), '0/4294967295');
    }
}

class SRationalTestCase extends UnitTestCase
{

    public function __construct()
    {

        parent::__construct('PEL Exif SRational Tests');
    }

    public function testOverflow()
    {
        $entry = new PelEntrySRational(42, array(
            - 1,
            2
        ));
        $this->assertEqual($entry->getValue(), array(
            - 1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                - 10,
                - 20
            ), array(
                - 1,
                - 2147483649
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            - 1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                3,
                4
            ), array(
                1,
                2147483648
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            - 1,
            2
        ));

        $caught = false;
        try {
            $entry->setValue(array(
                3,
                4
            ), array(
                4294967296,
                1
            ));
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEqual($entry->getValue(), array(
            - 1,
            2
        ));
    }

    public function testReturnValues()
    {
        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntrySRational::__construct()/');
        $this->expectError($pattern);
        $pattern = new PatternExpectation('/Undefined variable: tag/');
        $this->expectError($pattern);
        $entry = new PelEntrySRational();

        $entry = new PelEntrySRational(42);
        $this->assertEqual($entry->getValue(), array());

        $entry->setValue(array(
            - 1,
            2
        ), array(
            3,
            4
        ), array(
            5,
            - 6
        ));
        $this->assertEqual($entry->getValue(), array(
            array(
                - 1,
                2
            ),
            array(
                3,
                4
            ),
            array(
                5,
                - 6
            )
        ));
        $this->assertEqual($entry->getText(), '-1/2, 3/4, -5/6');

        $entry->setValue(array(
            - 7,
            - 8
        ));
        $this->assertEqual($entry->getValue(), array(
            - 7,
            - 8
        ));
        $this->assertEqual($entry->getText(), '7/8');

        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryNumber::setValue()/');
        $this->expectError($pattern);
        $entry->setValue();

        $entry->setValue(array(
            0,
            2147483647
        ));
        $this->assertEqual($entry->getValue(), array(
            0,
            2147483647
        ));
        $this->assertEqual($entry->getText(), '0/2147483647');
    }
}
