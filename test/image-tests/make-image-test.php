#!/usr/bin/php5
<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program in the file COPYING; if not, write to the
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */

if (count($argv) != 2)
  exit("Usage: $argv[0] <filename>\n");

$basename = substr($argv[1], 0, -strlen(strrchr($argv[1], '.')));
$image_filename = $argv[1];
$thumb_filename = $basename . '-thumb.jpg';
$test_filename  = $basename . '.php';
$test_name      = str_replace('-', '_', $basename);


$indent = 0;

function println(/* fmt, args... */) {
  global $indent;
  $args = func_get_args();
  $str = array_shift($args);
  vprintf(str_repeat('  ', $indent) . $str . "\n", $args);
}


function quote($str) {
  return str_replace(array('\\', '\''), array('\\\\', '\\\''), $str);
}


function entryToTest($name, PelEntry $entry) {

  switch ($entry->getTag()) {
  case PelTag::DATE_TIME:
  case PelTag::DATE_TIME_ORIGINAL:
  case PelTag::DATE_TIME_DIGITIZED:
    $format = 'Time';
    break;
  case PelTag::COPYRIGHT:
    $format = 'Copyright';
    break;
  case PelTag::EXIF_VERSION:
  case PelTag::FLASH_PIX_VERSION:
  case PelTag::INTEROPERABILITY_VERSION:
    $format = 'Version';
    break;
  case PelTag::USER_COMMENT:
    $format = 'UserComment';
  default:
    $format = PelFormat::getName($entry->getFormat());
  }

  println('$this->assertIsA(%s, \'PelEntry%s\');',
          $name, $format);

  println('$this->assertEqual(%s->getValue(), %s);',
          $name, var_export($entry->getValue(), true));

  println('$this->assertEqual(%s->getText(), \'%s\');',
          $name, quote($entry->getText()));
}


function ifdToTest($name, $number, PelIfd $ifd) {
  println();
  println('/* Start of IDF %s%d. */', $name, $number);

  $entries = $ifd->getEntries();
  println('$this->assertEqual(count(%s%d->getEntries()), %d);',
          $name, $number, count($entries));

  foreach ($entries as $tag => $entry) {
    println();
    println('$entry = %s%d->getEntry(%d); // %s',
            $name, $number, $tag, PelTag::getName($tag));
    print(entryToTest('$entry', $entry));
  }

  println();
  println('/* Sub IFDs of %s%d. */', $name, $number);

  $sub_ifds = $ifd->getSubIfds();
  println('$this->assertEqual(count(%s%d->getSubIfds()), %d);',
          $name, $number, count($sub_ifds));

  $n = 0;
  $sub_name = $name . $number . '_';
  foreach ($sub_ifds as $tag => $sub_ifd) {
    println('%s%d = %s%d->getSubIfd(%d); // %s',
            $sub_name, $n, $name, $number, $tag, PelTag::getName($tag));
    println('$this->assertIsA(%s%d, \'PelIfd\');', $sub_name, $n);
    ifdToTest($sub_name, $n, $sub_ifd);
    $n++;
  }

  println();

  if (strlen($ifd->getThumbnailData()) > 0) {
    println('$thumb_data = file_get_contents(dirname(__FILE__) .');
    println('                                \'/%s\');',
            $GLOBALS['thumb_filename']);
    println('$this->assertEqual(%s%d->getThumbnailData(), $thumb_data);',
            $name, $number);
  } else {
    println('$this->assertEqual(%s%d->getThumbnailData(), \'\');',
            $name, $number);
  }

  println();
  println('/* Next IFD. */');

  $next = $ifd->getNextIfd();
  println('%s%d = %s%d->getNextIfd();', $name, $number+1, $name, $number);

  if ($next instanceof PelIfd) {
    println('$this->assertIsA(%s%d, \'PelIfd\');', $name, $number+1);
    println('/* End of IFD %s%d. */', $name, $number);

    ifdToTest($name, $number+1, $next);
  } else {
    println('$this->assertNull(%s%d);', $name, $number+1);
    println('/* End of IFD %s%d. */', $name, $number);
  }

}


function tiffToTest($name, PelTiff $tiff) {
  println();
  println('/* The first IFD. */');
  println('$ifd0 = %s->getIfd();', $name);
  $ifd = $tiff->getIfd();
  if ($ifd instanceof PelIfd) {
    println('$this->assertIsA($ifd0, \'PelIfd\');');
    ifdToTest('$ifd', 0, $ifd);
  } else {
    println('$this->assertNull($ifd0);');
  }
}


function jpegContentToTest($name, PelJpegContent $content) {
  if ($content instanceof PelExif) {
    println('$this->assertIsA(%s, \'PelExif\');', $name);
    $tiff = $content->getTiff();
    println();
    println('$tiff = %s->getTiff();', $name);
    if ($tiff instanceof PelTiff) {
      println('$this->assertIsA($tiff, \'PelTiff\');');
      print(tiffToTest('$tiff', $tiff));
    }
  }
}


function jpegToTest($name, PelJpeg $jpeg) {
  $app1 = $jpeg->getSection(PelJpegMarker::APP1);
  println('$app1 = %s->getSection(PelJpegMarker::APP1);', $name);
  if ($app1 == null) {
    println('$this->assertNull($app1);');
  } else {
    print(jpegContentToTest('$app1', $app1));
  }
}



println('<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program in the file COPYING; if not, write to the
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */


class %s extends UnitTestCase {

  function __construct() {
    require_once(\'../PelJpeg.php\');
    parent::__construct(\'PEL %s Tests\');
  }

  function testRead() {
    $jpeg = new PelJpeg();
    $jpeg->loadFile(dirname(__FILE__) . \'/%s\');
', $test_name, $image_filename, $image_filename);

require_once('../../PelJpeg.php');
$jpeg = new PelJpeg();
$jpeg->loadFile($image_filename);

$indent = 2;
jpegToTest('$jpeg', $jpeg);

println('
  }
}

?>');

//$test_code = ob_get_clean();
//file_put_contents($test_filename, $test_code);


?>