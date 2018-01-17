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

use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;
use lsolesen\pel\Pel;
use lsolesen\pel\PelTag;
use PHPUnit\Framework\TestCase;

class GH77Test extends TestCase
{
    public function testReturnModul()
    {
        
        $file = dirname(__FILE__) . '/images/gh-77.jpg';

        $input_jpeg = new PelJpeg($file);
        $app1 = $input_jpeg->getExif();

        $tiff = $app1->getTiff();
        $ifd0 = $tiff->getIfd();
        
        $model = $ifd0->getEntry(PelTag::MODEL);
        
        $this->assertEquals($model->getValue(), "Canon EOS 5D Mark III");
    }
}
