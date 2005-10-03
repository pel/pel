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
 * Classes used to hold data for Exif tags of format undefined.
 *
 * This file contains the base class {@link PelEntryUndefined} and
 * the subclasses {@link PelEntryUserComment} which should be used
 * to manage the {@link PelTag::USER_COMMENT} tag, and {@link
 * PelEntryVersion} which is used to manage entries with version
 * information.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelEntry.php');
/**#@-*/


/**
 * Class for holding data of any kind.
 *
 * This class can hold bytes of undefined format.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryUndefined extends PelEntry {

  /**
   * Make a new PelEntry that can hold undefined data.
   *
   * @param PelTag the tag which this entry represents.  This
   * should be one of the constants defined in {@link PelTag},
   * e.g., {@link PelTag::SCENE_TYPE}, {@link
   * PelTag::MAKER_NOTE} or any other tag with format {@link
   * PelFormat::UNDEFINED}.
   *
   * @param string the data that this entry will be holding.  Since
   * the format is undefined, no checking will be done on the data.
   */
  function __construct($tag, $data = '') {
    $this->tag        = $tag;
    $this->format     = PelFormat::UNDEFINED;
    $this->setValue($data);
  }


  /**
   * Set the data of this undefined entry.
   *
   * @param string the data that this entry will be holding.  Since
   * the format is undefined, no checking will be done on the data.
   */
  function setValue($data) {
    $this->components = strlen($data);
    $this->bytes      = $data;
  }


  /**
   * Get the data of this undefined entry.
   *
   * @return string the data that this entry is holding.
   */
  function getValue() {
    return $this->bytes;
  }


  /**
   * Get the value of this entry as text.
   *
   * The value will be returned in a format suitable for presentation.
   *
   * @param boolean some values can be returned in a long or more
   * brief form, and this parameter controls that.
   *
   * @return string the value as text.
   */
  function getText($brief = false) {
    switch ($this->tag) {
    case PelTag::FILE_SOURCE:
      //CC (e->components, 1, v);
      switch (ord($this->bytes{0})) {
      case 0x03:
        return 'DSC';
      default:
        return sprintf('0x%02X', ord($this->bytes{0}));
      }
   
    case PelTag::SCENE_TYPE:
      //CC (e->components, 1, v);
      switch (ord($this->bytes{0})) {
      case 0x01:
        return 'Directly photographed';
      default:
        return sprintf('0x%02X', ord($this->bytes{0}));
      }
   
    case PelTag::COMPONENTS_CONFIGURATION:
      //CC (e->components, 4, v);
      $v = '';
      for ($i = 0; $i < 4; $i++) {
        switch (ord($this->bytes{$i})) {
        case 0:
          $v .= '-';
          break;
        case 1:
          $v .= 'Y';
          break;
        case 2:
          $v .= 'Cb';
          break;
        case 3:
          $v .= 'Cr';
          break;
        case 4:
          $v .= 'R';
          break;
        case 5:
          $v .= 'G';
          break;
        case 6:
          $v .= 'B';
          break;
        default:
          $v .= 'reserved';
          break;
        }
        if ($i < 3) $v .= ' ';
      }
      return $v;

    case PelTag::MAKER_NOTE:
      // TODO: handle maker notes.
      return $this->components . ' bytes unknown MakerNote data';

    default:
      return '(undefined)';
    }
  }

}


/**
 * Class for a user comment.
 *
 * This class is used to hold user comments, which can come in several
 * different character encodings.  The Exif standard specifies a
 * certain format of the {@link PelTag::USER_COMMENT user comment
 * tag}, and this class will make sure that the format is kept.
 *
 * The most basic use of this class simply stores an ASCII encoded
 * string for later retrieval using {@link getValue}:
 *
 * <code>
 * $entry = new PelEntryUserComment('An ASCII string');
 * echo $entry->getValue();
 * </code>
 *
 * The string can be encoded with a different encoding, and if so, the
 * encoding must be given using the second argument.  The Exif
 * standard specifies three known encodings: 'ASCII', 'JIS', and
 * 'Unicode'.  If the user comment is encoded using a character
 * encoding different from the tree known encodings, then the empty
 * string should be passed as encoding, thereby specifying that the
 * encoding is undefined.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryUserComment extends PelEntryUndefined {

  /**
   * The user comment.
   *
   * @var string
   */
  private $comment;

  /**
   * The encoding.
   *
   * This should be one of 'ASCII', 'JIS', 'Unicode', or ''.
   *
   * @var string
   */
  private $encoding;

  /**
   * Make a new entry for holding a user comment.
   *
   * @param string the new user comment.
   *
   * @param string the encoding of the comment.  This should be either
   * 'ASCII', 'JIS', 'Unicode', or the empty string specifying an
   * undefined encoding.
   */
  function __construct($comment = '', $encoding = 'ASCII') {
    parent::__construct(PelTag::USER_COMMENT);
    $this->setValue($comment, $encoding);
  }

  
  /**
   * Set the user comment.
   *
   * @param string the new user comment.
   *
   * @param string the encoding of the comment.  This should be either
   * 'ASCII', 'JIS', 'Unicode', or the empty string specifying an
   * unknown encoding.
   */
  function setValue($comment = '', $encoding = 'ASCII') {
    $this->comment  = $comment;
    $this->encoding = $encoding;
    parent::setValue(str_pad($encoding, 8, chr(0)) . $comment);
  }


  /**
   * Returns the user comment.
   *
   * The comment is returned with the same character encoding as when
   * it was set using {@link setValue} or {@link __construct the
   * constructor}.
   *
   * @return string the user comment.
   */
  function getValue() {
    return $this->comment;
  }


  /**
   * Returns the encoding.
   *
   * @return string the encoding of the user comment.
   */
  function getEncoding() {
    return $this->encoding;
  }


  /**
   * Returns the user comment.
   *
   * @return string the user comment.
   */
  function getText($brief = false) {
    return $this->comment;
  }

}


/**
 * Class to hold version information.
 *
 * There are three Exif entries that hold version information: the
 * {@link PelTag::EXIF_VERSION}, {@link
 * PelTag::FLASH_PIX_VERSION}, and {@link
 * PelTag::INTEROPERABILITY_VERSION} tags.  This class manages
 * those tags.
 *
 * The class is used in a very straight-forward way:
 * <code>
 * $entry = new PelEntryVersion(PelTag::EXIF_VERSION, 2.2);
 * </code>
 * This creates an entry for an file complying to the Exif 2.2
 * standard.  It is easy to test for standards level of an unknown
 * entry:
 * <code>
 * if ($entry->getTag() == PelTag::EXIF_VERSION &&
 *     $entry->getValue() > 2.0) {
 *   echo 'Recent Exif version.';
 * }
 * </code>
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryVersion extends PelEntryUndefined {

  /**
   * The version held by this entry.
   *
   * @var float
   */
  private $version;


  /**
   * Make a new entry for holding a version.
   *
   * @param PelTag the tag.  This should be one of {@link
   * PelTag::EXIF_VERSION}, {@link PelTag::FLASH_PIX_VERSION},
   * or {@link PelTag::INTEROPERABILITY_VERSION}.
   *
   * @param float the version.  The size of the entries leave room for
   * exactly four digits: two digits on either side of the decimal
   * point.
   */
  function __construct($tag, $version = 0.0) {
    parent::__construct($tag);
    $this->setValue($version);
  }


  /**
   * Set the version held by this entry.
   *
   * @param float the version.  The size of the entries leave room for
   * exactly four digits: two digits on either side of the decimal
   * point.
   */
  function setValue($version = 0.0) {
    $this->version = $version;
    $major = floor($version);
    $minor = ($version - $major)*100;
    parent::setValue(sprintf('%02.0f%02.0f', $major, $minor));
  }


  /**
   * Return the version held by this entry.
   *
   * @return float the version.  This will be the same as the value
   * given to {@link setValue} or {@link __construct the
   * constructor}.
   */
  function getValue() {
    return $this->version;
  }

 
  /**
   * Return a text string with the version.
   *
   * @param boolean controls if the output should be brief.  Brief
   * output omits the word 'Version' so the result is just 'Exif x.y'
   * instead of 'Exif Version x.y' if the entry holds information
   * about the Exif version --- the output for FlashPix is similar.
   *
   * @return string the version number with the type of the tag,
   * either 'Exif' or 'FlashPix'.
   */
  function getText($brief = false) {
    $v = $this->version;

    /* Versions numbers like 2.0 would be output as just 2 if we don't
     * add the '.0' ourselves. */
    if (floor($this->version) == $this->version)
      $v .= '.0';

    switch ($this->tag) {
    case PelTag::EXIF_VERSION:
      if ($brief)
        return Pel::fmt('Exif %s', $v);
      else
        return Pel::fmt('Exif Version %s', $v);
      
    case PelTag::FLASH_PIX_VERSION:
      if ($brief)
        return Pel::fmt('FlashPix %s', $v);
      else
        return Pel::fmt('FlashPix Version %s', $v);
      
    case PelTag::INTEROPERABILITY_VERSION:
      if ($brief)
        return Pel::fmt('Interoperability %s', $v);
      else
        return Pel::fmt('Interoperability Version %s', $v);
    }

    if ($brief)
      return $v;
    else
      return Pel::fmt('Version %s', $v);
    
  }

}

?>