<?php
/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006, 2007 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\PelJpeg;

class Gh21TestCase extends UnitTestCase
{

    protected $file;

    function __construct()
    {
        parent::__construct('Gh-21 Test');
    }

    function setUp()
    {
        $this->file = dirname(__FILE__) . '/images/gh-21-tmp.jpg';
        $file = dirname(__FILE__) . '/images/gh-21.jpg';
        copy($file, $this->file);
    }

    function tearDown()
    {
        unlink($this->file);
    }

    function testThisDoesNotWorkAsExpected()
    {
        $scale = 0.75;
        $input_jpeg = new PelJpeg($this->file);

        $original = ImageCreateFromString($input_jpeg->getBytes());
        $original_w = ImagesX($original);
        $original_h = ImagesY($original);

        $scaled_w = $original_w * $scale;
        $scaled_h = $original_h * $scale;

        $scaled = ImageCreateTrueColor($scaled_w, $scaled_h);
        ImageCopyResampled($scaled, $original, 0, 0, /* dst (x,y) */
                  0, 0, /* src (x,y) */
                  $scaled_w, $scaled_h, $original_w, $original_h);

        $output_jpeg = new PelJpeg($scaled);

        $exif = $input_jpeg->getExif();

        if ($exif != null)
            $output_jpeg->setExif($exif);

        file_put_contents($this->file, $output_jpeg->getBytes());

        $jpeg = new PelJpeg($this->file);
        $exifin = $jpeg->getExif();
        $this->assertEqual($exif, $exifin);
    }
}


