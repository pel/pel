<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers of JPEG images using PHP.
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


class SonyDscV1 extends UnitTestCase {

  function __construct() {
    require_once('../PelJpegData.php');
    parent::__construct('PEL Sony DSC V1 Tests');
  }

  function testRead() {
    //define('PEL_DEBUG', true);

    $data = new PelDataWindow(file_get_contents('images/sony-dsc-v1.jpg'));
    $jpeg = new PelJpegData($data);

    /* The first IFD. */
    $ifd0 = $jpeg->getSection(2)->getContent()->getIfd();
    $this->assertNotNull($ifd0);

    $entry = $ifd0->getEntry(PelExifTag::IMAGE_DESCRIPTION);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), str_repeat(' ', 31));
    $this->assertEqual($entry->getText(), str_repeat(' ', 31));

    $entry = $ifd0->getEntry(PelExifTag::MAKE);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'SONY');
    $this->assertEqual($entry->getText(), 'SONY');

    $entry = $ifd0->getEntry(PelExifTag::MODEL);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'DSC-V1');
    $this->assertEqual($entry->getText(), 'DSC-V1');

    $entry = $ifd0->getEntry(PelExifTag::ORIENTATION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'top - left');

    $entry = $ifd0->getEntry(PelExifTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(72, 1));
    $this->assertEqual($entry->getText(), '72/1');

    $entry = $ifd0->getEntry(PelExifTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(72, 1));
    $this->assertEqual($entry->getText(), '72/1');

    $entry = $ifd0->getEntry(PelExifTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd0->getEntry(PelExifTag::DATE_TIME);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(13, 39, 11, 5, 6, 2004));
    $this->assertEqual($entry->getText(), '2004:05:06 13:39:11');
    
    $entry = $ifd0->getEntry(PelExifTag::YCBCR_POSITIONING);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'co-sited');

    $entry = $ifd0->getEntry(0xC4A5);
    $this->assertIsA($entry, 'PelExifEntryUndefined');


    /* The EXIF sub IFD. */
    $exif = $ifd0->getSubIfd(PelExifTag::EXIF_IFD_POINTER);
    $this->assertNotNull($exif);

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_TIME);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(10, 2500));
    $this->assertEqual($entry->getText(), '1/250 sec.');

    $entry = $exif->getEntry(PelExifTag::FNUMBER);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(40, 10));
    $this->assertEqual($entry->getText(), 'f/4.0');

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_PROGRAM);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Normal program');

    $entry = $exif->getEntry(PelExifTag::ISO_SPEED_RATINGS);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 100);
    $this->assertEqual($entry->getText(), '100');

    $entry = $exif->getEntry(PelExifTag::EXIF_VERSION);
    $this->assertIsA($entry, 'PelExifEntryVersion');
    $this->assertEqual($entry->getValue(), 2.2);
    $this->assertEqual($entry->getText(), 'Exif Version 2.2');

    $entry = $exif->getEntry(PelExifTag::DATE_TIME_ORIGINAL);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(13, 39, 11, 5, 6, 2004));
    $this->assertEqual($entry->getText(), '2004:05:06 13:39:11');
    
    $entry = $exif->getEntry(PelExifTag::DATE_TIME_DIGITIZED);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(13, 39, 11, 5, 6, 2004));
    $this->assertEqual($entry->getText(), '2004:05:06 13:39:11');
    
    $entry = $exif->getEntry(PelExifTag::COMPONENTS_CONFIGURATION);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getValue(), "\1\2\3\0");
    $this->assertEqual($entry->getText(), 'Y Cb Cr -');

    $entry = $exif->getEntry(PelExifTag::COMPRESSED_BITS_PER_PIXEL);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(4, 1));
    $this->assertEqual($entry->getText(), '4/1');

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_BIAS_VALUE);
    $this->assertIsA($entry, 'PelExifEntrySRational');
    $this->assertEqual($entry->getValue(), array(0, 10));
    $this->assertEqual($entry->getText(), '0');

    $entry = $exif->getEntry(PelExifTag::MAX_APERTURE_VALUE);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(48, 16));
    $this->assertEqual($entry->getText(), '48/16');

    $entry = $exif->getEntry(PelExifTag::METERING_MODE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 5);
    $this->assertEqual($entry->getText(), 'Pattern');

    $entry = $exif->getEntry(PelExifTag::LIGHT_SOURCE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Unknown');

    $entry = $exif->getEntry(PelExifTag::FLASH);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Flash did not fire.');

    $entry = $exif->getEntry(PelExifTag::FOCAL_LENGTH);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(70, 10));
    $this->assertEqual($entry->getText(), '7.0 mm');

    $entry = $exif->getEntry(PelExifTag::MAKER_NOTE);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getText(), '1504 bytes unknown MakerNote data');

    $entry = $exif->getEntry(PelExifTag::FLASH_PIX_VERSION);
    $this->assertIsA($entry, 'PelExifEntryVersion');
    $this->assertEqual($entry->getValue(), 1.0);
    $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');

    $entry = $exif->getEntry(PelExifTag::COLOR_SPACE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'sRGB');

    $entry = $exif->getEntry(PelExifTag::PIXEL_X_DIMENSION);
    $this->assertIsA($entry, 'PelExifEntryLong');
    $this->assertEqual($entry->getValue(), 400);
    $this->assertEqual($entry->getText(), '400');

    $entry = $exif->getEntry(PelExifTag::PIXEL_Y_DIMENSION);
    $this->assertIsA($entry, 'PelExifEntryLong');
    $this->assertEqual($entry->getValue(), 300);
    $this->assertEqual($entry->getText(), '300');

    $entry = $exif->getEntry(PelExifTag::FILE_SOURCE);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(3));
    $this->assertEqual($entry->getText(), 'DSC');

    $entry = $exif->getEntry(PelExifTag::SCENE_TYPE);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(1));
    $this->assertEqual($entry->getText(), 'Directly photographed');

    $entry = $exif->getEntry(PelExifTag::CUSTOM_RENDERED);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Normal process');

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_MODE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Auto exposure');

    $entry = $exif->getEntry(PelExifTag::WHITE_BALANCE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Auto white balance');

    $entry = $exif->getEntry(PelExifTag::SCENE_CAPTURE_TYPE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Standard');


    /* The Interoperability IFD. */
    $iopr = $exif->getSubIfd(PelExifTag::INTEROPERABILITY_IFD_POINTER);
    $this->assertNotNull($iopr);

    $entry = $iopr->getEntry(PelExifTag::INTEROPERABILITY_INDEX);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'R98');
    $this->assertEqual($entry->getText(), 'R98');

    $entry = $iopr->getEntry(PelExifTag::INTEROPERABILITY_VERSION);
    $this->assertIsA($entry, 'PelExifEntryVersion');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'Interoperability Version 1.0');

    
    /* The second IFD. */
    $ifd1 = $ifd0->getNextIfd();
    $this->assertNotNull($ifd1);

    $entry = $ifd1->getEntry(PelExifTag::COMPRESSION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'JPEG compression');
    
    $entry = $ifd1->getEntry(PelExifTag::MAKE);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'SONY');
    $this->assertEqual($entry->getText(), 'SONY');

    $entry = $ifd1->getEntry(PelExifTag::MODEL);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'DSC-V1');
    $this->assertEqual($entry->getText(), 'DSC-V1');

    $entry = $ifd1->getEntry(PelExifTag::ORIENTATION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), '1');
    $this->assertEqual($entry->getText(), 'top - left');

    $entry = $ifd1->getEntry(PelExifTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(72, 1));
    $this->assertEqual($entry->getText(), '72/1');

    $entry = $ifd1->getEntry(PelExifTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(72, 1));
    $this->assertEqual($entry->getText(), '72/1');

    $entry = $ifd1->getEntry(PelExifTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd1->getEntry(PelExifTag::DATE_TIME);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(13, 39, 11, 5, 6, 2004));
    $this->assertEqual($entry->getText(), '2004:05:06 13:39:11');
    
    $thumb = $ifd1->getThumbnailData();
    $this->assertEqual($thumb,
                       file_get_contents('images/sony-dsc-v1-thumb.jpg'));
  }

}

?>