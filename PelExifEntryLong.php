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
 * Classes used to hold longs.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */

/** Class definition of {@link PelExifEntryNumber}. */
include_once('PelExifEntryNumber.php');


/**
 * Class for holding signed longs.
 *
 * This class can hold longs, either just a single long or an array of
 * longs.  The class will be used to manipulate any of the EXIF tags
 * which can have format {@link PelExifFormat::LONG} like in this
 * example:
 * <code>
 * $w = $ifd->getEntry(PelExifTag::EXIF_IMAGE_WIDTH);
 * $w->setNumbers($h->getNumbers() / 2);
 * $h = $ifd->getEntry(PelExifTag::EXIF_IMAGE_HEIGHT);
 * $h->setNumbers($h->getNumbers() / 2);
 * </code>
 * Here the width and height is updated to 50% of their original
 * values.
 *
 * @todo distinguish between signed and unsigned longs.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifEntryLong extends PelExifEntryNumber {

  /**
   * Make a new entry that can hold a long.
   *
   * The method accept it's arguments in two forms: several integer
   * arguments or a single array argument.  The {@link getLong} method
   * will always return an array except for when a single long
   * argument is given here, or when an array with just a single
   * integer is given.
   *
   * This means that one can conveniently use objects like this:
   * <code>
   * $a = new PelExifEntryLong(PelExifTag::EXIF_IMAGE_WIDTH, 123456);
   * $b = $a->getLong() - 654321;
   * </code>
   * where the call to {@link getLong} will return an integer instead
   * of an array with one integer element, which would then have to be
   * extracted.
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
  function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = 0;
    $this->max    = 4294967295;
    $this->format = PelExifFormat::LONG;

    $numbers = func_get_args();
    array_shift($numbers);
    $this->setNumbersArray($numbers);
  }


  function numberToBytes($number, $order) {
    return PelConvert::longToBytes($number, $order);
  }
}

class PelExifEntrySLong extends PelExifEntryNumber {

 function __construct($tag /* ... */) {
    $this->tag    = $tag;
    $this->min    = -2147483648;
    $this->max    = 2147483647;
    $this->format = PelExifFormat::SLONG;

    $numbers = func_get_args();
    array_shift($numbers);
    $this->setNumbersArray($numbers);
  }


  /**
   * @todo Use a PelConvert::slongToBytes method?
   */
  function numberToBytes($number, $order) {
    return PelConvert::longToBytes($number, $order);
  }
}


?>