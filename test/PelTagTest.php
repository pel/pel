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

use lsolesen\pel\PelIfd;
use PHPUnit\Framework\TestCase;
use lsolesen\pel\PelTag;

class PelTagTest extends TestCase
{
    const NONEXISTENT_TAG_NAME = 'nonexistent tag name';
    const NONEXISTENT_EXIF_TAG = 0xFCFC;
    const NONEXISTENT_GPS_TAG = 0xFCFC;
    const EXIF_TAG_NAME = 'ImageDescription';
    const GPS_TAG_NAME = 'GPSLongitude';
    const EXIF_TAG = PelTag::IMAGE_DESCRIPTION;
    const GPS_TAG = PelTag::GPS_LONGITUDE;

    public function testReverseLookup()
    {
        $this->assertSame(false, PelTag::getExifTagByName(self::NONEXISTENT_TAG_NAME), 'Non-existent EXIF tag name');
        $this->assertSame(false, PelTag::getGpsTagByName(self::NONEXISTENT_TAG_NAME), 'Non-existent GPS tag name');
        $this->assertStringStartsWith(
            'Unknown: ',
            PelTag::getName(PelIfd::IFD0, self::NONEXISTENT_EXIF_TAG),
            'Non-existent EXIF tag'
        );
        $this->assertStringStartsWith(
            'Unknown: ',
            PelTag::getName(PelIfd::GPS, self::NONEXISTENT_GPS_TAG),
            'Non-existent GPS tag'
        );

        $this->assertSame(static::EXIF_TAG, PelTag::getExifTagByName(self::EXIF_TAG_NAME), 'EXIF tag name');
        $this->assertSame(static::GPS_TAG, PelTag::getGpsTagByName(self::GPS_TAG_NAME), 'GPS tag name');
        $this->assertEquals(static::EXIF_TAG_NAME, PelTag::getName(PelIfd::IFD0, self::EXIF_TAG), 'EXIF tag');
        $this->assertEquals(static::GPS_TAG_NAME, PelTag::getName(PelIfd::GPS, self::GPS_TAG), 'GPS tag');
    }
}
