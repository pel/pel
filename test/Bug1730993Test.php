<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2006, 2007 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */

use lsolesen\pel\PelJpeg;

class Bug1730993Test extends \PHPUnit_Framework_TestCase
{
    function testThisDoesNotWorkAsExpected()
    {
        $tmpfile = dirname(__FILE__) . '/images/bug1730993_tmp.jpg';
        $bigfile = dirname(__FILE__) . '/images/bug1730993_large.jpg';
        // TODO: Should not throw exception
        $this->markTestIncomplete(
          'This test fails and should be fixed.'
        );
        try {
            require_once 'PelJpeg.php';
            $jpeg = new PelJpeg($tmpfile); // the error occurs here
            $exif = $jpeg->getExif();
            if ($exif !== null) {
                $jpeg1 = new PelJpeg($bigfile);
                $jpeg1->setExif($exif);
                file_put_contents($bigfile, $jpeg1->getBytes());
            }
        } catch (Exception $e) {
            $this->fail('Test should not throw exception: ' . $e->getMessage());
        }
    }
}
