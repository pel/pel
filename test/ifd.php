<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2006 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */
if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    require_once '../autoload.php';
    require_once '../vendor/lastcraft/simpletest/autorun.php';
}
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryTime;

class IFDTestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('PEL IFD Tests');
    }

    function testIteratorAggretate()
    {
        $ifd = new PelIfd(PelIfd::IFD0);

        $this->assertEqual(sizeof($ifd->getIterator()), 0);

        $desc = new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, 'Hello?');
        $date = new PelEntryTime(PelTag::DATE_TIME, 12345678);

        $ifd->addEntry($desc);
        $ifd->addEntry($date);

        $this->assertEqual(sizeof($ifd->getIterator()), 2);

        $entries = array();
        foreach ($ifd as $tag => $entry) {
            $entries[$tag] = $entry;
        }

        $this->assertIdentical($entries[PelTag::IMAGE_DESCRIPTION], $desc);
        $this->assertIdentical($entries[PelTag::DATE_TIME], $date);
    }

    function testArrayAccess()
    {
        $ifd = new PelIfd(PelIfd::IFD0);

        $this->assertEqual(sizeof($ifd->getIterator()), 0);

        $desc = new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, 'Hello?');
        $date = new PelEntryTime(PelTag::DATE_TIME, 12345678);

        $ifd[] = $desc;
        $ifd[] = $date;

        $this->assertIdentical($ifd[PelTag::IMAGE_DESCRIPTION], $desc);
        $this->assertIdentical($ifd[PelTag::DATE_TIME], $date);

        unset($ifd[PelTag::DATE_TIME]);

        $this->assertFalse(isset($ifd[PelTag::DATE_TIME]));
    }
}

