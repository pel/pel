#!/usr/bin/php
<?php

/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * (c) 2005, 2006 Martin Geisler.
 * (c) 2020 Johannes Weberhofer
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

/*
 * This meta-program will generate a PHP script with unit tests for
 * testing the image supplied on the command line. It works by
 * loading the image, and traversing it, outputting test code at each
 * step which will verify that a future parse of the image gives the
 * same results.
 */
require_once 'autoload.php';
use lsolesen\pel\Pel;
use lsolesen\pel\PelEntry;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelJpegContent;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelTiff;

$argv = $_SERVER['argv'];

if (count($argv) != 2) {
    exit("Usage: $argv[0] <image>\n");
}

$pathInfo = pathinfo($argv[1]);

$image_filename = $argv[1];
$test_name = str_replace('-', '_', ucfirst($pathInfo['filename'])) . 'Test';
$test_filename = 'test/' . $test_name . '.php';
$indent = 0;

function println(...$args)
{
    global $indent;
    $str = array_shift($args);
    vprintf(str_repeat('    ', $indent) . $str . "\n", $args);
}

function quote($str)
{
    return str_replace([
        '\\',
        '\''
    ], [
        '\\\\',
        '\\\''
    ], $str);
}

function entryToTest($name, PelEntry $entry)
{
    println('$this->assertInstanceOf(\'\\%s\', %s);', get_class($entry), $name);

    println('$this->assertEquals(%s->getValue(), %s);', $name, var_export($entry->getValue(), true));

    println('$this->assertEquals(%s->getText(), \'%s\');', $name, quote($entry->getText()));
}

function ifdToTest($name, $number, PelIfd $ifd)
{
    println();
    println('/* Start of IDF %s%d. */', $name, $number);

    $entries = $ifd->getEntries();
    println('$this->assertEquals(count(%s%d->getEntries()), %d);', $name, $number, count($entries));

    foreach ($entries as $tag => $entry) {
        println();
        println('$entry = %s%d->getEntry(%d); // %s', $name, $number, $tag, PelTag::getName($ifd->getType(), $tag));
        entryToTest('$entry', $entry);
    }

    println();
    println('/* Sub IFDs of %s%d. */', $name, $number);

    $sub_ifds = $ifd->getSubIfds();
    println('$this->assertEquals(count(%s%d->getSubIfds()), %d);', $name, $number, count($sub_ifds));

    $n = 0;
    $sub_name = $name . $number . '_';
    foreach ($sub_ifds as $type => $sub_ifd) {
        println('%s%d = %s%d->getSubIfd(%d); // IFD %s', $sub_name, $n, $name, $number, $type, $sub_ifd->getName());
        println('$this->assertInstanceOf(\'PelIfd\', %s%d);', $sub_name, $n);
        ifdToTest($sub_name, $n, $sub_ifd);
        $n ++;
    }

    println();

    if (strlen($ifd->getThumbnailData()) > 0) {
        println('$thumb_data = file_get_contents(dirname(__FILE__) .');
        println('                                \'/%s\');', $GLOBALS['thumb_filename']);
        println('$this->assertEquals(%s%d->getThumbnailData(), $thumb_data);', $name, $number);
    } else {
        println('$this->assertEquals(%s%d->getThumbnailData(), \'\');', $name, $number);
    }

    println();
    println('/* Next IFD. */');

    $next = $ifd->getNextIfd();
    println('%s%d = %s%d->getNextIfd();', $name, $number + 1, $name, $number);

    if ($next === null) {
        println('$this->assertNull(%s%d);', $name, $number + 1);
        println('/* End of IFD %s%d. */', $name, $number);
    } else {
        println('$this->assertInstanceOf(\'\lsolesen\pel\PelIfd\', %s%d);', $name, $number + 1);
        println('/* End of IFD %s%d. */', $name, $number);

        ifdToTest($name, $number + 1, $next);
    }
}

function tiffToTest($name, PelTiff $tiff)
{
    println();
    println('/* The first IFD. */');
    println('$ifd0 = %s->getIfd();', $name);
    $ifd = $tiff->getIfd();
    if ($ifd === null) {
        println('$this->assertNull($ifd0);');
    } else {
        println('$this->assertInstanceOf(\'\lsolesen\pel\PelIfd\', $ifd0);');
        ifdToTest('$ifd', 0, $ifd);
    }
}

function jpegContentToTest($name, PelJpegContent $content)
{
    if ($content instanceof PelExif) {
        println('$this->assertInstanceOf(\'\lsolesen\pel\PelExif\', %s);', $name);
        $tiff = $content->getTiff();
        println();
        println('$tiff = %s->getTiff();', $name);
        if ($tiff === null) {
            println('$this->assertNull($tiff);');
        } else {
            println('$this->assertInstanceOf(\'\lsolesen\pel\PelTiff\', $tiff);');
            tiffToTest('$tiff', $tiff);
        }
    }
}

function jpegToTest($name, PelJpeg $jpeg)
{
    $exif = $jpeg->getExif();
    println('$exif = %s->getExif();', $name);
    if ($exif == null) {
        println('$this->assertNull($exif);');
    } else {
        jpegContentToTest('$exif', $exif);
    }
}

/**
 * convert a binary string to a sequence of hexadecimals
 */
function binstrencode($field)
{
    $field = bin2hex($field);
    $field = chunk_split($field, 2, "\\x");
    return str_replace('\x00', '\0', "\\x" . substr($field, 0, - 2));
}

/*
 * All output is buffered so that we can dump it in $test_filename at
 * the end.
 */
ob_start();

println('<?php
/*
 * PEL: PHP Exif Library. A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * (c) 2005, 2006 Martin Geisler.
 * (c) 2020 Johannes Weberhofer
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

// Autogenerated by the make-image-test.php script

namespace Pel\Test;

use PHPUnit\Framework\TestCase;
use lsolesen\pel\Pel;
use lsolesen\pel\PelJpeg;

class %s extends TestCase 
{

    function testRead() 
    {
        Pel::clearExceptions();
        Pel::setStrictParsing(false);
        $jpeg = new PelJpeg(dirname(__FILE__) . \'/images/%s\');
', $test_name, basename($image_filename), $image_filename);

$jpeg = new PelJpeg($image_filename);

$indent = 2;
jpegToTest('$jpeg', $jpeg);

println();

$exceptions = Pel::getExceptions();

if (count($exceptions) == 0) {
    println('$this->assertTrue(count(Pel::getExceptions()) == 0);');
} else {
    println('$exceptions = Pel::getExceptions();');
    for ($i = 0; $i < count($exceptions); $i ++) {
        println('$this->assertInstanceOf(\'%s\', $exceptions[%d]);', $i, get_class($exceptions[$i]));

        println('$this->assertEquals($exceptions[%d]->getMessage(),', $i);
        println('                   \'%s\');', quote($exceptions[$i]->getMessage()));
    }
}

println('
  }
}
');

/* The test case is finished -- now dump the output as a PHP file. */
file_put_contents($test_filename, ob_get_clean());
