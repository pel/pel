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
 * Classes used to hold shorts.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */

/** Class definition of {@link PelExifEntryInteger}. */
include_once('PelExifEntryNumber.php');


/**
 * Class for holding signed shorts.
 *
 * This class can hold shorts, either just a single short or an array
 * of shorts.  The class will be used to manipulate any of the EXIF
 * tags which has format {@link PelExifFormat::SHORT} like in this
 * example:
 *
 * <code>
 * $w = $ifd->getEntry(PelExifTag::EXIF_IMAGE_WIDTH);
 * $w->setShort($h->getShort() / 2);
 * $h = $ifd->getEntry(PelExifTag::EXIF_IMAGE_HEIGHT);
 * $h->setShort($h->getShort() / 2);
 * </code>
 *
 * Here the width and height is updated to 50% of their original
 * values.
 *
 * @todo distinguish between signed and unsigned shorts.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifEntryShort extends PelExifEntryNumber {

  /**
   * Make a new entry that can hold a short.
   *
   * The method accept several integer arguments.  The {@link
   * getShort} method will always return an array except for when a
   * single integer argument is given here.
   *
   * This means that one can conveniently use objects like this:
   * <code>
   * $a = new PelExifEntryShort(PelExifTag::EXIF_IMAGE_HEIGHT, 42);
   * $b = $a->getShort() + 314;
   * </code>
   * where the call to {@link getShort} will return an integer instead
   * of an array with one integer element, which would then have to be
   * extracted.
   *
   * @param PelExifTag the tag which this entry represents.  This should be
   * one of the constants defined in {@link PelExifTag}, e.g., {@link
   * PelExifTag::IMAGE_WIDTH}, {@link PelExifTag::ISO_SPEED_RATINGS},
   * or any other tag with format {@link PelExifFormat::SHORT}.
   *
   * @param short|array $value the short(s) that this entry will
   * represent.  The argument passed must obey the same rules as the
   * argument to {@link setShort}, namely that it should be within
   * range of a signed short, that is between -32768 and 32767
   * (inclusive).  If not, then a {@link PelExifEntryShortException}
   * will be thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = -32768;
    $this->max    = 32767;
    $this->format = PelExifFormat::SHORT;

    $numbers = func_get_args();
    array_shift($numbers);
    $this->setNumbersArray($numbers);
  }


  function numberToBytes($number, $order) {
    return PelConvert::shortToBytes($number, $order);
  }


  /**
   * Get the value of an entry as text.
   *
   * The value will be returned in a format suitable for presentation,
   * e.g., instead of returning '2' for a {@PelExifTag::METERING_MODE}
   * tag, 'Center-Weighted Average' is returned.
   *
   * @param boolean some values can be returned in a long or more
   * brief form, and this parameter controls that.
   *
   * @return string the value as text.
   */
  function getText($brief = false) {
    switch ($this->tag) {
    case PelExifTag::METERING_MODE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::COMPRESSION:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 1:
        return 'Uncompressed';
      case 6:
        return 'JPEG compression';
      default:
        return $this->numbers[0];
      
      }

    case PelExifTag::PLANAR_CONFIGURATION:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 1:
        return 'chunky format';
      case 2:
        return 'planar format';
      default:
        return $this->numbers[0];
      }
      
    case PelExifTag::SENSING_METHOD:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::LIGHT_SOURCE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::FOCAL_PLANE_RESOLUTION_UNIT:
    case PelExifTag::RESOLUTION_UNIT:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 2:
        return 'Inch';
      case 3:
        return 'Centimeter';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::EXPOSURE_PROGRAM:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }
   
    case PelExifTag::ORIENTATION:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::YCBCR_POSITIONING:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 1:
        return 'centered';
      case 2:
        return 'co-sited';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::YCBCR_SUB_SAMPLING:
      //CC (e->components, 2, v);
      if ($this->numbers[0] == 2 && $this->numbers[1] == 1)
        return 'YCbCr4:2:2';
      if ($this->numbers[0] == 2 && $this->numbers[1] == 2)
        return 'YCbCr4:2:0';
      
      return $this->numbers[0] . ', ' . $this->numbers[1];
   
    case PelExifTag::PHOTOMETRIC_INTERPRETATION:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 2:
        return 'RGB';
      case 6:
        return 'YCbCr';
      default:
        return $this->numbers[0];
      }
   
    case PelExifTag::COLOR_SPACE:
      //CC (e->components, 1, v); 
      switch ($this->numbers[0]) { 
      case 1:
        return 'sRGB';
      case 0xffff:
        return 'Uncalibrated';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::FLASH:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::CUSTOM_RENDERED:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Normal process';
      case 1:
        return 'Custom process';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::EXPOSURE_MODE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Auto exposure';
      case 1:
        return 'Manual exposure';
      case 2:
        return 'Auto bracket';
      default:
        return $this->numbers[0];
      }
   
    case PelExifTag::WHITE_BALANCE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Auto white balance';
      case 1:
        return 'Manual white balance';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::SCENE_CAPTURE_TYPE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Standard';
      case 1:
        return 'Landscape';
      case 2:
        return 'Portrait';
      case 3:
        return 'Night scene';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::GAIN_CONTROL:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
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
        return $this->numbers[0];
      }

    case PelExifTag::SATURATION:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Normal';
      case 1:
        return 'Low saturation';
      case 2:
        return 'High saturation';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::CONTRAST:
    case PelExifTag::SHARPNESS:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Normal';
      case 1:
        return 'Soft';
      case 2:
        return 'Hard';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::SUBJECT_DISTANCE_RANGE:
      //CC (e->components, 1, v);
      switch ($this->numbers[0]) {
      case 0:
        return 'Unknown';
      case 1:
        return 'Macro';
      case 2:
        return 'Close view';
      case 3:
        return 'Distant view';
      default:
        return $this->numbers[0];
      }

    case PelExifTag::SUBJECT_AREA:
      switch ($this->components) {
      case 2:
        return sprintf('(x,y) = (%i,%i)',
                       $this->numbers[0],
                       $this->numbers[1]);
        
      case 3:
        return sprintf('Within distance %i of (x,y) = (%i,%i)',
                       $this->numbers[0],
                       $this->numbers[1],
                       $this->numbers[2]);

      case 4:
        return sprintf('Within rectangle (width %i, height %i) around ' .
                       '(x,y) = (%i,%i)',
                       $this->numbers[0],
                       $this->numbers[1],
                       $this->numbers[2],
                       $this->numbers[3]);
        
      default:
        return sprintf('Unexpected number of components ' .
                       '(%li, expected 2, 3, or 4).', $this->components);
      }

    default:
      return parent::getText($brief);
    }
  }

}

?>