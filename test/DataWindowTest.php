<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004 Martin Geisler.
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

use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelConvert;
use lsolesen\pel\PelDataWindowOffsetException;
use PHPUnit\Framework\TestCase;

class DataWindowTest extends TestCase
{

    public function testReadBytes()
    {
        $window = new PelDataWindow('abcdefgh');

        $this->assertEquals($window->getSize(), 8);
        $this->assertEquals($window->getBytes(), 'abcdefgh');

        $this->assertEquals($window->getBytes(0), 'abcdefgh');
        $this->assertEquals($window->getBytes(1), 'bcdefgh');
        $this->assertEquals($window->getBytes(7), 'h');
        // $this->assertEquals($window->getBytes(8), '');

        $this->assertEquals($window->getBytes(- 1), 'h');
        $this->assertEquals($window->getBytes(- 2), 'gh');
        $this->assertEquals($window->getBytes(- 7), 'bcdefgh');
        $this->assertEquals($window->getBytes(- 8), 'abcdefgh');

        $clone = $window->getClone(2, 4);
        $this->assertEquals($clone->getSize(), 4);
        $this->assertEquals($clone->getBytes(), 'cdef');

        $this->assertEquals($clone->getBytes(0), 'cdef');
        $this->assertEquals($clone->getBytes(1), 'def');
        $this->assertEquals($clone->getBytes(3), 'f');
        // $this->assertEquals($clone->getBytes(4), '');

        $this->assertEquals($clone->getBytes(- 1), 'f');
        $this->assertEquals($clone->getBytes(- 2), 'ef');
        $this->assertEquals($clone->getBytes(- 3), 'def');
        $this->assertEquals($clone->getBytes(- 4), 'cdef');

        $caught = false;
        try {
            $clone->getBytes(0, 6);
        } catch (PelDataWindowOffsetException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
    }

    public function testReadIntegers()
    {
        $window = new PelDataWindow("\x01\x02\x03\x04", PelConvert::BIG_ENDIAN);

        $this->assertEquals($window->getSize(), 4);
        $this->assertEquals($window->getBytes(), "\x01\x02\x03\x04");

        $this->assertEquals($window->getByte(0), 0x01);
        $this->assertEquals($window->getByte(1), 0x02);
        $this->assertEquals($window->getByte(2), 0x03);
        $this->assertEquals($window->getByte(3), 0x04);

        $this->assertEquals($window->getShort(0), 0x0102);
        $this->assertEquals($window->getShort(1), 0x0203);
        $this->assertEquals($window->getShort(2), 0x0304);

        $this->assertEquals($window->getLong(0), 0x01020304);

        $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
        $this->assertEquals($window->getSize(), 4);
        $this->assertEquals($window->getBytes(), "\x01\x02\x03\x04");

        $this->assertEquals($window->getByte(0), 0x01);
        $this->assertEquals($window->getByte(1), 0x02);
        $this->assertEquals($window->getByte(2), 0x03);
        $this->assertEquals($window->getByte(3), 0x04);

        $this->assertEquals($window->getShort(0), 0x0201);
        $this->assertEquals($window->getShort(1), 0x0302);
        $this->assertEquals($window->getShort(2), 0x0403);

        $this->assertEquals($window->getLong(0), 0x04030201);
    }

    public function testReadBigIntegers()
    {
        $window = new PelDataWindow("\x89\xAB\xCD\xEF", PelConvert::BIG_ENDIAN);

        $this->assertEquals($window->getSize(), 4);
        $this->assertEquals($window->getBytes(), "\x89\xAB\xCD\xEF");

        $this->assertEquals($window->getByte(0), 0x89);
        $this->assertEquals($window->getByte(1), 0xAB);
        $this->assertEquals($window->getByte(2), 0xCD);
        $this->assertEquals($window->getByte(3), 0xEF);

        $this->assertEquals($window->getShort(0), 0x89AB);
        $this->assertEquals($window->getShort(1), 0xABCD);
        $this->assertEquals($window->getShort(2), 0xCDEF);

        $this->assertEquals($window->getLong(0), 0x89ABCDEF);

        $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
        $this->assertEquals($window->getSize(), 4);
        $this->assertEquals($window->getBytes(), "\x89\xAB\xCD\xEF");

        $this->assertEquals($window->getByte(0), 0x89);
        $this->assertEquals($window->getByte(1), 0xAB);
        $this->assertEquals($window->getByte(2), 0xCD);
        $this->assertEquals($window->getByte(3), 0xEF);

        $this->assertEquals($window->getShort(0), 0xAB89);
        $this->assertEquals($window->getShort(1), 0xCDAB);
        $this->assertEquals($window->getShort(2), 0xEFCD);

        $this->assertEquals($window->getLong(0), 0xEFCDAB89);
    }
}
