<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006 Martin Geisler.
 * Copyright (C) 2017 Johannes Weberhofer
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
use lsolesen\pel\PelEntryWindowsString;
use lsolesen\pel\PelTag;
use PHPUnit\Framework\TestCase;

class PelEntryWindowsStringTest extends TestCase
{

    public function testWindowsString()
    {
        $test_str = 'Tést';
        $test_str_ucs2 = mb_convert_encoding($test_str, 'UCS-2LE', 'auto');
        $test_str_ucs2_zt = $test_str_ucs2 . PelEntryWindowsString::ZEROES;

        $entry = new PelEntryWindowsString(PelTag::XP_TITLE, $test_str);
        $this->assertNotEquals($entry->getValue(), $entry->getBytes(PelConvert::LITTLE_ENDIAN));
        $this->assertEquals($entry->getValue(), $test_str);
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), $test_str_ucs2_zt);

        // correct zero-terminated data from the exif
        $entry->setValue($test_str_ucs2_zt, true);
        $this->assertNotEquals($entry->getValue(), $entry->getBytes(PelConvert::LITTLE_ENDIAN));
        $this->assertEquals($entry->getValue(), $test_str);
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), $test_str_ucs2_zt);

        // incorrect data from exif
        $entry->setValue($test_str_ucs2, true);
        $this->assertNotEquals($entry->getValue(), $entry->getBytes(PelConvert::LITTLE_ENDIAN));
        $this->assertEquals($entry->getValue(), $test_str);
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), $test_str_ucs2_zt);
    }
}
