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


class NikonE950 extends UnitTestCase {

  function __construct() {
    require_once('../PelJpeg.php');
    parent::__construct('PEL Nikon E950 Tests');
  }

  function testRead() {
    $jpeg = new PelJpeg();
    $jpeg->loadFile(dirname(__FILE__) . '/nikon-e950.jpg');

    /* The first IFD. */
    $app1 = $jpeg->getSection(PelJpegMarker::APP1);
    $ifd0 = $app1->getTiff()->getIfd();
    $this->assertNotNull($ifd0);

    $entry = $ifd0->getEntry(PelTag::IMAGE_DESCRIPTION);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), str_repeat(' ', 10));
    $this->assertEqual($entry->getText(), str_repeat(' ', 10));
    
    $entry = $ifd0->getEntry(PelTag::MAKE);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'NIKON');
    $this->assertEqual($entry->getText(), 'NIKON');

    $entry = $ifd0->getEntry(PelTag::MODEL);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'E950');
    $this->assertEqual($entry->getText(), 'E950');

    $entry = $ifd0->getEntry(PelTag::ORIENTATION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'top - left');

    $entry = $ifd0->getEntry(PelTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(300, 1));
    $this->assertEqual($entry->getText(), '300/1');

    $entry = $ifd0->getEntry(PelTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(300, 1));
    $this->assertEqual($entry->getText(), '300/1');

    $entry = $ifd0->getEntry(PelTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd0->getEntry(PelTag::SOFTWARE);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'v981p-78');
    $this->assertEqual($entry->getText(), 'v981p-78');

    $entry = $ifd0->getEntry(PelTag::DATE_TIME);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(15, 20, 13, 12, 31, 2000));
    $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');
    
    $entry = $ifd0->getEntry(PelTag::YCBCR_POSITIONING);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'co-sited');


    /* The EXIF sub IFD. */
    $exif = $ifd0->getSubIfd(PelTag::EXIF_IFD_POINTER);
    $this->assertNotNull($exif);

    $entry = $exif->getEntry(PelTag::EXPOSURE_TIME);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(10, 1120));
    $this->assertEqual($entry->getText(), '1/112 sec.');

    $entry = $exif->getEntry(PelTag::FNUMBER);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(60, 10));
    $this->assertEqual($entry->getText(), 'f/6.0');

    $entry = $exif->getEntry(PelTag::EXPOSURE_PROGRAM);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Normal program');

    $entry = $exif->getEntry(PelTag::ISO_SPEED_RATINGS);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 80);
    $this->assertEqual($entry->getText(), '80');

    $entry = $exif->getEntry(PelTag::EXIF_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 2.1);
    $this->assertEqual($entry->getText(), 'Exif Version 2.1');

    $entry = $exif->getEntry(PelTag::DATE_TIME_ORIGINAL);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(15, 20, 13, 12, 31, 2000));
    $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');
    
    $entry = $exif->getEntry(PelTag::DATE_TIME_DIGITIZED);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(15, 20, 13, 12, 31, 2000));
    $this->assertEqual($entry->getText(), '2000:12:31 15:20:13');
    
    $entry = $exif->getEntry(PelTag::COMPONENTS_CONFIGURATION);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), "\1\2\3\0");
    $this->assertEqual($entry->getText(), 'Y Cb Cr -');

    $entry = $exif->getEntry(PelTag::COMPRESSED_BITS_PER_PIXEL);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(4, 1));
    $this->assertEqual($entry->getText(), '4/1');

    $entry = $exif->getEntry(PelTag::EXPOSURE_BIAS_VALUE);
    $this->assertIsA($entry, 'PelEntrySRational');
    $this->assertEqual($entry->getValue(), array(0, 10));
    $this->assertEqual($entry->getText(), '0.0');

    $entry = $exif->getEntry(PelTag::MAX_APERTURE_VALUE);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(26, 10));
    $this->assertEqual($entry->getText(), '26/10');

    $entry = $exif->getEntry(PelTag::METERING_MODE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 5);
    $this->assertEqual($entry->getText(), 'Pattern');

    $entry = $exif->getEntry(PelTag::LIGHT_SOURCE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Unknown');

    $entry = $exif->getEntry(PelTag::FLASH);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Flash did not fire.');

    $entry = $exif->getEntry(PelTag::FOCAL_LENGTH);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(158, 10));
    $this->assertEqual($entry->getText(), '15.8 mm');

    $entry = $exif->getEntry(PelTag::MAKER_NOTE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getText(), '308 bytes unknown MakerNote data');

    $entry = $exif->getEntry(PelTag::USER_COMMENT);
    $this->assertIsA($entry, 'PelEntryUserComment');
    $this->assertEqual($entry->getValue(), str_repeat(' ', 117));

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
    $this->assertEqual($entry->getValue(), 1600);
    $this->assertEqual($entry->getText(), '1600');

    $entry = $exif->getEntry(PelTag::PIXEL_Y_DIMENSION);
    $this->assertIsA($entry, 'PelEntryLong');
    $this->assertEqual($entry->getValue(), 1200);
    $this->assertEqual($entry->getText(), '1200');

    $entry = $exif->getEntry(PelTag::FILE_SOURCE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(3));
    $this->assertEqual($entry->getText(), 'DSC');

    $entry = $exif->getEntry(PelTag::SCENE_TYPE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(1));
    $this->assertEqual($entry->getText(), 'Directly photographed');


    /* The Interoperability IFD. */
    $iopr = $exif->getSubIfd(PelTag::INTEROPERABILITY_IFD_POINTER);
    $this->assertNotNull($iopr);

    $entry = $iopr->getEntry(PelTag::INTEROPERABILITY_INDEX);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'R98');
    $this->assertEqual($entry->getText(), 'R98');

    $entry = $iopr->getEntry(PelTag::INTEROPERABILITY_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'Interoperability Version 1.0');


    
    /* The second IFD. */
    $ifd1 = $ifd0->getNextIfd();
    $this->assertNotNull($ifd1);

    $entry = $ifd1->getEntry(PelTag::COMPRESSION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'JPEG compression');
    
    $entry = $ifd1->getEntry(PelTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(300, 1));
    $this->assertEqual($entry->getText(), '300/1');

    $entry = $ifd1->getEntry(PelTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(300, 1));
    $this->assertEqual($entry->getText(), '300/1');

    $entry = $ifd1->getEntry(PelTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $thumb = $ifd1->getThumbnailData();
    $this->assertEqual($thumb, file_get_contents(dirname(__FILE__) .
                                                 '/nikon-e950-thumb.jpg'));
  }

}

?>