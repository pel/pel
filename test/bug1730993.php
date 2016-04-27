<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006, 2007 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.LESSER and COPYING files that are distributed with this source code.
 */
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\PelJpeg;

class Bug1730993TestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('Bug1730993 Test');
    }

    function testThisDoesNotWorkAsExpected()
    {
        $tmpfile = dirname(__FILE__) . '/images/bug1730993_tmp.jpg';
        $bigfile = dirname(__FILE__) . '/images/bug1730993_large.jpg';
        // TODO: Should not throw exception
        return;
        try {
            require_once 'PelJpeg.php';
            $jpeg = new PelJpeg($tmpfile); // the error occurs here
            $exif = $jpeg->getExif();
            if ($exif != null) {
                $jpeg1 = new PelJpeg($bigfile);
                $jpeg1->setExif($exif);
                file_put_contents($bigfile, $jpeg1->getBytes());
            }
        } catch (Exception $e) {
            $this->fail('Test should not throw exception: ' . $e->getMessage());
        }
    }
}
