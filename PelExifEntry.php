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
 * Classes for dealing with EXIF entries.
 *
 * This file defines two exception classes and the abstract class
 * {@link PelExifEntry} which provides the basic methods that all EXIF
 * entries will have.  All EXIF entries will be represented by
 * descendants of the {@link PelExifEntry} class.
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
require_once('PelException.php');
/** Class definition of {@link PelDataWindow}. */
require_once('PelDataWindow.php');

/** Class definition of {@link PelExifTag}. */
require_once('PelExifTag.php');
/** Class definition of {@link PelExifFormat}. */
require_once('PelExifFormat.php');

/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelUnexpectedFormatException extends PelException {
  function __construct($found, $expected) {
    parent::__construct('Unexpected format found: %s. Expected %s instead.',
                        PelExifFormat::getName($found),
                        PelExifFormat::getName($expected));
  }
}


/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelWrongComponentCountException extends PelException {
  function __construct($found, $expected) {
    parent::__construct('Wrong number of components found: %d. Expected %d.',
                        $found, $expected);
  }
}


/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
abstract class PelExifEntry {

  /**
   * The bytes representing this entry.
   *
   * Subclasses must either override {@link getBytes()} or, if
   * possible, maintain this property so that it always contains a
   * true representation of the entry.
   */
  protected $bytes = '';
  protected $tag;
  protected $format;
  protected $components;

  /*
  function __construct($tag, $format, $components, $bytes) {
    $this->tag        = $tag;
    $this->format     = $format;
    $this->components = $components;
    $this->bytes      = $bytes;
  }
  */

  static function newFromData($tag, $format, $components, $data) {

    /* First handle tags for which we have a speficic PelExifEntryXXX
     * class. */
    switch ($tag) {
    case PelExifTag::DATE_TIME:
    case PelExifTag::DATE_TIME_ORIGINAL:
    case PelExifTag::DATE_TIME_DIGITIZED:
      if ($format != PelExifFormat::ASCII)
        throw new PelUnexpectedFormatException($format, PelExifFormat::ASCII);

      if ($components != 20)
        throw new PelWrongComponentsCountException($components, 20);

      $d = explode('-', strtr($data->getBytes(0, -1), ': ', '--'));
      // TODO: handle timezones.
      require_once('PelExifEntryAscii.php');
      return new PelExifEntryTime($tag, mktime($d[3], $d[4], $d[5],
                                               $d[1], $d[2], $d[0]));

    case PelExifTag::COPYRIGHT:
      if ($format != PelExifFormat::ASCII)
        throw new PelUnexpectedFormatException($format, PelExifFormat::ASCII);
      
      $v = explode("\0", trim($data->getBytes(), ' '));
      require_once('PelExifEntryAscii.php');
      return new PelExifEntryCopyright($v[0], $v[1]);

    case PelExifTag::EXIF_VERSION:
    case PelExifTag::FLASH_PIX_VERSION:
    case PelExifTag::INTEROPERABILITY_VERSION:
      require_once('PelExifEntryUndefined.php');
      return new PelExifEntryVersion($tag, $data->getBytes() / 100);

    case PelExifTag::USER_COMMENT:
      require_once('PelExifEntryUndefined.php');
      if ($data->getSize() < 8) {
        return new PelExifEntryUserComment();
      } else {
        return new PelExifEntryUserComment($data->getBytes(8),
                                           rtrim($data->getBytes(0, 8)));
      }

    default:
      /* Then handle the formats. */
      switch ($format) {
      case PelExifFormat::BYTE:
        require_once('PelExifEntryByte.php');
        $v =  new PelExifEntryByte($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getByte($i*2));
        return $v;

      case PelExifFormat::SBYTE:
        require_once('PelExifEntryByte.php');
        $v =  new PelExifEntryByte($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSByte($i*2));
        return $v;

      case PelExifFormat::ASCII:
        require_once('PelExifEntryAscii.php');
        // TODO: check that $data always has $components bytes so that
        // we can remove the final NULL character like this.
        return new PelExifEntryAscii($tag, $data->getBytes(0, -1));

      case PelExifFormat::SHORT:
        require_once('PelExifEntryShort.php');
        $v =  new PelExifEntryShort($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getShort($i*2));
        return $v;

      case PelExifFormat::SSHORT:
        require_once('PelExifEntryShort.php');
        $v =  new PelExifEntrySShort($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSShort($i*2));
        return $v;

      case PelExifFormat::LONG:
        require_once('PelExifEntryLong.php');
        $v =  new PelExifEntryLong($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getLong($i*4));
        return $v;

      case PelExifFormat::SLONG:
        require_once('PelExifEntryLong.php');
        $v =  new PelExifEntrySLong($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSLong($i*4));
        return $v;

      case PelExifFormat::RATIONAL:
        require_once('PelExifEntryRational.php');
        $v =  new PelExifEntryRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getRational($i*8));
        return $v;

      case PelExifFormat::SRATIONAL:
        require_once('PelExifEntryRational.php');
        $v =  new PelExifEntrySRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSRational($i*8));
        return $v;

      case PelExifFormat::UNDEFINED:
        require_once('PelExifEntryUndefined.php');
        return new PelExifEntryUndefined($tag, $data->getBytes());

      default:
        throw new PelException('Unsupported format: %s',
                               PelExifFormat::getName($format));
      }
    }
  }

  function getTag() {
    return $this->tag;
  }

  function getFormat() {
    return $this->format;
  }

  function getComponents() {
    return $this->components;
  }

  /**
   * Turn this entry into bytes.
   *
   * @param boolean the desired byte order, which must be either
   * {@link Convert::LITTLE_ENDIAN} or {@link Convert::BIG_ENDIAN}.
   *
   * @return string bytes representing this entry.
   */
  function getBytes($o) {
    return $this->bytes;
  }

  
  /**
   * Get the value of an entry as text.
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

  function __toString() {
    $str = sprintf("  Tag: 0x%04X ('%s')\n",
                   $this->tag, PelExifTag::getName($this->tag));
    $str .= sprintf("    Format    : %d ('%s')\n",
                    $this->format,
                    PelExifFormat::getName($this->format));
    $str .= sprintf("    Components: %d\n", $this->components);
    $str .= sprintf("    Value     : %s\n", $this->getText());
    return $str;
  }

}


?>