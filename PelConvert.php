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
 * 
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**
 * Conversion functions to and from bytes and integers.
 *
 * The functions found in this class are used to convert bytes into
 * integers of several sizes ({@link bytesToShort}, {@link
 * bytesToLong}, and {@link bytesToRational}) and convert integers of
 * several sizes into bytes ({@link shortToBytes}, {@link
 * longToBytes}, and {@link rationalToBytes}).
 *
 * All the methods are static and they all rely on an argument that
 * specifies the byte order to be used, this must be one of the class
 * constants {@link LITTLE_ENDIAN} or {@link BIG_ENDIAN}.  These
 * constants will be referred to as the pseudo type PelByteOrder
 * throughout the documentation.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelConvert {

  /**
   * Little-endian byte order.
   *
   * Data stored in little-endian byte order store the least
   * significant byte fist, so the number 0x12345678 becomes 0x78 0x56
   * 0x34 0x12 when stored with little-endian byte order.
   */
  const LITTLE_ENDIAN = true;

  /**
   * Big-endian byte order.
   *
   * Data stored in big-endian byte order store the most significant
   * byte fist, so the number 0x12345678 becomes 0x12 0x34 0x56 0x78
   * when stored with big-endian byte order.
   */
  const BIG_ENDIAN = false;

  /**
   * Convert a short into two bytes.
   *
   * @param int the short that will be converted.  The lower two bytes
   * will be extracted regardless of the actual size passed.
   *
   * @param PelByteOrder one of {@link LITTLE_ENDIAN} and {@link
   * BIG_ENDIAN}.
   */
  static function shortToBytes($value, $endian) {
    if ($endian == self::LITTLE_ENDIAN)
      return chr($value) . chr($value >> 8);
    else
      return chr($value >> 8) . chr($value);
  }
  

  static function longToBytes($value, $endian) {
    if ($endian == self::LITTLE_ENDIAN)
      return (chr($value) .
              chr($value >>  8) .
              chr($value >> 16) .
              chr($value >> 24));
    else
      return (chr($value >> 24) .
              chr($value >> 16) .
              chr($value >>  8) .
              chr($value));
  }


  static function bytesToByte(&$bytes, $offset) {
    return ord($bytes{$offset});
  }


  static function bytesToSByte(&$bytes, $offset) {
    $n = self::bytesToByte($bytes, $offset);
    if ($n > 127)
      return $n - 255;
    else
      return $n;
  }


  static function bytesToShort(&$bytes, $offset, $endian) {
    if ($endian == self::LITTLE_ENDIAN)
      return (ord($bytes{$offset+1}) << 8 |
              ord($bytes{$offset}));
    else
      return (ord($bytes{$offset})   << 8 |
              ord($bytes{$offset+1}));
  }


  static function bytesToSShort(&$bytes, $offset, $endian) {
    $n = self::bytesToShort($bytes, $offset, $endian);
    if ($n > 32768)
      return $n - 65536;
    else
      return $n;
  }


  static function bytesToLong(&$bytes, $offset, $endian) {
    if ($endian == self::LITTLE_ENDIAN)
      return (ord($bytes{$offset+3}) << 24 |
              ord($bytes{$offset+2}) << 16 |
              ord($bytes{$offset+1}) <<  8 |
              ord($bytes{$offset}));
    else
      return (ord($bytes{$offset})   << 24 |
              ord($bytes{$offset+1}) << 16 |
              ord($bytes{$offset+2}) <<  8 |
              ord($bytes{$offset+3}));
  }


  static function bytesToSLong(&$bytes, $offset, $endian) {
    $n = self::bytesToLong($bytes, $offset, $endian);
    if ($n > 2147483647)
      return $n - 4294967295;
    else
      return $n;
  }

  static function bytesToRational(&$bytes, $offset, $endian) {
    return array(self::bytesToLong($bytes, $offset, $endian),
                 self::bytesToLong($bytes, $offset+4, $endian));
  }

  static function bytesToSRational(&$bytes, $offset, $endian) {
    return array(self::bytesToSLong($bytes, $offset, $endian),
                 self::bytesToSLong($bytes, $offset+4, $endian));
  }


  static function bytesToDump($bytes, $max = 0) {
    $s = strlen($bytes);

    if ($max > 0)
      $s = min($max, $s);

    $line = 24;

    for ($i = 0; $i < $s; $i++) {
      printf('%02X ', ord($bytes{$i}));
      
      if (($i+1) % $line == 0)
        print("\n");
    }
    print("\n");
  }


}


?>