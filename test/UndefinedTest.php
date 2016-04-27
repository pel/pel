<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */

use lsolesen\pel\PelEntryUndefined;
use lsolesen\pel\PelEntryUserComment;
use lsolesen\pel\PelEntryVersion;
use lsolesen\pel\PelConvert;

class UndefinedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException              PHPUnit_Framework_Error
     * @expectedExceptionMessageRegExp /Missing argument 1 for lsolesen.pel.PelEntryUndefined::__construct()/
     */
    function testPelEntryConstructorWithoutArguments()
    {
        $entry = new PelEntryUndefined();
    }

    function testReturnValues()
    {
        $entry = new PelEntryUndefined(42);

        $entry = new PelEntryUndefined(42, 'foo bar baz');
        $this->assertEquals($entry->getComponents(), 11);
        $this->assertEquals($entry->getValue(), 'foo bar baz');
    }

    function testUsercomment()
    {
        $entry = new PelEntryUserComment();
        $this->assertEquals($entry->getComponents(), 8);
        $this->assertEquals($entry->getValue(), '');
        $this->assertEquals($entry->getEncoding(), 'ASCII');

        $entry->setValue('Hello!');
        $this->assertEquals($entry->getComponents(), 14);
        $this->assertEquals($entry->getValue(), 'Hello!');
        $this->assertEquals($entry->getEncoding(), 'ASCII');
    }

    /**
     * @expectedException              PHPUnit_Framework_Error
     * @expectedExceptionMessageRegExp /Missing argument 1 for lsolesen.pel.PelEntryVersion::__construct()/
     */
    function testVersionWithoutArgument()
    {
        $entry = new PelEntryVersion();
    }

    function testVersion()
    {
        $entry = new PelEntryVersion(42);

        $this->assertEquals($entry->getValue(), 0.0);

        $entry->setValue(2.0);
        $this->assertEquals($entry->getValue(), 2.0);
        $this->assertEquals($entry->getText(false), 'Version 2.0');
        $this->assertEquals($entry->getText(true), '2.0');
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0200');

        $entry->setValue(2.1);
        $this->assertEquals($entry->getValue(), 2.1);
        $this->assertEquals($entry->getText(false), 'Version 2.1');
        $this->assertEquals($entry->getText(true), '2.1');
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0210');

        $entry->setValue(2.01);
        $this->assertEquals($entry->getValue(), 2.01);
        $this->assertEquals($entry->getText(false), 'Version 2.01');
        $this->assertEquals($entry->getText(true), '2.01');
        $this->assertEquals($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0201');
    }
}
