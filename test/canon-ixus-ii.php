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


class CanonIxusII extends UnitTestCase {

  function __construct() {
    require_once('../PelJpegData.php');
    parent::__construct('PEL Canon IXUS II Tests');
  }

  function testRead() {
    //define('PEL_DEBUG', true);

    $data = new PelDataWindow(file_get_contents('images/canon-ixus-ii.jpg'));
    $jpeg = new PelJpegData($data);

    /* The first IFD. */
    $ifd0 = $jpeg->getSection(2)->getContent()->getIfd();
    $this->assertNotNull($ifd0);

    $entry = $ifd0->getEntry(PelExifTag::MAKE);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'Canon');
    $this->assertEqual($entry->getText(), 'Canon');

    $entry = $ifd0->getEntry(PelExifTag::MODEL);
    $this->assertIsA($entry, 'PelExifEntryAscii');
    $this->assertEqual($entry->getValue(), 'Canon DIGITAL IXUS II');
    $this->assertEqual($entry->getText(), 'Canon DIGITAL IXUS II');
    
    $entry = $ifd0->getEntry(PelExifTag::ORIENTATION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'right - top');

    $entry = $ifd0->getEntry(PelExifTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd0->getEntry(PelExifTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd0->getEntry(PelExifTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd0->getEntry(PelExifTag::DATE_TIME);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(16, 40, 8, 2, 9, 2004));
    $this->assertEqual($entry->getText(), '2004:02:09 16:40:08');
 
    $entry = $ifd0->getEntry(PelExifTag::YCBCR_POSITIONING);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'centered');

    $entry = $ifd0->getEntry(PelExifTag::RELATED_IMAGE_WIDTH);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1024);
    $this->assertEqual($entry->getText(), '1024');

    $entry = $ifd0->getEntry(PelExifTag::RELATED_IMAGE_LENGTH);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 768);
    $this->assertEqual($entry->getText(), '768');

    $entry = $ifd0->getEntry(PelExifTag::CUSTOM_RENDERED);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Normal process');

    $entry = $ifd0->getEntry(PelExifTag::EXPOSURE_MODE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Auto exposure');

    $entry = $ifd0->getEntry(PelExifTag::WHITE_BALANCE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Auto white balance');

    $entry = $ifd0->getEntry(PelExifTag::DIGITAL_ZOOM_RATIO);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(2048, 2048));
    $this->assertEqual($entry->getText(), '2048/2048');

    $entry = $ifd0->getEntry(PelExifTag::SCENE_CAPTURE_TYPE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Standard');


    /* The EXIF sub IFD. */
    $exif = $ifd0->getSubIfd(PelExifTag::EXIF_IFD_POINTER);
    $this->assertNotNull($exif);

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_TIME);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(1, 640));
    $this->assertEqual($entry->getText(), '1/640 sec.');

    $entry = $exif->getEntry(PelExifTag::FNUMBER);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(71, 10));
    $this->assertEqual($entry->getText(), 'f/7.1');

    $entry = $exif->getEntry(PelExifTag::EXIF_VERSION);
    $this->assertIsA($entry, 'PelExifEntryVersion');
    $this->assertEqual($entry->getValue(), 2.2);
    $this->assertEqual($entry->getText(), 'Exif Version 2.2');

    $entry = $exif->getEntry(PelExifTag::DATE_TIME_ORIGINAL);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(16, 40, 8, 2, 9, 2004));
    $this->assertEqual($entry->getText(), '2004:02:09 16:40:08');
 
    $entry = $exif->getEntry(PelExifTag::DATE_TIME_DIGITIZED);
    $this->assertIsA($entry, 'PelExifEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(16, 40, 8, 2, 9, 2004));
    $this->assertEqual($entry->getText(), '2004:02:09 16:40:08');
 
    $entry = $exif->getEntry(PelExifTag::COMPONENTS_CONFIGURATION);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getValue(), "\1\2\3\0");
    $this->assertEqual($entry->getText(), 'Y Cb Cr -');

    $entry = $exif->getEntry(PelExifTag::COMPRESSED_BITS_PER_PIXEL);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(5, 1));
    $this->assertEqual($entry->getText(), '5/1');

    $entry = $exif->getEntry(PelExifTag::APERTURE_VALUE);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(181, 32));
    $this->assertEqual($entry->getText(), 'f/7.1');

    $entry = $exif->getEntry(PelExifTag::EXPOSURE_BIAS_VALUE);
    $this->assertIsA($entry, 'PelExifEntrySRational');
    $this->assertEqual($entry->getValue(), array(0, 3));
    $this->assertEqual($entry->getText(), '0');

    $entry = $exif->getEntry(PelExifTag::MAX_APERTURE_VALUE);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(95, 32));
    $this->assertEqual($entry->getText(), '95/32');

    $entry = $exif->getEntry(PelExifTag::METERING_MODE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 5);
    $this->assertEqual($entry->getText(), 'Pattern');

    $entry = $exif->getEntry(PelExifTag::FLASH);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 16);
    $this->assertEqual($entry->getText(),
                       'Flash did not fire, compulsory flash mode.');

    $entry = $exif->getEntry(PelExifTag::FOCAL_LENGTH);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(173, 32));
    $this->assertEqual($entry->getText(), '5.4 mm');

    $entry = $exif->getEntry(PelExifTag::MAKER_NOTE);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getText(), '590 bytes unknown MakerNote data');

    $entry = $exif->getEntry(PelExifTag::USER_COMMENT);
    $this->assertIsA($entry, 'PelExifEntryUserComment');

    $entry = $exif->getEntry(PelExifTag::FLASH_PIX_VERSION);
    $this->assertIsA($entry, 'PelExifEntryVersion');
    $this->assertEqual($entry->getValue(), 1.0);
    $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');


    $entry = $exif->getEntry(PelExifTag::COLOR_SPACE);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'sRGB');

    $entry = $exif->getEntry(PelExifTag::PIXEL_X_DIMENSION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 768);
    $this->assertEqual($entry->getText(), '768');

    $entry = $exif->getEntry(PelExifTag::PIXEL_Y_DIMENSION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 1024);
    $this->assertEqual($entry->getText(), '1024');

    $entry = $exif->getEntry(PelExifTag::FOCAL_PLANE_X_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(768000, 156));
    $this->assertEqual($entry->getText(), '768000/156');

    $entry = $exif->getEntry(PelExifTag::FOCAL_PLANE_Y_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(1024000, 208));
    $this->assertEqual($entry->getText(), '1024000/208');

    $entry = $exif->getEntry(PelExifTag::FOCAL_PLANE_RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $exif->getEntry(PelExifTag::SENSING_METHOD);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'One-chip color area sensor');

    $entry = $exif->getEntry(PelExifTag::FILE_SOURCE);
    $this->assertIsA($entry, 'PelExifEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(3));
    $this->assertEqual($entry->getText(), 'DSC');


    /* The second IFD. */
    $ifd1 = $ifd0->getNextIfd();
    $this->assertNotNull($ifd1);

    $entry = $ifd1->getEntry(PelExifTag::COMPRESSION);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'JPEG compression');
    
    $entry = $ifd1->getEntry(PelExifTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd1->getEntry(PelExifTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelExifEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd1->getEntry(PelExifTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelExifEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $thumb = $ifd1->getThumbnailData();
    $this->assertEqual($thumb,
                       file_get_contents('images/canon-ixus-ii-thumb.jpg'));
    
  }

}

?>