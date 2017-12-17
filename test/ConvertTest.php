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

use lsolesen\pel\PelConvert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{

    private $bytes = "\x00\x00\x00\x00\x01\x23\x45\x67\x89\xAB\xCD\xEF\xFF\xFF\xFF\xFF";

    public function testLongLittle()
    {
        $o = PelConvert::LITTLE_ENDIAN;

        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 0, $o), 0x00000000);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 1, $o), 0x01000000);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 2, $o), 0x23010000);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 3, $o), 0x45230100);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 4, $o), 0x67452301);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 5, $o), 0x89674523);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 6, $o), 0xAB896745);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 7, $o), 0xCDAB8967);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 8, $o), 0xEFCDAB89);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 9, $o), 0xFFEFCDAB);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 10, $o), 0xFFFFEFCD);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 11, $o), 0xFFFFFFEF);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 12, $o), 0xFFFFFFFF);
    }

    public function testLongBig()
    {
        $o = PelConvert::BIG_ENDIAN;

        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 0, $o), 0x00000000);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 1, $o), 0x00000001);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 2, $o), 0x00000123);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 3, $o), 0x00012345);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 4, $o), 0x01234567);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 5, $o), 0x23456789);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 6, $o), 0x456789AB);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 7, $o), 0x6789ABCD);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 8, $o), 0x89ABCDEF);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 9, $o), 0xABCDEFFF);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 10, $o), 0xCDEFFFFF);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 11, $o), 0xEFFFFFFF);
        $this->assertEquals(PelConvert::bytesToLong($this->bytes, 12, $o), 0xFFFFFFFF);
    }

    public function testSLongLittle()
    {
        // TODO: Does not work on 64bit systems!
        $this->markTestIncomplete(
            'Does not work on 64bit systems!'
        );
        $o = PelConvert::LITTLE_ENDIAN;

        /*
         * The easiest way to calculate the numbers to compare with, is to
         * let PHP do the arithmetic for us. When using the bit-wise
         * operators PHP will return a proper signed 32 bit integer.
         */

        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 0, $o), 0x00 << 24 | 0x00 << 16 | 0x00 << 8 | 0x00);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 1, $o), 0x01 << 24 | 0x00 << 16 | 0x00 << 8 | 0x00);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 2, $o), 0x23 << 24 | 0x01 << 16 | 0x00 << 8 | 0x00);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 3, $o), 0x45 << 24 | 0x23 << 16 | 0x01 << 8 | 0x00);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 4, $o), 0x67 << 24 | 0x45 << 16 | 0x23 << 8 | 0x01);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 5, $o), 0x89 << 24 | 0x67 << 16 | 0x45 << 8 | 0x23);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 6, $o), 0xAB << 24 | 0x89 << 16 | 0x67 << 8 | 0x45);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 7, $o), 0xCD << 24 | 0xAB << 16 | 0x89 << 8 | 0x67);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 8, $o), 0xEF << 24 | 0xCD << 16 | 0xAB << 8 | 0x89);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 9, $o), 0xFF << 24 | 0xEF << 16 | 0xCD << 8 | 0xAB);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 10, $o), 0xFF << 24 | 0xFF << 16 | 0xEF << 8 | 0xCD);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 11, $o), 0xFF << 24 | 0xFF << 16 | 0xFF << 8 | 0xEF);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 12, $o), 0xFF << 24 | 0xFF << 16 | 0xFF << 8 | 0xFF);
    }

    public function testSLongBig()
    {
        // TODO: Does not work on 64bit systems
        $this->markTestIncomplete(
            'Does not work on 64bit systems!'
        );

        $o = PelConvert::BIG_ENDIAN;

        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 0, $o), 0x00 << 24 | 0x00 << 16 | 0x00 << 8 | 0x00);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 1, $o), 0x00 << 24 | 0x00 << 16 | 0x00 << 8 | 0x01);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 2, $o), 0x00 << 24 | 0x00 << 16 | 0x01 << 8 | 0x23);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 3, $o), 0x00 << 24 | 0x01 << 16 | 0x23 << 8 | 0x45);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 4, $o), 0x01 << 24 | 0x23 << 16 | 0x45 << 8 | 0x67);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 5, $o), 0x23 << 24 | 0x45 << 16 | 0x67 << 8 | 0x89);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 6, $o), 0x45 << 24 | 0x67 << 16 | 0x89 << 8 | 0xAB);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 7, $o), 0x67 << 24 | 0x89 << 16 | 0xAB << 8 | 0xCD);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 8, $o), 0x89 << 24 | 0xAB << 16 | 0xCD << 8 | 0xEF);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 9, $o), 0xAB << 24 | 0xCD << 16 | 0xEF << 8 | 0xFF);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 10, $o), 0xCD << 24 | 0xEF << 16 | 0xFF << 8 | 0xFF);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 11, $o), 0xEF << 24 | 0xFF << 16 | 0xFF << 8 | 0xFF);
        $this->assertEquals(PelConvert::bytesToSLong($this->bytes, 12, $o), 0xFF << 24 | 0xFF << 16 | 0xFF << 8 | 0xFF);
    }

    public function testShortLittle()
    {
        $o = PelConvert::LITTLE_ENDIAN;

        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 0, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 1, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 2, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 3, $o), 0x0100);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 4, $o), 0x2301);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 5, $o), 0x4523);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 6, $o), 0x6745);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 7, $o), 0x8967);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 8, $o), 0xAB89);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 9, $o), 0xCDAB);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 10, $o), 0xEFCD);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 11, $o), 0xFFEF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 12, $o), 0xFFFF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 13, $o), 0xFFFF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 14, $o), 0xFFFF);
    }

    public function testShortBig()
    {
        $o = PelConvert::BIG_ENDIAN;

        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 0, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 1, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 2, $o), 0x0000);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 3, $o), 0x0001);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 4, $o), 0x0123);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 5, $o), 0x2345);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 6, $o), 0x4567);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 7, $o), 0x6789);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 8, $o), 0x89AB);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 9, $o), 0xABCD);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 10, $o), 0xCDEF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 11, $o), 0xEFFF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 12, $o), 0xFFFF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 13, $o), 0xFFFF);
        $this->assertEquals(PelConvert::bytesToShort($this->bytes, 14, $o), 0xFFFF);
    }

    public function testSShortLittle()
    {
        $o = PelConvert::LITTLE_ENDIAN;

        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 0, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 1, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 2, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 3, $o), 256);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 4, $o), 8961);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 5, $o), 17699);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 6, $o), 26437);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 7, $o), - 30361);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 8, $o), - 21623);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 9, $o), - 12885);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 10, $o), - 4147);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 11, $o), - 17);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 12, $o), - 1);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 13, $o), - 1);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 14, $o), - 1);
    }

    public function testSShortBig()
    {
        $o = PelConvert::BIG_ENDIAN;

        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 0, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 1, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 2, $o), 0);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 3, $o), 1);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 4, $o), 291);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 5, $o), 9029);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 6, $o), 17767);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 7, $o), 26505);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 8, $o), - 30293);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 9, $o), - 21555);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 10, $o), - 12817);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 11, $o), - 4097);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 12, $o), - 1);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 13, $o), - 1);
        $this->assertEquals(PelConvert::bytesToSShort($this->bytes, 14, $o), - 1);
    }

    public function testByte()
    {
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 0), 0x00);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 1), 0x00);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 2), 0x00);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 3), 0x00);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 4), 0x01);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 5), 0x23);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 6), 0x45);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 7), 0x67);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 8), 0x89);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 9), 0xAB);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 10), 0xCD);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 11), 0xEF);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 12), 0xFF);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 13), 0xFF);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 14), 0xFF);
        $this->assertEquals(PelConvert::bytesToByte($this->bytes, 15), 0xFF);
    }

    public function testSByte()
    {
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 0), 0);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 1), 0);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 2), 0);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 3), 0);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 4), 1);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 5), 35);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 6), 69);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 7), 103);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 8), - 119);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 9), - 85);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 10), - 51);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 11), - 17);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 12), - 1);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 13), - 1);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 14), - 1);
        $this->assertEquals(PelConvert::bytesToSByte($this->bytes, 15), - 1);
    }
}
