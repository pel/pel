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


class NikonCoolscanIV extends UnitTestCase {

  function __construct() {
    require_once('../PelJpeg.php');
    parent::__construct('PEL Nikon Coolscan IV Tests');
  }

  function testRead() {
    //define('PEL_DEBUG', true);

    $data = new PelDataWindow(file_get_contents('images/nikon-coolscan-iv.jpg'));
    $jpeg = new PelJpeg($data);

    /* The first IFD. */
    $app1 = $jpeg->getSection(PelJpegMarker::APP1);
    $ifd0 = $app1->getTiff()->getIfd();
    $this->assertNotNull($ifd0);

    $entry = $ifd0->getEntry(PelTag::MAKE);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'Nikon');
    $this->assertEqual($entry->getText(), 'Nikon');

    $entry = $ifd0->getEntry(PelTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(2000, 1));
    $this->assertEqual($entry->getText(), '2000/1');

    $entry = $ifd0->getEntry(PelTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(2000, 1));
    $this->assertEqual($entry->getText(), '2000/1');

    $entry = $ifd0->getEntry(PelTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd0->getEntry(PelTag::DATE_TIME);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(22, 24, 35, 7, 16, 2004));
    $this->assertEqual($entry->getText(), '2004:07:16 22:24:35');
    
    $entry = $ifd0->getEntry(PelTag::YCBCR_POSITIONING);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'centered');


    /* The EXIF sub IFD. */
    $exif = $ifd0->getSubIfd(PelTag::EXIF_IFD_POINTER);
    $this->assertNotNull($exif);

    $entry = $exif->getEntry(PelTag::EXIF_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 2.1);
    $this->assertEqual($entry->getText(), 'Exif Version 2.1');

    $entry = $exif->getEntry(PelTag::COMPONENTS_CONFIGURATION);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), "\1\2\3\0");
    $this->assertEqual($entry->getText(), 'Y Cb Cr -');

    $entry = $exif->getEntry(PelTag::MAKER_NOTE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getText(), '32 bytes unknown MakerNote data');

    $entry = $exif->getEntry(PelTag::FLASH_PIX_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 1.0);
    $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');

    $entry = $exif->getEntry(PelTag::COLOR_SPACE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'sRGB');

    $entry = $exif->getEntry(PelTag::PIXEL_X_DIMENSION);
    $this->assertIsA($entry, 'PelEntryLong');
    $this->assertEqual($entry->getValue(), 960);
    $this->assertEqual($entry->getText(), '960');

    $entry = $exif->getEntry(PelTag::PIXEL_Y_DIMENSION);
    $this->assertIsA($entry, 'PelEntryLong');
    $this->assertEqual($entry->getValue(), 755);
    $this->assertEqual($entry->getText(), '755');

  }

}

?>