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
 * Classes used to hold longs, both signed and unsigned.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */

/** Class definition of {@link PelEntryNumber}. */
require_once('PelEntryNumber.php');


/**
 * Class for holding unsigned longs.
 *
 * This class can hold longs, either just a single long or an array of
 * longs.  The class will be used to manipulate any of the EXIF tags
 * which can have format {@link PelFormat::LONG} like in this
 * example:
 * <code>
 * $w = $ifd->getEntry(PelTag::EXIF_IMAGE_WIDTH);
 * $w->setValue($w->getValue() / 2);
 * $h = $ifd->getEntry(PelTag::EXIF_IMAGE_HEIGHT);
 * $h->setValue($h->getValue() / 2);
 * </code>
 * Here the width and height is updated to 50% of their original
 * values.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelEntryLong extends PelEntryNumber {

  /**
   * Make a new entry that can hold an unsigned long.
   *
   * The method accept it's arguments in two forms: several integer
   * arguments or a single array argument.  The {@link getValue}
   * method will always return an array except for when a single
   * integer argument is given here, or when an array with just a
   * single integer is given.
   *
   * This means that one can conveniently use objects like this:
   * <code>
   * $a = new PelEntryLong(PelTag::EXIF_IMAGE_WIDTH, 123456);
   * $b = $a->getValue() - 654321;
   * </code>
   * where the call to {@link getValue} will return an integer instead
   * of an array with one integer element, which would then have to be
   * extracted.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag},
   * e.g., {@link PelTag::IMAGE_WIDTH}, or any other tag which can
   * have format {@link PelFormat::LONG}.
   *
   * @param int $value... the long(s) that this entry will
   * represent or an array of longs.  The argument passed must obey
   * the same rules as the argument to {@link setValue}, namely that
   * it should be within range of an unsigned long (32 bit), that is
   * between 0 and 4294967295 (inclusive).  If not, then a {@link
   * PelExifOverflowException} will be thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = 0;
    $this->max    = 4294967295;
    $this->format = PelFormat::LONG;

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
    return PelConvert::longToBytes($number, $order);
  }
}


/**
 * Class for holding signed longs.
 *
 * This class can hold longs, either just a single long or an array of
 * longs.  The class will be used to manipulate any of the EXIF tags
 * which can have format {@link PelFormat::SLONG}.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelEntrySLong extends PelEntryNumber {

  /**
   * Make a new entry that can hold a signed long.
   *
   * The method accept it's arguments in two forms: several integer
   * arguments or a single array argument.  The {@link getValue}
   * method will always return an array except for when a single
   * integer argument is given here, or when an array with just a
   * single integer is given.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag}
   * which have format {@link PelFormat::SLONG}.
   *
   * @param int $value... the long(s) that this entry will represent
   * or an array of longs.  The argument passed must obey the same
   * rules as the argument to {@link setValue}, namely that it should
   * be within range of a signed long (32 bit), that is between
   * -2147483648 and 2147483647 (inclusive).  If not, then a {@link
   * PelOverflowException} will be thrown.
   */
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = -2147483648;
    $this->max    = 2147483647;
    $this->format = PelFormat::SLONG;

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
    return PelConvert::longToBytes($number, $order);
  }
}


?>