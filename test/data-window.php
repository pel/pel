<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelConvert;
use lsolesen\pel\PelDataWindowOffsetException;

class DataWindowTestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('PEL Data Window Tests');
    }

    function testReadBytes()
    {
        $window = new PelDataWindow('abcdefgh');

        $this->assertEqual($window->getSize(), 8);
        $this->assertEqual($window->getBytes(), 'abcdefgh');

        $this->assertEqual($window->getBytes(0), 'abcdefgh');
        $this->assertEqual($window->getBytes(1), 'bcdefgh');
        $this->assertEqual($window->getBytes(7), 'h');
        // $this->assertEqual($window->getBytes(8), '');

        $this->assertEqual($window->getBytes(- 1), 'h');
        $this->assertEqual($window->getBytes(- 2), 'gh');
        $this->assertEqual($window->getBytes(- 7), 'bcdefgh');
        $this->assertEqual($window->getBytes(- 8), 'abcdefgh');

        $clone = $window->getClone(2, 4);
        $this->assertEqual($clone->getSize(), 4);
        $this->assertEqual($clone->getBytes(), 'cdef');

        $this->assertEqual($clone->getBytes(0), 'cdef');
        $this->assertEqual($clone->getBytes(1), 'def');
        $this->assertEqual($clone->getBytes(3), 'f');
        // $this->assertEqual($clone->getBytes(4), '');

        $this->assertEqual($clone->getBytes(- 1), 'f');
        $this->assertEqual($clone->getBytes(- 2), 'ef');
        $this->assertEqual($clone->getBytes(- 3), 'def');
        $this->assertEqual($clone->getBytes(- 4), 'cdef');

        $caught = false;
        try {
            $clone->getBytes(0, 6);
        } catch (PelDataWindowOffsetException $e) {
            $caught = true;
        }
        $this->assertTrue($caught);
    }

    function testReadIntegers()
    {
        $window = new PelDataWindow("\x01\x02\x03\x04", PelConvert::BIG_ENDIAN);

        $this->assertEqual($window->getSize(), 4);
        $this->assertEqual($window->getBytes(), "\x01\x02\x03\x04");

        $this->assertEqual($window->getByte(0), 0x01);
        $this->assertEqual($window->getByte(1), 0x02);
        $this->assertEqual($window->getByte(2), 0x03);
        $this->assertEqual($window->getByte(3), 0x04);

        $this->assertEqual($window->getShort(0), 0x0102);
        $this->assertEqual($window->getShort(1), 0x0203);
        $this->assertEqual($window->getShort(2), 0x0304);

        $this->assertEqual($window->getLong(0), 0x01020304);

        $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
        $this->assertEqual($window->getSize(), 4);
        $this->assertEqual($window->getBytes(), "\x01\x02\x03\x04");

        $this->assertEqual($window->getByte(0), 0x01);
        $this->assertEqual($window->getByte(1), 0x02);
        $this->assertEqual($window->getByte(2), 0x03);
        $this->assertEqual($window->getByte(3), 0x04);

        $this->assertEqual($window->getShort(0), 0x0201);
        $this->assertEqual($window->getShort(1), 0x0302);
        $this->assertEqual($window->getShort(2), 0x0403);

        $this->assertEqual($window->getLong(0), 0x04030201);
    }

    function testReadBigIntegers()
    {
        $window = new PelDataWindow("\x89\xAB\xCD\xEF", PelConvert::BIG_ENDIAN);

        $this->assertEqual($window->getSize(), 4);
        $this->assertEqual($window->getBytes(), "\x89\xAB\xCD\xEF");

        $this->assertEqual($window->getByte(0), 0x89);
        $this->assertEqual($window->getByte(1), 0xAB);
        $this->assertEqual($window->getByte(2), 0xCD);
        $this->assertEqual($window->getByte(3), 0xEF);

        $this->assertEqual($window->getShort(0), 0x89AB);
        $this->assertEqual($window->getShort(1), 0xABCD);
        $this->assertEqual($window->getShort(2), 0xCDEF);

        $this->assertEqual($window->getLong(0), 0x89ABCDEF);

        $window->setByteOrder(PelConvert::LITTLE_ENDIAN);
        $this->assertEqual($window->getSize(), 4);
        $this->assertEqual($window->getBytes(), "\x89\xAB\xCD\xEF");

        $this->assertEqual($window->getByte(0), 0x89);
        $this->assertEqual($window->getByte(1), 0xAB);
        $this->assertEqual($window->getByte(2), 0xCD);
        $this->assertEqual($window->getByte(3), 0xEF);

        $this->assertEqual($window->getShort(0), 0xAB89);
        $this->assertEqual($window->getShort(1), 0xCDAB);
        $this->assertEqual($window->getShort(2), 0xEFCD);

        $this->assertEqual($window->getLong(0), 0xEFCDAB89);
    }
}

