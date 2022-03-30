<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006, 2007 Martin Geisler.
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
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryRational;
use lsolesen\pel\Pel;
use lsolesen\pel\PelExif;

class Gh200Test extends TestCase
{

    public function testPelDataWindowOffsetExceptionOffsetNotWithin()
    {
        $file = dirname(__FILE__) . '/images/gh-200.jpg';

        $data = new PelDataWindow(file_get_contents($file));
        $pelJpeg = new PelJpeg($data);
        
        $this->assertInstanceOf('\lsolesen\pel\PelJpeg', $pelJpeg);
    }
}
