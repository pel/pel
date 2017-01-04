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

class Bug2979466Test extends \PHPUnit_Framework_TestCase
{
    function testThisDoesNotWorkAsExpected()
    {
        $file = dirname(__FILE__) . '/images/bug2979466.jpg';
        // TODO Out of memory
        $this->markTestIncomplete(
          'This test fails and should be fixed.'
        );
        try {
            require_once 'PelJpeg.php';
            $jpeg = new PelJpeg($file);
        } catch (Exception $e) {
            $this->fail('Test should not throw an exception');
        }
    }
}
