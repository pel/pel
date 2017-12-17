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

use \lsolesen\pel\Pel;
use \lsolesen\pel\PelOverflowException;
use PHPUnit\Framework\TestCase;

abstract class NumberTestCase extends TestCase
{
    protected $min;
    protected $max;
    protected $num;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        Pel::setStrictParsing(true);
    }

    public function testOverflow()
    {
        $this->num->setValue(0);
        $this->assertSame(0, $this->num->getValue());

        $caught = false;
        try {
            $this->num->setValue($this->min - 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertSame(0, $this->num->getValue());

        $caught = false;
        try {
            $this->num->setValue($this->max + 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertSame(0, $this->num->getValue());

        $caught = false;
        try {
            $this->num->setValue(0, $this->max + 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertSame(0, $this->num->getValue());

        $caught = false;
        try {
            $this->num->setValue(0, $this->min - 1);
        } catch (PelOverflowException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
        $this->assertSame(0, $this->num->getValue());
    }

    public function testReturnValues()
    {
        $this->num->setValue(1, 2, 3);
        $this->assertSame([1, 2, 3], $this->num->getValue());
        $this->assertSame('1, 2, 3', $this->num->getText());

        $this->num->setValue(1);
        $this->assertSame(1, $this->num->getValue());
        $this->assertSame(1, $this->num->getText());

        $this->num->setValue($this->max);
        $this->assertSame($this->max, $this->num->getValue());
        $this->assertSame($this->max, $this->num->getText());

        $this->num->setValue($this->min);
        $this->assertSame($this->min, $this->num->getValue());
        $this->assertSame($this->min, $this->num->getText());
    }
}
