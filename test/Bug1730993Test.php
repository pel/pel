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

use lsolesen\pel\PelJpeg;
use PHPUnit\Framework\TestCase;

class Bug1730993Test extends TestCase
{
    function testWindowWindowExceptionIsCaught()
    {
        $tmpfile = dirname(__FILE__) . '/images/bug1730993_tmp.jpg';
        $jpeg = new PelJpeg($tmpfile);
    }

    function testWindowOffsetExceptionIsCaught()
    {
        $tmpfile = dirname(__FILE__) . '/images/27303092-d9d72838-54f6-11e7-943c-78933f9c9fbe.jpg';
        $jpeg = new PelJpeg($tmpfile);
    }
}
