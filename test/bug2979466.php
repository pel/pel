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
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\PelJpeg;

class Bug2979466TestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('Bug2979466 Test');
    }

    function testThisDoesNotWorkAsExpected()
    {
        $file = dirname(__FILE__) . '/images/bug2979466.jpg';
        // TODO Out of memory
        return;
        try {
            require_once 'PelJpeg.php';
            $jpeg = new PelJpeg($file);
        } catch (Exception $e) {
            $this->fail('Test should not throw an exception');
        }
    }
}
