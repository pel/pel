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

use lsolesen\pel\PelJpeg;
use PHPUnit\Framework\TestCase;

class GH21Test extends TestCase
{

    protected $file;

    public function setUp(): void
    {
        $this->file = dirname(__FILE__) . '/images/gh-21-tmp.jpg';
        $file = dirname(__FILE__) . '/images/gh-21.jpg';
        copy($file, $this->file);
    }

    public function tearDown(): void
    {
        unlink($this->file);
    }

    public function testThisDoesNotWorkAsExpected()
    {
        $scale = 0.75;
        $input_jpeg = new PelJpeg($this->file);

        $original = ImageCreateFromString($input_jpeg->getBytes());

        $this->assertNotFalse($original, 'New image must not be false');

        $original_w = ImagesX($original);
        $original_h = ImagesY($original);

        $scaled_w = (int) ($original_w * $scale);
        $scaled_h = (int) ($original_h * $scale);

        $scaled = ImageCreateTrueColor($scaled_w, $scaled_h);
        $this->assertNotFalse($scaled, 'Resized image must not be false');

        ImageCopyResampled($scaled, $original, 0, 0, 0, 0, $scaled_w, $scaled_h, $original_w, $original_h);

        $output_jpeg = new PelJpeg($scaled);

        $exif = $input_jpeg->getExif();

        if ($exif !== null) {
            $output_jpeg->setExif($exif);
        }

        file_put_contents($this->file, $output_jpeg->getBytes());

        $jpeg = new PelJpeg($this->file);
        $exifin = $jpeg->getExif();
        $this->assertEquals($exif, $exifin);
    }
}
