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
 * Namespace for functions operating on EXIF formats.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**
 * Namespace for functions operating on EXIF formats.
 *
 * This class defines the constants that are to be used whenever one
 * has to refer to the format of an EXIF tag.  They will be
 * collectively denoted by the pseudo-type PelFormat throughout
 * the documentation.
 *
 * All the methods defined here are static, and they all operate on a
 * single argument which should be one of the class constants.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelFormat {

  const BYTE       =  1;
  const ASCII      =  2;
  const SHORT      =  3;
  const LONG       =  4;
  const RATIONAL   =  5;
  const SBYTE      =  6;
  const UNDEFINED  =  7;
  const SSHORT     =  8;
  const SLONG      =  9;
  const SRATIONAL  = 10;
  const FLOAT      = 11;
  const DOUBLE     = 12;

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
    default:              return sprintf('Unknown type: 0x%X', $type);
    }
  }

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
    default:              return sprintf('Unknown type: 0x%X', $type);
    }
  }
}
?>