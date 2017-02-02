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
use PHPUnit\Framework\TestCase;
use lsolesen\pel\PelJpegMarker;
use lsolesen\pel\Pel;
use lsolesen\pel\PelJpegInvalidMarkerException;

class PelJpegMarkerTest extends TestCase
{

    function testNames()
    {
        $jpegMarker = new PelJpegMarker();
        $this->assertEquals($jpegMarker::getName(PelJpegMarker::SOF0), 'SOF0');
        $this->assertEquals($jpegMarker::getName(PelJpegMarker::RST3), 'RST3');
        $this->assertEquals($jpegMarker::getName(PelJpegMarker::APP3), 'APP3');
        $this->assertEquals($jpegMarker::getName(PelJpegMarker::JPG11), 'JPG11');
        $this->assertEquals($jpegMarker::getName(100), Pel::fmt('Unknown marker: 0x%02X', 100));
    }

    function testDescriptions()
    {
        $jpegMarker = new PelJpegMarker();
        $this->assertEquals($jpegMarker::getDescription(PelJpegMarker::SOF0), 'Encoding (baseline)');
        $this->assertEquals($jpegMarker::getDescription(PelJpegMarker::RST3), Pel::fmt('Restart %d', 3));
        $this->assertEquals($jpegMarker::getDescription(PelJpegMarker::APP3), Pel::fmt('Application segment %d', 3));
        $this->assertEquals($jpegMarker::getDescription(PelJpegMarker::JPG11), Pel::fmt('Extension %d', 11));
        $this->assertEquals($jpegMarker::getDescription(100), Pel::fmt('Unknown marker: 0x%02X', 100));
    }

    /**
     * @expectedException lsolesen\pel\PelJpegInvalidMarkerException
     * @throws PelJpegInvalidMarkerException
     */
    function testInvalidMarkerException()
    {
        throw new PelJpegInvalidMarkerException(1, 2);
    }
}
