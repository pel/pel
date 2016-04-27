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
use lsolesen\pel\PelEntryTime;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelTiff;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryAscii;

class Bug3017880TestCase extends UnitTestCase
{

    function __construct()
    {
        parent::__construct('Bug3017880 Test');
    }

    function testThisDoesNotWorkAsExpected()
    {
        $filename = dirname(__FILE__) . '/images/bug3017880.jpg';
        try {
            $exif = null;
            $success = 1; // return true by default, as this function may not resave the file, but it's still success
            $resave_file = 0;
            $jpeg = new PelJpeg($filename);

            // should all exif data on photo be cleared (gd and iu will always strip it anyway, so only
            // force strip if you know the image you're branding is an original)
            // $jpeg->clearExif();

            if ($exif === null) {
                $exif = new PelExif();
                $jpeg->setExif($exif);
                $tiff = new PelTiff();
                $exif->setTiff($tiff);
            }

            $tiff = $exif->getTiff();
            $ifd0 = $tiff->getIfd();
            if ($ifd0 == null) {
                $ifd0 = new PelIfd(PelIfd::IFD0);
                $tiff->setIfd($ifd0);
            }

            $software_name = 'Example V2';
            $software = $ifd0->getEntry(PelTag::SOFTWARE);

            if ($software == null) {
                $software = new PelEntryAscii(PelTag::SOFTWARE, $software_name);
                $ifd0->addEntry($software);
                $resave_file = 1;
                echo 'null';
            } else {
                $software->setValue($software_name);
                $resave_file = 1;
                echo 'update';
            }

            if ($resave_file == 1 && ! file_put_contents($filename, $jpeg->getBytes())) {
                // if it was okay to resave the file, but it did not save correctly
                $success = 0;
            }
        } catch (Exception $e) {
            $this->fail('Test should not throw an exception');
        }
    }
}
