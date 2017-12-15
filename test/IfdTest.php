<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2006 Martin Geisler.
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
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryTime;
use PHPUnit\Framework\TestCase;

class IfdTest extends TestCase
{
    public function testIteratorAggretate()
    {
        $ifd = new PelIfd(PelIfd::IFD0);

        $this->assertEquals(sizeof($ifd->getIterator()), 0);

        $desc = new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, 'Hello?');
        $date = new PelEntryTime(PelTag::DATE_TIME, 12345678);

        $ifd->addEntry($desc);
        $ifd->addEntry($date);

        $this->assertEquals(sizeof($ifd->getIterator()), 2);

        $entries = [];
        foreach ($ifd as $tag => $entry) {
            $entries[$tag] = $entry;
        }

        $this->assertSame($entries[PelTag::IMAGE_DESCRIPTION], $desc);
        $this->assertSame($entries[PelTag::DATE_TIME], $date);
    }

    public function testArrayAccess()
    {
        $ifd = new PelIfd(PelIfd::IFD0);

        $this->assertEquals(sizeof($ifd->getIterator()), 0);

        $desc = new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, 'Hello?');
        $date = new PelEntryTime(PelTag::DATE_TIME, 12345678);

        $ifd[] = $desc;
        $ifd[] = $date;

        $this->assertSame($ifd[PelTag::IMAGE_DESCRIPTION], $desc);
        $this->assertSame($ifd[PelTag::DATE_TIME], $date);

        unset($ifd[PelTag::DATE_TIME]);

        $this->assertFalse(isset($ifd[PelTag::DATE_TIME]));
    }
}
