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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage EXIF
 */


/** Class definition of {@link PelException}. */
include_once('PelException.php');
/** Class definition of {@link PelDataWindow}. */
include_once('PelDataWindow.php');

/** Class definition of {@link PelExifTag}. */
include_once('PelExifTag.php');
/** Class definition of {@link PelExifFormat}. */
include_once('PelExifFormat.php');
/** Class definition of {@link PelExifEntryAscii}. */
include_once('PelExifEntryAscii.php');
/** Class definition of {@link PelExifEntryShort}. */
include_once('PelExifEntryShort.php');
/** Class definition of {@link PelExifEntryLong}. */
include_once('PelExifEntryLong.php');
/** Class definition of {@link PelExifEntryRational}. */
include_once('PelExifEntryRational.php');
/** Class definition of {@link PelExifEntryUndefined}. */
include_once('PelExifEntryUndefined.php');

/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifEntryException extends PelException { }

/**
 * @todo turn calls to {@link PelExifFormat::getSize} into the right
 * size of the format when it is known in advance.
 *
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
        throw new PelExifEntryException('Wrong format, found %s, expected %s',
                                        PelExifFormat::getName($format),
                                        PelExifFormat::getName(PelExifFormat::ASCII));
      if ($components != 20)
        throw new PelExifEntryException('Wrong number of components, found %d, ' .
                                        'expected %d', $components, 20);
      
      // println('Making timestamp from "%s"', $data->getBytes(0, -1));

      $d = explode('-', strtr($data->getBytes(0, -1), ': ', '--'));
      // TODO: handle timezones.
      return new PelExifEntryTime($tag, mktime($d[3], $d[4], $d[5],
                                               $d[1], $d[2], $d[0]));

    case PelExifTag::COPYRIGHT:
      if ($format != PelExifFormat::ASCII)
        throw new PelExifEntryException('Wrong format, found %s, expected %s',
                                        PelExifFormat::getName($format),
                                        PelExifFormat::getName(PelExifFormat::ASCII));
      
      $v = explode("\0", trim($data->getBytes(), ' '));
      return new PelExifEntryCopyright($v[0], $v[1]);

    case PelExifTag::EXIF_VERSION:
    case PelExifTag::FLASH_PIX_VERSION:
    case PelExifTag::INTEROPERABILITY_VERSION:
      return new PelExifEntryVersion($tag, $data->getBytes() / 100);

    case PelExifTag::USER_COMMENT:
      if ($data->getSize() < 8) {
        return new PelExifEntryUserComment();
      } else {
        return new PelExifEntryUserComment($data->getBytes(8),
                                           rtrim($data->getBytes(0, 8)));
      }

    default:
      /* Then handle the formats. */
      switch ($format) {
      case PelExifFormat::ASCII:
        // TODO: check that $data always has $components bytes so that
        // we can remove the final NULL character like this.
        return new PelExifEntryAscii($tag, $data->getBytes(0, -1));

      case PelExifFormat::SHORT:
        $v =  new PelExifEntryShort($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getShort($i*2));
        return $v;

      case PelExifFormat::LONG:
        $v =  new PelExifEntryLong($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getLong($i*4));
        return $v;

      case PelExifFormat::RATIONAL:
        $v =  new PelExifEntryRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getRational($i*8));
        return $v;

      case PelExifFormat::SRATIONAL:
        $v =  new PelExifEntrySRational($tag);
        for ($i = 0; $i < $components; $i++)
          $v->addNumber($data->getSRational($i*8));
        return $v;

      case PelExifFormat::UNDEFINED:
        return new PelExifEntryUndefined($tag, $data->getBytes());

      default:
        throw new PelException('Unsupported format: %s', PelExifFormat::getName($format));
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