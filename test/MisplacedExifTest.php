<?php

/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2005, 2006 Martin Geisler.
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
use lsolesen\pel\PelExif;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelJpegMarker;

class MisplacedExifTest extends TestCase
{

    // NOTE: this test relies on the assumption that internal PelJpeg::sections order is kept between section
    // manipulations. It may fail it this changes.
    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        // Image contains non-EXIF APP1 section ahead of the EXIF one
        $jpeg = new PelJpeg(dirname(__FILE__) . '/broken_images/misplaced-exif.jpg');
        // Assert we just have loaded correct file for the test
        $this->assertNotInstanceOf('\lsolesen\pel\PelExif', $jpeg->getSection(PelJpegMarker::APP1));

        // Manually find exif APP1 section index
        $sections1 = $jpeg->getSections();
        $exifIdx = null;
        $idx = 0;
        foreach ($sections1 as $section) {
            if (($section[0] == PelJpegMarker::APP1) && ($section[1] instanceof PelExif)) {
                $exifIdx = $idx;
                break;
            }
            ++ $idx;
        }
        $this->assertNotNull($exifIdx);
        $newExif = new PelExif();
        $jpeg->setExif($newExif);
        // Ensure EXIF is set to correct position among sections
        $sections2 = $jpeg->getSections();
        $this->assertSame($sections1[$exifIdx][0], $sections2[$exifIdx][0]);
        $this->assertNotSame($sections1[$exifIdx][1], $sections2[$exifIdx][1]);
        $this->assertSame($newExif, $sections2[$exifIdx][1]);

        $this->assertInstanceOf('\lsolesen\pel\PelExif', $jpeg->getExif());
        $jpeg->clearExif();
        // Assert that only EXIF section is gone and all other shifted correctly.
        $sections3 = $jpeg->getSections();
        $numSections3 = count($sections3);
        for ($idx = 0; $idx < $numSections3; ++ $idx) {
            if ($idx >= $exifIdx) {
                $s2idx = $idx + 1;
            } else {
                $s2idx = $idx;
            }
            $this->assertSame($sections2[$s2idx][0], $sections3[$idx][0]);
            $this->assertSame($sections2[$s2idx][1], $sections3[$idx][1]);
        }
        $this->assertNotInstanceOf('\lsolesen\pel\PelExif', $jpeg->getExif());
    }
}
