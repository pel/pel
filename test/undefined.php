<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
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
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}

use lsolesen\pel\PelEntryUndefined;
use lsolesen\pel\PelEntryUserComment;
use lsolesen\pel\PelEntryVersion;
use lsolesen\pel\PelConvert;

class UndefinedTestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('PEL Exif Undefined Tests');
    }

    function testReturnValues()
    {
        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryUndefined::__construct()/');
        $this->expectError($pattern);
        $pattern = new PatternExpectation('/Undefined variable: tag/');
        $this->expectError($pattern);
        $entry = new PelEntryUndefined();

        $entry = new PelEntryUndefined(42);

        $entry = new PelEntryUndefined(42, 'foo bar baz');
        $this->assertEqual($entry->getComponents(), 11);
        $this->assertEqual($entry->getValue(), 'foo bar baz');
    }

    function testUsercomment()
    {
        $entry = new PelEntryUserComment();
        $this->assertEqual($entry->getComponents(), 8);
        $this->assertEqual($entry->getValue(), '');
        $this->assertEqual($entry->getEncoding(), 'ASCII');

        $entry->setValue('Hello!');
        $this->assertEqual($entry->getComponents(), 14);
        $this->assertEqual($entry->getValue(), 'Hello!');
        $this->assertEqual($entry->getEncoding(), 'ASCII');
    }

    function testVersion()
    {
        $pattern = new PatternExpectation('/Missing argument 1 for lsolesen.pel.PelEntryVersion::__construct()/');
        $this->expectError($pattern);
        $pattern = new PatternExpectation('/Undefined variable: tag/');
        $this->expectError($pattern);
        $entry = new PelEntryVersion();

        $entry = new PelEntryVersion(42);

        $this->assertEqual($entry->getValue(), 0.0);

        $entry->setValue(2.0);
        $this->assertEqual($entry->getValue(), 2.0);
        $this->assertEqual($entry->getText(false), 'Version 2.0');
        $this->assertEqual($entry->getText(true), '2.0');
        $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0200');

        $entry->setValue(2.1);
        $this->assertEqual($entry->getValue(), 2.1);
        $this->assertEqual($entry->getText(false), 'Version 2.1');
        $this->assertEqual($entry->getText(true), '2.1');
        $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0210');

        $entry->setValue(2.01);
        $this->assertEqual($entry->getValue(), 2.01);
        $this->assertEqual($entry->getText(false), 'Version 2.01');
        $this->assertEqual($entry->getText(true), '2.01');
        $this->assertEqual($entry->getBytes(PelConvert::LITTLE_ENDIAN), '0201');
    }
}
