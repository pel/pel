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
 * Classes used to manipulate rational numbers.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */

/** Class definition of {@link PelException}. */
include_once('PelException.php');
/** Class definition of {@link PelExifEntryLong}. */
include_once('PelExifEntryLong.php');


/**
 * Class for holding signed rational numbers.
 *
 * This class can hold rational numbers, consisting of a enumerator
 * and denumerator both of which are of type long.  The class can hold
 * either just a single rational or an array of rationals.  The class
 * will be used to manipulate any of the EXIF tags which can have
 * format {@link PelExifFormat::RATIONAL} like in this example:
 *
 * <code>
 * $resolution = $ifd->getEntry(PelExifTag::X_RESOLUTION);
 * $resolution->setRational(1, 300);
 * </code>
 *
 * Here the x-resolution is adjusted to 1/300, which will be 300 DPI,
 * unless the {@link PelExifTag::RESOLUTION_UNIT resolution unit} is
 * set to something different than 2 which means inches.
 *
 * @todo distinguish between signed and unsigned rationals.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifEntryRational extends PelExifEntryLong {


  /**
   * Make a new entry that can hold a rational.
   *
   * The {@link getLong} method will always return an array of
   * two-element arrays.
   *
   * @param PelExifTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelExifTag},
   * e.g., {@link PelExifTag::IMAGE_WIDTH}, or any other tag which can
   * have format {@link PelExifFormat::LONG}.
   *
   * @param int|array $value the long(s) that this entry will
   * represent or an array of longs.  The argument passed must obey
   * the same rules as the argument to {@link setLong}, namely that it
   * should be within range of a signed long (32 bit), that is between
   * -2147483648 and 2147483647 (inclusive).  If not, then a {@link
   * PelExifEntryShortException} will be thrown.
   */
  function __construct($tag) {
    $this->tag       = $tag;
    $this->format    = PelExifFormat::RATIONAL;
    $this->dimension = 2;
    $this->min       = 0;
    $this->max       = 4294967295;
  }


  function formatNumber($number, $brief = false) {
    return $number[0] . '/' . $number[1];
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
    if (isset($this->numbers[0]))
      $v = $this->numbers[0];
    
    switch ($this->tag) {
    case PelExifTag::FNUMBER:
      //CC (e->components, 1, v);
      return sprintf('f/%.01f', $v[0]/$v[1]);

    case PelExifTag::APERTURE_VALUE:
      //CC (e->components, 1, v);
      //if (!v_rat.denominator) return (NULL);
      return sprintf('f/%.01f', pow(2, $v[0]/$v[1]/2));

    case PelExifTag::FOCAL_LENGTH:
      //CC (e->components, 1, v);
      //if (!v_rat.denominator) return (NULL);
      return sprintf('%.1f mm', $v[0]/$v[1]);
      
    case PelExifTag::SUBJECT_DISTANCE:
      //CC (e->components, 1, v);
      //if (!v_rat.denominator) return (NULL);
      return sprintf('%.1f m', $v[0]/$v[1]);

    case PelExifTag::EXPOSURE_TIME:
      //CC (e->components, 1, v);
      //if (!v_rat.denominator) return (NULL);
      if ($v[0]/$v[1] < 1)
        return sprintf('1/%d sec.', $v[1]/$v[0]);
      else
        return sprintf('%d sec.', $v[0]/$v[1]);
      
    default:
      return parent::getText($brief);
    }
  }
}


class PelExifEntrySRational extends PelExifEntrySLong {
  function __construct($tag) {
    $this->tag       = $tag;
    $this->format    = PelExifFormat::SRATIONAL;
    $this->dimension = 2;
    $this->min       = -2147483648;
    $this->max       = 2147483647;
  }

  
  function formatNumber($number, $brief = false) {
    if ($number[1] < 0)
      /* Turn output like 1/-2 into -1/2. */
      return (-$number[0]) . '/' . (-$number[1]);
    else
      return $number[0] . '/' . $number[1];
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
    if (isset($this->numbers[0]))
      $v = $this->numbers[0];

    switch ($this->tag) {
    case PelExifTag::SHUTTER_SPEED_VALUE:
      //CC (e->components, 1, v);
      //if (!v_srat.denominator) return (NULL);
      return sprintf('%.0f/%.0f sec. (APEX: %d)',
                     $v[0], $v[1], pow(sqrt(2), $v[0]/$v[1]));

    case PelExifTag::BRIGHTNESS_VALUE:
      //CC (e->components, 1, v);
      //
      // TODO: figure out the APEX thing, or remove this so that it's
      // handled by the default clause at the bottom.
      return sprintf('%d/%d', $v[0], $v[1]);
      //FIXME: How do I calculate the APEX value?

    case PelExifTag::EXPOSURE_BIAS_VALUE:
      //CC (e->components, 1, v);
      // TODO: is getRational as good as getSRational?
      //if (!v_srat.denominator) return (NULL);
      return sprintf('%s%.01f', $v[0]*$v[1] > 0 ? '+' : '', $v[0]/$v[1]);

    default:
      parent::getText($brief);
    }
  }


}


?>