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

namespace Pel\Test\imagetests;

use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;
use PHPUnit\Framework\TestCase;

class Tags1Test extends TestCase
{
    public function testTags()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(true);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/images/test-tags-1.jpg');

        $exif = $jpeg->getExif();
        $this->assertInstanceOf('\lsolesen\pel\PelExif', $exif);

        $tiff = $exif->getTiff();
        $this->assertInstanceOf('\lsolesen\pel\PelTiff', $tiff);

        $ifd0 = $tiff->getIfd();
        $this->assertInstanceOf('\lsolesen\pel\PelIfd', $ifd0);

        $ratingPercent = $ifd0->getEntry(\lsolesen\pel\PelTag::RATING_PERCENT);
        $this->assertInstanceOf('\lsolesen\pel\PelEntry', $ratingPercent);
        $this->assertEquals(78, $ratingPercent->getValue());

        $exifIfd = $ifd0->getSubIfd(\lsolesen\pel\PelIfd::EXIF);
        $this->assertInstanceOf('\lsolesen\pel\PelIfd', $exifIfd);

        $offsetTime = $exifIfd->getEntry(\lsolesen\pel\PelTag::OFFSET_TIME);
        $this->assertInstanceOf('\lsolesen\pel\PelEntry', $offsetTime);
        $this->assertEquals('-09:00', $offsetTime->getValue());

        $offsetTimeDigitized = $exifIfd->getEntry(\lsolesen\pel\PelTag::OFFSET_TIME_DIGITIZED);
        $this->assertInstanceOf('\lsolesen\pel\PelEntry', $offsetTimeDigitized);
        $this->assertEquals('-10:00', $offsetTimeDigitized->getValue());

        $offsetTimeOriginal = $exifIfd->getEntry(\lsolesen\pel\PelTag::OFFSET_TIME_ORIGINAL);
        $this->assertInstanceOf('\lsolesen\pel\PelEntry', $offsetTimeOriginal);
        $this->assertEquals('-11:00', $offsetTimeOriginal->getValue());
    }
}
