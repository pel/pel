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
 * Abstract class for numbers.
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
/** Class definition of {@link PelExifEntry}. */
include_once('PelExifEntry.php');


/**
 * Exception cast when numbers overflow.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelOverflowException extends PelException {
  function __construct($v, $min, $max) {
    parent::__construct('Value %d out of range [%d, %d]',
                        $v, $min, $max);
  }
}


/**
 * Class for holding numbers.
 *
 * This class can hold numbers, with range checks.
 *
 * @todo distinguish between signed and unsigned shorts.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
abstract class PelExifEntryNumber extends PelExifEntry {

  /**
   * The numbers held by this entry.
   *
   * @var array
   */
  protected $numbers = array();

  protected $min;
  protected $max;

  protected $dimension = 1;


  /**
   * Change the value.
   *
   * This method can change both the number of components and the
   * value of the components.  Range checks will be made on the new
   * value, and a {@link PelExifEntryOverflowException} will be thrown
   * if the value is found to be outside the legal range.
   *
   * The method accept several number arguments.  The {@link
   * getNumber} method will always return an array except for when a
   * single number is given here.
   *
   * @param short $value the new value(s).  This can be zero or more
   * numbers.  The input will be checked to ensure that the numbers
   * are within the valid range.  If not, then a {@link
   * PelExifEntryOverflowException} will be thrown.
   *
   * @see getNumbers
   */
  function setNumbers(/* ... */) {
    $numbers = func_get_args();
    $this->setNumbersArray($numbers);
  }

  function setNumbersArray($numbers) {
    foreach ($numbers as $n) {
      $this->validateNumber($n);
      
      $this->components = count($numbers);
      $this->numbers    = $numbers;
    }
  }

  
  function getNumbers() {
    if ($this->components == 1)
      return $this->numbers[0];
    else
      return $this->numbers;
  }


  function validateNumber($n) {
    if ($this->dimension == 1) {
      if ($n < $this->min || $n > $this->max)
        throw new PelOverflowException($n, $this->min, $this->max);
    } else {
      for ($i = 0; $i < $this->dimension; $i++)
        if ($n[$i] < $this->min || $n[$i] > $this->max)
          throw new PelOverflowException($n[$i], $this->min, $this->max);
    }
  }


  function addNumber($n) {
    $this->validateNumber($n);

    $this->numbers[] = $n;
    $this->components++;
  }


  abstract function numberToBytes($number, $order);

  
  /**
   * Turn this entry into bytes.
   *
   * @param PelByteOrder the desired byte order, which must be either
   * {@link PelConvert::LITTLE_ENDIAN} or {@link
   * PelConvert::BIG_ENDIAN}.
   *
   * @return string bytes representing this entry.
   */
  function getBytes($o) {
    $bytes = '';
    for ($i = 0; $i < $this->components; $i++) {
      if ($this->dimension == 1) {
        $bytes .= $this->numberToBytes($this->numbers[$i], $o);
      } else {
        for ($j = 0; $j < $this->dimension; $j++) {
          $bytes .= $this->numberToBytes($this->numbers[$i][$j], $o);
        }
      }
    }
    return $bytes;
  }


  function formatNumber($number, $brief = false) {
    return $number;
  }


  /**
   * Get the value of this entry as text.
   *
   * @param boolean use brief output?  The numbers will be seperated
   * by a single space if brief output is requested, otherwise a space
   * and a comma will be used.
   *
   * @return string the long(s) held by this entry.  If there's more
   * than one long stored, then they will be returned with commas in
   * between.
   */
  function getText($brief = false) {
    if ($this->components == 0)
      return '';

    $str = $this->formatNumber($this->numbers[0]);
    for ($i = 1; $i < $this->components; $i++) {
      $str .= ($brief ? ' ' : ', ');
      $str .= $this->formatNumber($this->numbers[$i]);
    }

    return $str;
  }


}

?>