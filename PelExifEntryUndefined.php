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


/**
 * Classes used to hold data for EXIF tags of format undefined.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */

/** Class definition of {@link PelException}. */
include_once('PelException.php');
/** Class definition of {@link PelExifEntry}. */
include_once('PelExifEntry.php');

/**
 * Class for holding data of any kind.
 *
 * This class can hold bytes of undefined format.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifEntryUndefined extends PelExifEntry {

  /**
   * Make a new PelExifEntry that can hold undefined data.
   *
   * @param PelExifTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelExifTag},
   * e.g., {@link PelExifTag::EXIF_VERSION}, {@link
   * PelExifTag::SCENE_TYPE}, or any other tag with format {@link
   * PelExifFormat::UNDEFINED}.
   *
   * @param string the data that this entry will be holding.  Since
   * the format is undefined, no checking will be done on the data.
   */
  function __construct($tag, $data = '') {
    $this->tag        = $tag;
    $this->format     = PelExifFormat::UNDEFINED;
    $this->components = strlen($data);
    $this->bytes      = $data;
  }


  /**
   * Get the value of an entry as text.
   *
   * The value will be returned in a format suitable for presentation,
   * e.g., rationals will be returned as 'x/y', ASCII strings will be
   * returned as themselves etc.
   *
   * @param boolean some values can be returned in a long or more
   * brief form, and this parameter controls that.
   *
   * @return string the value as text.
   */
  function getText($brief = false) {
    switch ($this->tag) {
    case PelExifTag::USER_COMMENT:
      if ($this->size < 8)
        return '';
      else
        // TODO: handle encodings correctly, the encoding is stored in
        // the first 8 bytes..
        return substr($this->bytes, 8);
      
    case PelExifTag::EXIF_VERSION:
      //CC (e->components, 4, v);
      if ($this->bytes == '0200')
        return 'Exif Version 2.0';
      if ($this->bytes == '0210')
        return 'Exif Version 2.1';
      if ($this->bytes == '0220')
        return 'Exif Version 2.2';
      return 'Unknown Exif Version';

    case PelExifTag::FLASH_PIX_VERSION:
      //CC (e->components, 4, v);
      if ($this->bytes == '0100')
        return 'FlashPix Version 1.0';
      return 'Unknown FlashPix Version';

    case PelExifTag::FILE_SOURCE:
      //CC (e->components, 1, v);
      switch ($this->bytes{0}) {
      case 0x03:
        return 'DSC';
      default:
        return sprintf('0x%02X', $this->bytes{0});
      }
   
    case PelExifTag::COMPONENTS_CONFIGURATION:
      //CC (e->components, 4, v);
      $v = '';
      for ($i = 0; $i < 4; $i++) {
        switch (ord($this->bytes{$i})) {
        case 0:
          $v .= '-';
          break;
        case 1:
          $v .= 'Y';
          break;
        case 2:
          $v .= 'Cb';
          break;
        case 3:
          $v .= 'Cr';
          break;
        case 4:
          $v .= 'R';
          break;
        case 5:
          $v .= 'G';
          break;
        case 6:
          $v .= 'B';
          break;
        default:
          $v .= 'reserved';
          break;
        }
        if ($i < 3) $v .= ' ';
      }
      return $v;

    case PelExifTag::MAKER_NOTE:
      // TODO: handle maker notes.
      return $this->components . ' bytes unknown data';

    default:
      return '(undefined)';
    }
  }
}

?>