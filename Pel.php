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
 * Miscellaneous stuff for the overall behavior of PEL.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */


/* Initialize Gettext, if available.  This must be done before any
 * part of PEL calls Pel::tra() or Pel::fmt() --- this is ensured if
 * every piece of code using those two functions require() this file.
 *
 * If Gettext is not available, wrapper functions will be created,
 * allowing PEL to function, but without any translations.
 *
 * The PEL translations are stored in './locale'.  It is important to
 * use an absolute path here because the lookups will be relative to
 * the current directory. */

if (function_exists('dgettext')) {
  bindtextdomain('pel', dirname(__FILE__) . '/locale');
} else {

  /**
   * Lookup a message in a specific domain.
   *
   * This is just a stub which will return the message untranslated.
   *
   * @param string $domain the domain.
   *
   * @param string $str the message to be translated.
   *
   * @return string the untranslated message.
   */
  function dgettext($domain, $str) {
    return $str;
  }
}


/**
 * Class with miscellaneous static methods. 
 *
 * This class will contain various methods that govern the overall
 * behavior of PEL.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class Pel {

  /**
   * Flag for controlling debug information.
   *
   * The methods producing debug information ({@link debug()} and
   * {@link warning()}) will only output something if this variable is
   * set to true.
   *
   * @var boolean
   */
  static $debug = false;

  /**
   * Conditionally output debug information.
   *
   * This method works just like printf() except that it always
   * terminates the output with a newline, and that it only outputs
   * something if the PEL_DEBUG defined to some true value.
   *
   * @param string $format the format string.
   *
   * @param mixed $args,... any number of arguments can be given.  The
   * arguments will be available for the format string as usual with
   * sprintf().
   */
  static function debug() {
    if (self::$debug) {
      $args = func_get_args();
      $str = array_shift($args);
      vprintf($str . "\n", $args);
    }
  }

  
  /**
   * Conditionally output a warning.
   *
   * This method works just like printf() except that it prepends the
   * output with the string 'Warning: ', terminates the output with a
   * newline, and that it only outputs something if the PEL_DEBUG
   * defined to some true value.
   *
   * @param string $format the format string.
   *
   * @param mixed $args,... any number of arguments can be given.  The
   * arguments will be available for the format string as usual with
   * sprintf().
   */
  static function warning() {
    if (self::$debug) {
      $args = func_get_args();
      $str = array_shift($args);
      vprintf('Warning: ' . $str . "\n", $args);
    }
  }


  /**
   * Translate a string.
   *
   * This static function will use Gettext to translate a string.  By
   * always using this function for static string one is assured that
   * the translation will be taken from the correct text domain.
   * Dynamic strings should be passed to {@link fmt} instead.
   *
   * @param string the string that should be translated.
   *
   * @return string the translated string, or the original string if
   * no translation could be found.
   */
  static function tra($str) {
    return dgettext('pel', $str);
  }
  

  /**
   * Translate and format a string.
   *
   * This static function will first use Gettext to translate a format
   * string, which will then have access to any extra arguments.  By
   * always using this function for dynamic string one is assured that
   * the translation will be taken from the correct text domain.  If
   * the string is static, use {@link tra} instead as it will be
   * faster.
   *
   * @param string $format the format string.  This will be translated
   * before being used as a format string.
   *
   * @param mixed $args,... any number of arguments can be given.  The
   * arguments will be available for the format string as usual with
   * sprintf().
   *
   * @return string the translated string, or the original string if
   * no translation could be found.
   */
  static function fmt() {
    $args = func_get_args();
    $str = array_shift($args);
    return vsprintf(dgettext('pel', $str), $args);
  }

}

?>