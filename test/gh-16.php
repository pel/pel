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
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelEntryWindowsString;
use lsolesen\pel\PelTag;

class Gh16TestCase extends UnitTestCase
{

    protected $file;

    function __construct()
    {
        parent::__construct('Gh-16 Test');
    }

    function setUp()
    {
        $this->file = dirname(__FILE__) . '/images/gh-16-tmp.jpg';
        $file = dirname(__FILE__) . '/images/gh-16.jpg';
        copy($file, $this->file);
    }

    function tearDown()
    {
        unlink($this->file);
    }

    function testThisDoesNotWorkAsExpected()
    {
        $subject = "Превед, медвед!";

        $data = new PelDataWindow(file_get_contents($this->file));

        if (PelJpeg::isValid($data)) {

            $jpeg = new PelJpeg();
            $jpeg->load($data);
            $exif = $jpeg->getExif();

            if (null == $exif) {
                $exif = new PelExif();
                $jpeg->setExif($exif);
                $tiff = new PelTiff();
                $exif->setTiff($tiff);
            }

            $tiff = $exif->getTiff();

            $ifd0 = $tiff->getIfd();
            if (null == $ifd0) {
                $ifd0 = new PelIfd(PelIfd::IFD0);
                $tiff->setIfd($ifd0);
            }
        }
        $ifd0->addEntry(new PelEntryWindowsString(PelTag::XP_SUBJECT, $subject));

        file_put_contents($this->file, $jpeg->getBytes());

        $jpeg = new PelJpeg($this->file);
        $exif = $jpeg->getExif();
        $tiff = $exif->getTiff();
        $ifd0 = $tiff->getIfd();
        $written_subject = $ifd0->getEntry(PelTag::XP_SUBJECT);
        $this->assertEqual($subject, $written_subject->getValue());
    }
}
