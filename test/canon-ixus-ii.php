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


class CanonIxusII extends UnitTestCase {

  function __construct() {
    require_once('../PelJpeg.php');
    parent::__construct('PEL Canon IXUS II Tests');
  }

  function testRead() {
    //define('PEL_DEBUG', true);

    $data = new PelDataWindow(file_get_contents('images/canon-ixus-ii.jpg'));
    $jpeg = new PelJpeg($data);

    /* The first IFD. */
    $app1 = $jpeg->getSection(PelJpegMarker::APP1);
    $ifd0 = $app1->getTiff()->getIfd();
    $this->assertNotNull($ifd0);

    $entry = $ifd0->getEntry(PelTag::MAKE);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'Canon');
    $this->assertEqual($entry->getText(), 'Canon');

    $entry = $ifd0->getEntry(PelTag::MODEL);
    $this->assertIsA($entry, 'PelEntryAscii');
    $this->assertEqual($entry->getValue(), 'Canon DIGITAL IXUS II');
    $this->assertEqual($entry->getText(), 'Canon DIGITAL IXUS II');
    
    $entry = $ifd0->getEntry(PelTag::ORIENTATION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'right - top');

    $entry = $ifd0->getEntry(PelTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd0->getEntry(PelTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd0->getEntry(PelTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $ifd0->getEntry(PelTag::DATE_TIME);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(17, 43, 48, 7, 10, 2004));
    $this->assertEqual($entry->getText(), '2004:07:10 17:43:48');
 
    $entry = $ifd0->getEntry(PelTag::YCBCR_POSITIONING);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'centered');


    /* The EXIF sub IFD. */
    $exif = $ifd0->getSubIfd(PelTag::EXIF_IFD_POINTER);
    $this->assertNotNull($exif);

    $entry = $exif->getEntry(PelTag::EXPOSURE_TIME);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(1, 30));
    $this->assertEqual($entry->getText(), '1/30 sec.');

    $entry = $exif->getEntry(PelTag::FNUMBER);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(32, 10));
    $this->assertEqual($entry->getText(), 'f/3.2');

    $entry = $exif->getEntry(PelTag::EXIF_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 2.2);
    $this->assertEqual($entry->getText(), 'Exif Version 2.2');

    $entry = $exif->getEntry(PelTag::DATE_TIME_ORIGINAL);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(17, 43, 48, 7, 10, 2004));
    $this->assertEqual($entry->getText(), '2004:07:10 17:43:48');
 
    $entry = $exif->getEntry(PelTag::DATE_TIME_DIGITIZED);
    $this->assertIsA($entry, 'PelEntryTime');
    $this->assertEqual($entry->getValue(), gmmktime(17, 43, 48, 7, 10, 2004));
    $this->assertEqual($entry->getText(), '2004:07:10 17:43:48');
 
    $entry = $exif->getEntry(PelTag::COMPONENTS_CONFIGURATION);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), "\1\2\3\0");
    $this->assertEqual($entry->getText(), 'Y Cb Cr -');

    $entry = $exif->getEntry(PelTag::COMPRESSED_BITS_PER_PIXEL);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(2, 1));
    $this->assertEqual($entry->getText(), '2/1');

    $entry = $exif->getEntry(PelTag::SHUTTER_SPEED_VALUE);
    $this->assertIsA($entry, 'PelEntrySRational');
    $this->assertEqual($entry->getValue(), array(157, 32));
    $this->assertEqual($entry->getText(), '157/32 sec. (APEX: 5)');

    $entry = $exif->getEntry(PelTag::APERTURE_VALUE);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(107, 32));
    $this->assertEqual($entry->getText(), 'f/3.2');

    $entry = $exif->getEntry(PelTag::EXPOSURE_BIAS_VALUE);
    $this->assertIsA($entry, 'PelEntrySRational');
    $this->assertEqual($entry->getValue(), array(-1, 3));
    $this->assertEqual($entry->getText(), '-0.3');

    $entry = $exif->getEntry(PelTag::MAX_APERTURE_VALUE);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(107, 32));
    $this->assertEqual($entry->getText(), '107/32');

    $entry = $exif->getEntry(PelTag::METERING_MODE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 5);
    $this->assertEqual($entry->getText(), 'Pattern');

    $entry = $exif->getEntry(PelTag::FLASH);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 16);
    $this->assertEqual($entry->getText(),
                       'Flash did not fire, compulsory flash mode.');

    $entry = $exif->getEntry(PelTag::FOCAL_LENGTH);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(215, 32));
    $this->assertEqual($entry->getText(), '6.7 mm');

    $entry = $exif->getEntry(PelTag::MAKER_NOTE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getText(), '590 bytes unknown MakerNote data');

    $entry = $exif->getEntry(PelTag::USER_COMMENT);
    $this->assertIsA($entry, 'PelEntryUserComment');

    $entry = $exif->getEntry(PelTag::FLASH_PIX_VERSION);
    $this->assertIsA($entry, 'PelEntryVersion');
    $this->assertEqual($entry->getValue(), 1.0);
    $this->assertEqual($entry->getText(), 'FlashPix Version 1.0');

    $entry = $exif->getEntry(PelTag::COLOR_SPACE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'sRGB');

    $entry = $exif->getEntry(PelTag::PIXEL_X_DIMENSION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 640);
    $this->assertEqual($entry->getText(), '640');

    $entry = $exif->getEntry(PelTag::PIXEL_Y_DIMENSION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 480);
    $this->assertEqual($entry->getText(), '480');

    $entry = $exif->getEntry(PelTag::FOCAL_PLANE_X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(640000, 208));
    $this->assertEqual($entry->getText(), '640000/208');

    $entry = $exif->getEntry(PelTag::FOCAL_PLANE_Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(480000, 156));
    $this->assertEqual($entry->getText(), '480000/156');

    $entry = $exif->getEntry(PelTag::FOCAL_PLANE_RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $entry = $exif->getEntry(PelTag::SENSING_METHOD);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'One-chip color area sensor');

    $entry = $exif->getEntry(PelTag::FILE_SOURCE);
    $this->assertIsA($entry, 'PelEntryUndefined');
    $this->assertEqual($entry->getValue(), chr(3));
    $this->assertEqual($entry->getText(), 'DSC');

    $entry = $exif->getEntry(PelTag::CUSTOM_RENDERED);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Normal process');

    $entry = $exif->getEntry(PelTag::EXPOSURE_MODE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'Manual exposure');

    $entry = $exif->getEntry(PelTag::WHITE_BALANCE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 1);
    $this->assertEqual($entry->getText(), 'Manual white balance');

    $entry = $exif->getEntry(PelTag::DIGITAL_ZOOM_RATIO);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(2048, 2048));
    $this->assertEqual($entry->getText(), '2048/2048');

    $entry = $exif->getEntry(PelTag::SCENE_CAPTURE_TYPE);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 0);
    $this->assertEqual($entry->getText(), 'Standard');


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

    $entry = $iopr->getEntry(PelTag::RELATED_IMAGE_WIDTH);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 640);
    $this->assertEqual($entry->getText(), '640');

    $entry = $iopr->getEntry(PelTag::RELATED_IMAGE_LENGTH);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 480);
    $this->assertEqual($entry->getText(), '480');


    /* The second IFD. */
    $ifd1 = $ifd0->getNextIfd();
    $this->assertNotNull($ifd1);

    $entry = $ifd1->getEntry(PelTag::COMPRESSION);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 6);
    $this->assertEqual($entry->getText(), 'JPEG compression');
    
    $entry = $ifd1->getEntry(PelTag::X_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd1->getEntry(PelTag::Y_RESOLUTION);
    $this->assertIsA($entry, 'PelEntryRational');
    $this->assertEqual($entry->getValue(), array(180, 1));
    $this->assertEqual($entry->getText(), '180/1');

    $entry = $ifd1->getEntry(PelTag::RESOLUTION_UNIT);
    $this->assertIsA($entry, 'PelEntryShort');
    $this->assertEqual($entry->getValue(), 2);
    $this->assertEqual($entry->getText(), 'Inch');

    $thumb = $ifd1->getThumbnailData();
    $this->assertEqual($thumb,
                       file_get_contents('images/canon-ixus-ii-thumb.jpg'));
    
  }

}

?>