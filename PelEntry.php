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
 * Classes for dealing with EXIF entries.
 *
 * This file defines two exception classes and the abstract class
 * {@link PelEntry} which provides the basic methods that all EXIF
 * entries will have.  All EXIF entries will be represented by
 * descendants of the {@link PelEntry} class.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelDataWindow.php');
require_once('PelException.php');
require_once('PelFormat.php');
require_once('PelTag.php');
require_once('Pel.php');
/**#@-*/


/**
 * Exception indicating a problem with the entry.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelEntryException extends PelException {}


/**
 * Exception indicating that an unexpected format was found.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelUnexpectedFormatException extends PelEntryException {

  /**
   * Construct a new exception indicating an invalid format.
   *
   * @param PelTag the tag for which the violation was found.
   *
   * @param PelFormat the format found.
   *
   * @param PelFormat the expected format.
   */
  function __construct($tag, $found, $expected) {
    parent::__construct('Unexpected format found for %s tag: %s. ' .
                        'Expected %s instead.',
                        PelTag::getName($tag),
                        PelFormat::getName($found),
                        PelFormat::getName($expected));
  }
}


/**
 * Exception indicating that an unexpected number of components was
 * found.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelWrongComponentCountException extends PelEntryException {

  /**
   * Construct a new exception indicating a wrong number of
   * components.
   *
   * Some tags have strict limits as to the allowed number of
   * components, and this exception is thrown if the data violates
   * such a constraint.
   *
   * @param PelTag the tag for which the violation was found.
   *
   * @param int the number of components found.
   *
   * @param int the expected number of components.
   */
  function __construct($tag, $found, $expected) {
    parent::__construct('Wrong number of components found for %s tag: %d. ' .
                        'Expected %d.',
                        PelTag::getName($tag), $found, $expected);
  }
}


/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
abstract class PelEntry {

  /**
   * The bytes representing this entry.
   *
   * Subclasses must either override {@link getBytes()} or, if
   * possible, maintain this property so that it always contains a
   * true representation of the entry.
   *
   * @var string
   */
  protected $bytes = '';

  /**
   * The {@link PelTag} of this entry.
   *
   * @var PelTag
   */
  protected $tag;

  /**
   * The {@link PelFormat} of this entry.
   *
   * @var PelFormat
   */
  protected $format;

  /**
   * The number of components of this entry.
   *
   * @var int
   */
  protected $components;


  /**
   * Make a new entry from a bunch of bytes.
   *
   * This factory method will create the proper subclass of {@link
   * PelEntry} corresponding to the {@link PelTag} and {@link
   * PelFormat} given.
   *
   * A {@link PelUnexpectedFormatException} is thrown if a mismatch is
   * discovered between the tag and format, and likewise a {@link
   * PelWrongComponentCountException} is thrown if the number of
   * components does not match the requirements of the tag.  The
   * requirements for a given tag (if any) can be found in the
   * documentation for {@link PelTag}.
   *
   * @param PelTag the tag of the entry.
   *
   * @param PelFormat the format of the entry.
   *
   * @param int the components in the entry.
   *
   * @param PelDataWindow the data which will be used to construct the
   * entry.
   *
   * @return PelEntry a newly created entry, holding the data given.
   */
  static function newFromData($tag, $format, $components, $data) {

    /* First handle tags for which we have a specific PelEntryXXX
     * class. */
    switch ($tag) {
    case PelTag::DATE_TIME:
    case PelTag::DATE_TIME_ORIGINAL:
    case PelTag::DATE_TIME_DIGITIZED:
      if ($format != PelFormat::ASCII)
        throw new PelUnexpectedFormatException($tag, $format,
                                               PelFormat::ASCII);

      if ($components != 20)
        throw new PelWrongComponentCountException($tag, $components, 20);

      /* Split the string into year, month, date, hour, minute, and
       * second components. */
      $d = explode('-', strtr($data->getBytes(0, -1), '.: ', '---'));
      // TODO: handle timezones.
      require_once('PelEntryAscii.php');
      return new PelEntryTime($tag, gmmktime($d[3], $d[4], $d[5],
                                             $d[1], $d[2], $d[0]));

    case PelTag::COPYRIGHT:
      if ($format != PelFormat::ASCII)
        throw new PelUnexpectedFormatException($tag, $format,
                                               PelFormat::ASCII);
      
      $v = explode("\0", trim($data->getBytes(), ' '));
      require_once('PelEntryAscii.php');
      return new PelEntryCopyright($v[0], $v[1]);

    case PelTag::EXIF_VERSION:
    case PelTag::FLASH_PIX_VERSION:
    case PelTag::INTEROPERABILITY_VERSION:
      if ($format != PelFormat::UNDEFINED)
        throw new PelUnexpectedFormatException($tag, $format,
                                               PelFormat::UNDEFINED);

      require_once('PelEntryUndefined.php');
      return new PelEntryVersion($tag, $data->getBytes() / 100);

    case PelTag::USER_COMMENT:
      if ($format != PelFormat::UNDEFINED)
        throw new PelUnexpectedFormatException($tag, $format,
                                               PelFormat::UNDEFINED);

      require_once('PelEntryUndefined.php');
      if ($data->getSize() < 8) {
        return new PelEntryUserComment();
      } else {
        return new PelEntryUserComment($data->getBytes(8),
                                       rtrim($data->getBytes(0, 8)));
      }

    default:
      /* Then handle the formats. */
      switch ($format) {
      case PelFormat::BYTE:
        require_once('PelEntryByte.php');
        $v =  new PelEntryByte($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getByte($i));
        return $v;

      case PelFormat::SBYTE:
        require_once('PelEntryByte.php');
        $v =  new PelEntrySByte($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSByte($i));
        return $v;

      case PelFormat::ASCII:
        require_once('PelEntryAscii.php');
        return new PelEntryAscii($tag, $data->getBytes(0, -1));

      case PelFormat::SHORT:
        require_once('PelEntryShort.php');
        $v =  new PelEntryShort($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getShort($i*2));
        return $v;

      case PelFormat::SSHORT:
        require_once('PelEntryShort.php');
        $v =  new PelEntrySShort($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSShort($i*2));
        return $v;

      case PelFormat::LONG:
        require_once('PelEntryLong.php');
        $v =  new PelEntryLong($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getLong($i*4));
        return $v;

      case PelFormat::SLONG:
        require_once('PelEntryLong.php');
        $v =  new PelEntrySLong($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSLong($i*4));
        return $v;

      case PelFormat::RATIONAL:
        require_once('PelEntryRational.php');
        $v =  new PelEntryRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getRational($i*8));
        return $v;

      case PelFormat::SRATIONAL:
        require_once('PelEntryRational.php');
        $v =  new PelEntrySRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSRational($i*8));
        return $v;

      case PelFormat::UNDEFINED:
        require_once('PelEntryUndefined.php');
        return new PelEntryUndefined($tag, $data->getBytes());

      default:
        throw new PelException('Unsupported format: %s',
                               PelFormat::getName($format));
      }
    }
  }


  /**
   * Return the tag of this entry.
   *
   * @return PelTag the tag of this entry.
   */
  function getTag() {
    return $this->tag;
  }


  /**
   * Return the format of this entry.
   *
   * @return PelFormat the format of this entry.
   */
  function getFormat() {
    return $this->format;
  }


  /**
   * Return the number of components of this entry.
   *
   * @return int the number of components of this entry.
   */
  function getComponents() {
    return $this->components;
  }


  /**
   * Turn this entry into bytes.
   *
   * @param PelByteOrder the desired byte order, which must be either
   * {@link Convert::LITTLE_ENDIAN} or {@link Convert::BIG_ENDIAN}.
   *
   * @return string bytes representing this entry.
   */
  function getBytes($o) {
    return $this->bytes;
  }

  
  /**
   * Get the value of this entry as text.
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
  abstract function getText($brief = false);


  /**
   * Get the value of this entry.
   *
   * The value returned will generally be the same as the one supplied
   * to the constructor or with {@link setValue()}.  For a formatted
   * version of the value, one should use {@link getText()} instead.
   *
   * @return mixed the unformatted value.
   */
  abstract function getValue();


  /**
   * Set the value of this entry.
   *
   * The value should be in the same format as for the constructor.
   *
   * @param mixed the new value.
   *
   * @abstract
   */
  function setValue($value) {
    /* This (fake) abstract method is here to make it possible for the
     * documentation to refer to PelEntry::setValue().
     *
     * It cannot declared abstract in the proper PHP way, for then PHP
     * wont allow subclasses to define it with two arguments (which is
     * what PelEntryCopyright does).
     */
    throw new PelException('setValue() is abstract.');
  }


  /**
   * Turn this entry into a string.
   *
   * @return string a string representation of this entry.  This is
   * mostly for debugging.
   */
  function __toString() {
    $str = Pel::fmt("  Tag: 0x%04X (%s)\n",
                    $this->tag, PelTag::getName($this->tag));
    $str .= Pel::fmt("    Format    : %d (%s)\n",
                     $this->format, PelFormat::getName($this->format));
    $str .= Pel::fmt("    Components: %d\n", $this->components);
    if ($this->getTag() != PelTag::MAKER_NOTE)
      $str .= Pel::fmt("    Value     : %s\n", print_r($this->getValue(), true));
    $str .= Pel::fmt("    Text      : %s\n", $this->getText());
    return $str;
  }
}

?>