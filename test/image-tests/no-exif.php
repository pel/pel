<?php

/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2005, 2006 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../../autoload.php';
    require_once '../../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;

class no_exif extends UnitTestCase
{

    public function __construct()
    {
        parent::__construct('PEL no-exif.jpg Tests');
    }

    public function testRead()
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . '/no-exif.jpg');

        $exif = $jpeg->getExif();
        $this->assertNull($exif);

        $this->assertTrue(count(Pel::getExceptions()) == 0);
    }
}
