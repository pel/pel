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


/**
 * Classes used to hold bytes, both signed and unsigned.
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
 * Class for holding unsigned bytes.
 *
 * This class can hold bytes, either just a single byte or an array of
 * bytes.  The class will be used to manipulate any of the EXIF tags
 * which has format {@link PelFormat::BYTE}.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelEntryByte extends PelEntryNumber {

  /**
   * Make a new entry that can hold an unsigned byte.
   *
   * The method accept several integer arguments.  The {@link
   * getValue} method will always return an array except for when a
   * single integer argument is given here.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag}
   * which has format {@link PelFormat::BYTE}.
   *
   * @param int $value... the byte(s) that this entry will represent.
   * The argument passed must obey the same rules as the argument to
   * {@link setValue}, namely that it should be within range of an
   * unsigned byte, that is between 0 and 255 (inclusive).  If not,
   * then a {@link PelOverflowException} will be thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = 0;
    $this->max    = 255;
    $this->format = PelFormat::BYTE;

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
    return chr($number);
  }

}


/**
 * Class for holding signed bytes.
 *
 * This class can hold bytes, either just a single byte or an array of
 * bytes.  The class will be used to manipulate any of the EXIF tags
 * which has format {@link PelFormat::BYTE}.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelEntrySByte extends PelEntryNumber {

  /**
   * Make a new entry that can hold a signed byte.
   *
   * The method accept several integer arguments.  The {@link getValue}
   * method will always return an array except for when a single
   * integer argument is given here.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag}
   * which has format {@link PelFormat::BYTE}.
   *
   * @param int $value... the byte(s) that this entry will represent.
   * The argument passed must obey the same rules as the argument to
   * {@link setValue}, namely that it should be within range of a
   * signed byte, that is between -128 and 127 (inclusive).  If not,
   * then a {@link PelOverflowException} will be thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = -128;
    $this->max    = 127;
    $this->format = PelFormat::SBYTE;

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
    return chr($number);
  }

}


?>