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
 * Classes used to hold shorts, both signed and unsigned.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelEntryNumber.php');
/**#@-*/


/**
 * Class for holding signed shorts.
 *
 * This class can hold shorts, either just a single short or an array
 * of shorts.  The class will be used to manipulate any of the EXIF
 * tags which has format {@link PelFormat::SHORT} like in this
 * example:
 *
 * <code>
 * $w = $ifd->getEntry(PelTag::EXIF_IMAGE_WIDTH);
 * $w->setValue($h->getValue() / 2);
 * $h = $ifd->getEntry(PelTag::EXIF_IMAGE_HEIGHT);
 * $h->setValue($h->getValue() / 2);
 * </code>
 *
 * Here the width and height is updated to 50% of their original
 * values.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelEntryShort extends PelEntryNumber {

  /**
   * Make a new entry that can hold an unsigned short.
   *
   * The method accept several integer arguments.  The {@link
   * getValue} method will always return an array except for when a
   * single integer argument is given here.
   *
   * This means that one can conveniently use objects like this:
   * <code>
   * $a = new PelEntryShort(PelTag::EXIF_IMAGE_HEIGHT, 42);
   * $b = $a->getValue() + 314;
   * </code>
   * where the call to {@link getValue} will return an integer
   * instead of an array with one integer element, which would then
   * have to be extracted.
   *
   * @param PelTag the tag which this entry represents.  This should be
   * one of the constants defined in {@link PelTag}, e.g., {@link
   * PelTag::IMAGE_WIDTH}, {@link PelTag::ISO_SPEED_RATINGS},
   * or any other tag with format {@link PelFormat::SHORT}.
   *
   * @param int $value... the short(s) that this entry will
   * represent.  The argument passed must obey the same rules as the
   * argument to {@link setValue}, namely that it should be within
   * range of an unsigned short, that is between 0 and 65535
   * (inclusive).  If not, then a {@link PelOverFlowException} will be
   * thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = 0;
    $this->max    = 65535;
    $this->format = PelFormat::SHORT;

    $value = func_get_args();
    array_shift($value);
    $this->setValueArray($value);
  }


  /**
   * Convert a number into bytes.
   *
   * @param int the number that should be converted.
   *
   * @param PelByteOrder one of {@link PelConvert::LITTLE_ENDIAN} and
   * {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
   *
   * @return string bytes representing the number given.
   */
  function numberToBytes($number, $order) {
    return PelConvert::shortToBytes($number, $order);
  }


  /**
   * Get the value of an entry as text.
   *
   * The value will be returned in a format suitable for presentation,
   * e.g., instead of returning '2' for a {@link
   * PelTag::METERING_MODE} tag, 'Center-Weighted Average' is
   * returned.
   *
   * @param boolean some values can be returned in a long or more
   * brief form, and this parameter controls that.
   *
   * @return string the value as text.
   */
  function getText($brief = false) {
    switch ($this->tag) {
    case PelTag::METERING_MODE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Unknown';
      case 1:
        return 'Average';
      case 2:
        return 'Center-Weighted Average';
      case 3:
        return 'Spot';
      case 4:
        return 'Multi Spot';
      case 5:
        return 'Pattern';
      case 6:
        return 'Partial';
      case 255:
        return 'Other';
      default:
        return $this->value[0];
      }

    case PelTag::COMPRESSION:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 1:
        return 'Uncompressed';
      case 6:
        return 'JPEG compression';
      default:
        return $this->value[0];
      
      }

    case PelTag::PLANAR_CONFIGURATION:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 1:
        return 'chunky format';
      case 2:
        return 'planar format';
      default:
        return $this->value[0];
      }
      
    case PelTag::SENSING_METHOD:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 1:
        return 'Not defined';
      case 2:
        return 'One-chip color area sensor';
      case 3:
        return 'Two-chip color area sensor';
      case 4:
        return 'Three-chip color area sensor';
      case 5:
        return 'Color sequential area sensor';
      case 7:
        return 'Trilinear sensor';
      case 8:
        return 'Color sequential linear sensor';
      default:
        return $this->value[0];
      }

    case PelTag::LIGHT_SOURCE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Unknown';
      case 1:
        return 'Daylight';
      case 2:
        return 'Fluorescent';
      case 3:
        return 'Tungsten (incandescent light)';
      case 4:
        return 'Flash';
      case 9:
        return 'Fine weather';
      case 10:
        return 'Cloudy weather';
      case 11:
        return 'Shade';
      case 12:
        return 'Daylight fluorescent';
      case 13:
        return 'Day white fluorescent';
      case 14:
        return 'Cool white fluorescent';
      case 15:
        return 'White fluorescent';
      case 17:
        return 'Standard light A';
      case 18:
        return 'Standard light B';
      case 19:
        return 'Standard light C';
      case 20:
        return 'D55';
      case 21:
        return 'D65';
      case 22:
        return 'D75';
      case 24:
        return 'ISO studio tungsten';
      case 255:
        return 'Other';
      default:
        return $this->value[0];
      }

    case PelTag::FOCAL_PLANE_RESOLUTION_UNIT:
    case PelTag::RESOLUTION_UNIT:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 2:
        return 'Inch';
      case 3:
        return 'Centimeter';
      default:
        return $this->value[0];
      }

    case PelTag::EXPOSURE_PROGRAM:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Not defined';
      case 1:
        return 'Manual';
      case 2:
        return 'Normal program';
      case 3:
        return 'Aperture priority';
      case 4:
        return 'Shutter priority';
      case 5:
        return 'Creative program (biased toward depth of field)';
      case 6:
        return 'Action program (biased toward fast shutter speed)';
      case 7:
        return 'Portrait mode (for closeup photos with the ' .
          'background out of focus';
      case 8:
        return 'Landscape mode (for landscape photos with the ' .
          'background in focus';
      default:
        return $this->value[0];
      }
   
    case PelTag::ORIENTATION:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 1:
        return 'top - left';
      case 2:
        return 'top - right';
      case 3:
        return 'bottom - right';
      case 4:
        return 'bottom - left';
      case 5:
        return 'left - top';
      case 6:
        return 'right - top';
      case 7:
        return 'right - bottom';
      case 8:
        return 'left - bottom';
      default:
        return $this->value[0];
      }

    case PelTag::YCBCR_POSITIONING:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 1:
        return 'centered';
      case 2:
        return 'co-sited';
      default:
        return $this->value[0];
      }

    case PelTag::YCBCR_SUB_SAMPLING:
      //CC (e->components, 2, v);
      if ($this->value[0] == 2 && $this->value[1] == 1)
        return 'YCbCr4:2:2';
      if ($this->value[0] == 2 && $this->value[1] == 2)
        return 'YCbCr4:2:0';
      
      return $this->value[0] . ', ' . $this->value[1];
   
    case PelTag::PHOTOMETRIC_INTERPRETATION:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 2:
        return 'RGB';
      case 6:
        return 'YCbCr';
      default:
        return $this->value[0];
      }
   
    case PelTag::COLOR_SPACE:
      //CC (e->components, 1, v); 
      switch ($this->value[0]) { 
      case 1:
        return 'sRGB';
      case 0xffff:
        return 'Uncalibrated';
      default:
        return $this->value[0];
      }

    case PelTag::FLASH:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0x0000:
        return 'Flash did not fire.';
      case 0x0001:
        return 'Flash fired.';
      case 0x0005:
        return 'Strobe return light not detected.';
      case 0x0007:
        return 'Strobe return light detected.';
      case 0x0009:
        return 'Flash fired, compulsatory flash mode';
      case 0x000d:
        return 'Flash fired, compulsory flash mode, return light ' .
          'not detected.';
      case 0x000f:
        return 'Flash fired, compulsory flash mode, return light ' .
          'detected.';
      case 0x0010:
        return 'Flash did not fire, compulsory flash mode.';
      case 0x0018:
        return 'Flash did not fire, auto mode.';
      case 0x0019:
        return 'Flash fired, auto mode.';
      case 0x001d:
        return 'Flash fired, auto mode, return light not detected.';
      case 0x001f:
        return 'Flash fired, auto mode, return light detected.';
      case 0x0020:
        return 'No flash function.';
      case 0x0041:
        return 'Flash fired, red-eye reduction mode.';
      case 0x0045:
        return 'Flash fired, red-eye reduction mode, return light ' .
          'not detected.';
      case 0x0047:
        return 'Flash fired, red-eye reduction mode, return light ' .
          'detected.';
      case 0x0049:
        return 'Flash fired, compulsory flash mode, red-eye ' .
          'reduction mode.';
      case 0x004d:
        return 'Flash fired, compulsory flash mode, red-eye ' .
          'reduction mode, return light not detected.';
      case 0x004f:
        return 'Flash fired, compulsory flash mode, red-eye ' .
          'reduction mode, return light detected.';
      case 0x0058:
        return 'Flash did not fire, auto mode, red-eye ' .
          'reduction mode';
      case 0x0059:
        return 'Flash fired, auto mode, red-eye reduction mode.';
      case 0x005d:
        return 'Flash fired, auto mode, return light not detected, ' .
          'red-eye reduction mode.';
      case 0x005f:
        return 'Flash fired, auto mode, return light detected, ' .
          'red-eye reduction mode.';
      default:
        return $this->value[0];
      }

    case PelTag::CUSTOM_RENDERED:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Normal process';
      case 1:
        return 'Custom process';
      default:
        return $this->value[0];
      }

    case PelTag::EXPOSURE_MODE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Auto exposure';
      case 1:
        return 'Manual exposure';
      case 2:
        return 'Auto bracket';
      default:
        return $this->value[0];
      }
   
    case PelTag::WHITE_BALANCE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Auto white balance';
      case 1:
        return 'Manual white balance';
      default:
        return $this->value[0];
      }

    case PelTag::SCENE_CAPTURE_TYPE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Standard';
      case 1:
        return 'Landscape';
      case 2:
        return 'Portrait';
      case 3:
        return 'Night scene';
      default:
        return $this->value[0];
      }

    case PelTag::GAIN_CONTROL:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Normal';
      case 1:
        return 'Low gain up';
      case 2:
        return 'High gain up';
      case 3:
        return 'Low gain down';
      case 4:
        return 'High gain down';
      default:
        return $this->value[0];
      }

    case PelTag::SATURATION:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Normal';
      case 1:
        return 'Low saturation';
      case 2:
        return 'High saturation';
      default:
        return $this->value[0];
      }

    case PelTag::CONTRAST:
    case PelTag::SHARPNESS:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Normal';
      case 1:
        return 'Soft';
      case 2:
        return 'Hard';
      default:
        return $this->value[0];
      }

    case PelTag::SUBJECT_DISTANCE_RANGE:
      //CC (e->components, 1, v);
      switch ($this->value[0]) {
      case 0:
        return 'Unknown';
      case 1:
        return 'Macro';
      case 2:
        return 'Close view';
      case 3:
        return 'Distant view';
      default:
        return $this->value[0];
      }

    case PelTag::SUBJECT_AREA:
      switch ($this->components) {
      case 2:
        return sprintf('(x,y) = (%i,%i)',
                       $this->value[0],
                       $this->value[1]);
        
      case 3:
        return sprintf('Within distance %i of (x,y) = (%i,%i)',
                       $this->value[0],
                       $this->value[1],
                       $this->value[2]);

      case 4:
        return sprintf('Within rectangle (width %i, height %i) around ' .
                       '(x,y) = (%i,%i)',
                       $this->value[0],
                       $this->value[1],
                       $this->value[2],
                       $this->value[3]);
        
      default:
        return sprintf('Unexpected number of components ' .
                       '(%li, expected 2, 3, or 4).', $this->components);
      }

    default:
      return parent::getText($brief);
    }
  }
}


/**
 * Class for holding signed shorts.
 *
 * This class can hold shorts, either just a single short or an array
 * of shorts.  The class will be used to manipulate any of the EXIF
 * tags which has format {@link PelFormat::SSHORT}.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelEntrySShort extends PelEntryNumber {

  /**
   * Make a new entry that can hold a signed short.
   *
   * The method accept several integer arguments.  The {@link
   * getValue} method will always return an array except for when a
   * single integer argument is given here.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag}
   * which has format {@link PelFormat::SSHORT}.
   *
   * @param int $value... the signed short(s) that this entry will
   * represent.  The argument passed must obey the same rules as the
   * argument to {@link setValue}, namely that it should be within
   * range of a signed short, that is between -32768 to 32767
   * (inclusive).  If not, then a {@link PelOverFlowException} will be
   * thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = -32768;
    $this->max    = 32767;
    $this->format = PelFormat::SSHORT;

    $value = func_get_args();
    array_shift($value);
    $this->setValueArray($value);
  }


  /**
   * Convert a number into bytes.
   *
   * @param int the number that should be converted.
   *
   * @param PelByteOrder one of {@link PelConvert::LITTLE_ENDIAN} and
   * {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
   *
   * @return string bytes representing the number given.
   */
  function numberToBytes($number, $order) {
    return PelConvert::shortToBytes($number, $order);
  }
}


?>