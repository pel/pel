<?php

/*  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004, 2005  Martin Geisler.
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
 *  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 *  Boston, MA 02110-1301 USA
 */

/* $Id$ */


/**
 * Namespace for functions operating on Exif formats.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**
 * Namespace for functions operating on Exif formats.
 *
 * This class defines the constants that are to be used whenever one
 * has to refer to the format of an Exif tag.  They will be
 * collectively denoted by the pseudo-type PelFormat throughout the
 * documentation.
 *
 * All the methods defined here are static, and they all operate on a
 * single argument which should be one of the class constants.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelFormat {

  /**
   * Unsigned byte.
   *
   * Each component will be an unsigned 8-bit integer with a value
   * between 0 and 255.
   *
   * Modelled with the {@link PelEntryByte} class.
   */
  const BYTE       =  1;
  
  /**
   * ASCII string.
   *
   * Each component will be an ASCII character.
   *
   * Modelled with the {@link PelEntryAscii} class.
   */
  const ASCII      =  2;
  
  /**
   * Unsigned short.
   *
   * Each component will be an unsigned 16-bit integer with a value
   * between 0 and 65535.
   *
   * Modelled with the {@link PelEntryShort} class.
   */
  const SHORT      =  3;

  /**
   * Unsigned long.
   *
   * Each component will be an unsigned 32-bit integer with a value
   * between 0 and 4294967295.
   *
   * Modelled with the {@link PelEntryLong} class.
   */
  const LONG       =  4;

  /**
   * Unsigned rational number.
   *
   * Each component will consist of two unsigned 32-bit integers
   * denoting the enumerator and denominator.  Each integer will have
   * a value between 0 and 4294967295.
   *
   * Modelled with the {@link PelEntryRational} class.
   */
  const RATIONAL   =  5;

  /**
   * Signed byte.
   *
   * Each component will be a signed 8-bit integer with a value
   * between -128 and 127.
   *
   * Modelled with the {@link PelEntrySByte} class.
   */
  const SBYTE      =  6;

  /**
   * Undefined byte.
   *
   * Each component will be a byte with no associated interpretation.
   *
   * Modelled with the {@link PelEntryUndefined} class.
   */
  const UNDEFINED  =  7;

  /**
   * Signed short.
   *
   * Each component will be a signed 16-bit integer with a value
   * between -32768 and 32767.
   *
   * Modelled with the {@link PelEntrySShort} class.
   */
  const SSHORT     =  8;

  /**
   * Signed long.
   *
   * Each component will be a signed 32-bit integer with a value
   * between -2147483648 and 2147483647.
   *
   * Modelled with the {@link PelEntrySLong} class.
   */
  const SLONG      =  9;

  /**
   * Signed rational number.
   *
   * Each component will consist of two signed 32-bit integers
   * denoting the enumerator and denominator.  Each integer will have
   * a value between -2147483648 and 2147483647.
   *
   * Modelled with the {@link PelEntrySRational} class.
   */
  const SRATIONAL  = 10;

  /**
   * Floating point number.
   *
   * Entries with this format are not currently implemented.
   */
  const FLOAT      = 11;

  /**
   * Double precision floating point number.
   *
   * Entries with this format are not currently implemented.
   */
  const DOUBLE     = 12;


  /**
   * Returns the name of a format.
   *
   * @param PelFormat the format.
   *
   * @return string the name of the format, e.g., 'Ascii' for the
   * {@link ASCII} format etc.
   */
  static function getName($type) {
    switch ($type) {
    case self::ASCII:     return 'Ascii';
    case self::BYTE:      return 'Byte';
    case self::SHORT:     return 'Short';
    case self::LONG:      return 'Long';
    case self::RATIONAL:  return 'Rational';
    case self::SBYTE:     return 'SByte';
    case self::SSHORT:    return 'SShort';
    case self::SLONG:     return 'SLong';
    case self::SRATIONAL: return 'SRational';
    case self::FLOAT:     return 'Float';
    case self::DOUBLE:    return 'Double';
    case self::UNDEFINED: return 'Undefined';
    default:
      return Pel::fmt('Unknown format: 0x%X', $type);
    }
  }


  /**
   * Return the size of components in a given format.
   *
   * @param PelFormat the format.
   *
   * @return the size in bytes needed to store one component with the
   * given format.
   */
  static function getSize($type) {
    switch ($type) {
    case self::ASCII:     return 1;
    case self::BYTE:      return 1;
    case self::SHORT:     return 2;
    case self::LONG:      return 4;
    case self::RATIONAL:  return 8;
    case self::SBYTE:     return 1;
    case self::SSHORT:    return 2;
    case self::SLONG:     return 4;
    case self::SRATIONAL: return 8;
    case self::FLOAT:     return 4;
    case self::DOUBLE:    return 8;
    case self::UNDEFINED: return 1;
    default:
      return Pel::fmt('Unknown format: 0x%X', $type);
    }
  }

}
?>