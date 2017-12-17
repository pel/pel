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

namespace Pel\Test;

use \lsolesen\pel\PelEntryRational;
use \lsolesen\pel\PelOverflowException;

class NumberRationalTest extends NumberTestCase
{
    public function testOverflow()
    {
        $entry = new PelEntryRational(42, [1, 2]);
        $this->assertEquals($entry->getValue(), [1, 2]);

        $caught = false;
        try {
            $entry->setValue([3, 4], [-1, 2], [7, 8]);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEquals($entry->getValue(), [1, 2]);

        $caught = false;
        try {
            $entry->setValue([3, 4], [1, 4294967296]);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEquals($entry->getValue(), [1, 2]);

        $caught = false;
        try {
            $entry->setValue([3, 4], [4294967296, 1]);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertEquals($entry->getValue(), [1, 2]);
    }

    public function testReturnValues()
    {
        $entry = new PelEntryRational(42);
        $this->assertEquals($entry->getValue(), []);
        $this->assertEquals($entry->getText(), '');

        $entry->setValue([1, 2], [3, 4], [5, 6]);
        $this->assertEquals($entry->getValue(), [[1, 2], [3, 4], [5, 6]]);
        $this->assertEquals($entry->getText(), '1/2, 3/4, 5/6');

        $entry->setValue([7, 8]);
        $this->assertEquals($entry->getValue(), [7, 8]);
        $this->assertEquals($entry->getText(), '7/8');

        $entry->setValue([0, 4294967295]);
        $this->assertEquals($entry->getValue(), [0, 4294967295]);
        $this->assertEquals($entry->getText(), '0/4294967295');
    }
}
