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

use PHPUnit\Framework\TestCase;
use lsolesen\pel\Pel;
use lsolesen\pel\PelFormat;

class PelFormatTest extends TestCase
{

    public function testNames()
    {
        $pelFormat = new PelFormat();
        $this->assertEquals($pelFormat::getName(PelFormat::ASCII), 'Ascii');
        $this->assertEquals($pelFormat::getName(PelFormat::FLOAT), 'Float');
        $this->assertEquals($pelFormat::getName(PelFormat::UNDEFINED), 'Undefined');
        $this->assertEquals($pelFormat::getName(100), Pel::fmt('Unknown format: 0x%X', 100));
    }

    public function testDescriptions()
    {
        $pelFormat = new PelFormat();
        $this->assertEquals($pelFormat::getSize(PelFormat::ASCII), 1);
        $this->assertEquals($pelFormat::getSize(PelFormat::FLOAT), 4);
        $this->assertEquals($pelFormat::getSize(PelFormat::UNDEFINED), 1);
        $this->assertEquals($pelFormat::getSize(100), Pel::fmt('Unknown format: 0x%X', 100));
    }
}
