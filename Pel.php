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
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL)
 * @package PEL
 */


/**
 * Class with misclanious static methods. 
 *
 * This class will contain various methods that govern the overall
 * behaviour of PEL.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage JPEG
 */
class Pel {

  /**
   * Conditionally output debug information.
   *
   * This method works just like printf() except that it allways
   * terminates the output with a newline, and that it only outputs
   * something if the PEL_DEBUG defined to some true value.
   *
   * @param mixed $args,... any number of arguments can be given.  The
   * first argument must be a string which will be used as a format
   * string for sprintf() --- the remaining arguments will be
   * available for the format string as usual with sprintf().
   */
  static function debug() {
    if (defined('PEL_DEBUG') && PEL_DEBUG) {
      $args = func_get_args();
      $str = array_shift($args);
      vprintf($str . "\n", $args);
    }
  }
}

?>