<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers in JPEG and TIFF images using PHP.
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
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */


/**
 * Classes for dealing with EXIF IFDs.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
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
require_once('PelEntry.php');
require_once('PelTag.php');
require_once('Pel.php');
/**#@-*/


/**
 * Exception indicating a general problem with the IFD.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelIfdException extends PelException {}

/**
 * Class representing an Image File Directory (IFD).
 *
 * {@link PelTiff TIFF data} is structured as a number of Image File
 * Directories, IFDs for short.  Each IFD contains a number of {@link
 * PelEntry entries}, some data and finally a link to the next IFD.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelIfd {

  const IFD0 = 0;
  const IFD1 = 1;
  const EXIF = 2;
  const GPS  = 3;
  const INTEROPERABILITY = 4;

  /**
   * The entries held by this directory.
   *
   * Each tag in the directory is represented by a {@link PelEntry}
   * object in this array.
   *
   * @var array
   */
  private $entries = array();

  /**
   * The type of this directory (not currently used).
   *
   * @var int
   */
  private $type;

  /**
   * The next directory.
   *
   * This will be initialized in the constructor, or be left as null
   * if this is the last directory.
   *
   * @var PelIfd
   */
  private $next = null;

  /**
   * Sub-directories pointed to by this directory.
   *
   * This will be an array of ({@link PelTag}, {@link PelIfd}) pairs.
   *
   * @var array
   */
  private $sub = array();

  /**
   * The thumbnail data.
   *
   * This will be initialized in the constructor, or be left as null
   * if there are no thumbnail as part of this directory.
   *
   * @var PelDataWindow
   */
  private $thumb_data = null;
  // TODO: use this format to choose between the
  // JPEG_INTERCHANGE_FORMAT and STRIP_OFFSETS tags.
  // private $thumb_format;

  
  /**
   * Construct a new Image File Directory (IFD).
   *
   * The IFD will be empty, use the {@link addEntry()} method to add
   * an {@link PelEntry}.  Use the {@link setNext()} method to link
   * this IFD to another.
   */
  function __construct() {

  }


  /**
   * Load data into a Image File Directory (IFD).
   *
   * @param PelDataWindow the data window that will provide the data.
   *
   * @param int the offset within the window where the directory will
   * be found.
   */
  function load(PelDataWindow $d, $offset) {
    $thumb_offset = 0;
    $thumb_length = 0;

    Pel::debug('Constructing IFD at offset %d from %d bytes...',
               $offset, $d->getSize());

    /* Read the number of entries */
    $n = $d->getShort($offset);
    Pel::debug('Loading %d entries...', $n);
    
    $offset += 2;

    /* Check if we have enough data. */
    if ($offset + 12 * $n > $d->getSize()) {
      $n = floor(($offset - $d->getSize()) / 12);
      Pel::warning('Adjusted number of entries to %d.', $n);
    }

    for ($i = 0; $i < $n; $i++) {
      // TODO: increment window start instead of using offsets.
      $tag = $d->getShort($offset + 12 * $i);
      Pel::debug('Loading entry %s (%d of %d)...',
                 PelTag::getName($tag), $i + 1, $n);
      
      switch ($tag) {
      case PelTag::EXIF_IFD_POINTER:
      case PelTag::GPS_INFO_IFD_POINTER:
      case PelTag::INTEROPERABILITY_IFD_POINTER:
        $o = $d->getLong($offset + 12 * $i + 8);
        // println('Found sub IFD');
        $this->sub[$tag] = new PelIfd();
        $this->sub[$tag]->load($d, $o);
        break;
      case PelTag::JPEG_INTERCHANGE_FORMAT:
        $thumb_offset = $d->getLong($offset + 12 * $i + 8);
        $this->safeSetThumbnail($d, $thumb_offset, $thumb_length);
        break;
      case PelTag::JPEG_INTERCHANGE_FORMAT_LENGTH:
        $thumb_length = $d->getLong($offset + 12 * $i + 8);
        $this->safeSetThumbnail($d, $thumb_offset, $thumb_length);
        break;
      default:
        $format     = $d->getShort($offset + 12 * $i + 2);
        $components = $d->getLong($offset + 12 * $i + 4);
        
        /* The data size.  If bigger than 4 bytes, the actual data is
         * not in the entry but somewhere else, with the offset stored
         * in the entry.
         */
        $s = PelFormat::getSize($format) * $components;
        if ($s > 0) {    
          if ($s > 4)
            $doff = $d->getLong($offset + 12 * $i + 8);
          else
            $doff = $offset + 12 * $i + 8;

          $data = $d->getClone($doff, $s);
        } else {
          $data = new PelDataWindow();
        }

        try {
          $entry = PelEntry::newFromData($tag, $format, $components, $data);
          $this->entries[$tag] = $entry;
        } catch (PelEntryException $e) {
          Pel::warning('Could not load entry %d: %s', $i, $e->getMessage());
        }

        /* The format of the thumbnail is stored in this tag. */
//         TODO: handle TIFF thumbnail.
//         if ($tag == PelTag::COMPRESSION) {
//           $this->thumb_format = $data->getShort();
//         }
        
        
//         if (ExifTag::isKnownTag($tag)) {
//           $this->entries[] = new PelEntry($data, $offset + 12 * $i, $order);
//         } else {
//           // TODO: should we bail out completely like libexif does
//           // because we claim to know all EXIF tags?
//           printf("Unknown EXIF tag: 0x%02X\n", $tag);
//         }
        break;
      }
    }

    /* Offset to next IFD */
    Pel::debug('Current offset is %d, reading link at %d',
               $offset,  $offset + 12 * $n);
    $o = $d->getLong($offset + 12 * $n);
    if ($o > 0) {
      // println('Next IFD is at offset %d', $o);
      /* Sanity check. */
      if ($o > $d->getSize() - 6)
        throw new PelIfdException('Bogus offset!');

      $this->next = new PelIfd();
      $this->next->load($d, $o);
    } else {
      // println('That was the last IFD');
    }
  }


  /**
   * Extract thumbnail data safely.
   *
   * It is safe to call this method repeatedly with either the offset
   * or the length set to zero, since it requires both of these
   * arguments to be positive before the thumbnail is extracted.
   *
   * When both parameters are set it will check the length against the
   * available data and adjust as necessary. Only then is the
   * thumbnail data loaded.
   *
   * @param PelDataWindow the data from which the thumbnail will be
   * extracted.
   *
   * @param int the offset into the data.
   *
   * @param int the length of the thumbnail.
   */
  private function safeSetThumbnail(PelDataWindow $d, $offset, $length) {
    /* Load the thumbnail if both the offset and the length is
     * available. */
    if ($offset > 0 && $length > 0) {
      /* Some images have a broken length, so we try to carefully
       * check the length before we store the thumbnail. */
      if ($offset + $length > $d->getSize()) {
        Pel::warning('Thumbnail length %d bytes adjusted to %d bytes.',
                     $length, $d->getSize() - $offset);
        $length = $d->getSize() - $offset;
      }

      /* Now set the thumbnail normally. */
      $this->setThumbnail($d->getClone($offset, $length));
    }
  }

  
  /**
   * Set thumbnail data.
   *
   * Use this to embed an arbitrary JPEG image within this IFD. The
   * data will be checked to ensure that it has a proper {@link
   * PelJpegMarker::EOI} at the end.  If not, then the length is
   * adjusted until one if found.  A warning is issued in this case.
   *
   * @param PelDataWindow the thumbnail data.
   */
  function setThumbnail(PelDataWindow $d) {
    $size = $d->getSize();
    /* Now move backwards until we find the EOI JPEG marker. */
    while ($d->getByte($size - 2) != 0xFF ||
           $d->getByte($size - 1) != PelJpegMarker::EOI) {
      $size--;
    }

    if ($size != $d->getSize())
      Pel::warning('Decrementing thumbnail size to %d bytes', $size);
    
    $this->thumb_data = $d->getClone(0, $size);
  }


  /**
   * Get the name of this directory (not currently used).
   *
   * @return string the name of this directory.
   */
  function getName() {
    switch ($this->type) {
    case self::IFD0: return '0';
    case self::IFD1: return '1';
    case self::EXIF: return 'EXIF';
    case self::GPS:  return 'GPS';
    case self::INTEROPERABILITY: return 'Interoperability';
    }
  }


  /**
   * Adds an entry to the directory.
   *
   * @param PelEntry the entry that will be added.
   *
   * @todo The entry will be identified with its tag, so each
   * directory can only contain one entry with each tag.  Is this a
   * bug?
   */
  function addEntry(PelEntry $e) {
    $this->entries[$e->getTag()] = $e;
  }


  /**
   * Retrieve an entry.
   *
   * @param PelTag the tag identifying the entry.
   *
   * @return PelEntry the entry associated with the tag, or null if no
   * such entry exists.
   */
  function getEntry($tag) {
    if (isset($this->entries[$tag]))
      return $this->entries[$tag];
    else
      return null;
  }


  /**
   * Returns all entries contained in this IFD.
   *
   * @return array an array of {@link PelEntry} objects, or rather
   * descendant classes.  The array has {@link PelTag}s as keys
   * and the entries as values.
   *
   * @see getEntry
   */
  function getEntries() {
    return $this->entries;
  }


  /**
   * Returns available thumbnail data.
   *
   * @return string the bytes in the thumbnail, if any.  If the IFD
   * does not contain any thumbnail data, the empty string is
   * returned.
   *
   * @todo Throw an exception instead when no data is available?
   *
   * @todo Return the $this->thumb_data object instead of the bytes?
   */
  function getThumbnailData() {
    if ($this->thumb_data != null)
      return $this->thumb_data->getBytes();
    else
      return '';
  }
  

  /**
   * Make this directory point to a new directory.
   *
   * @param PelIfd the IFD that this directory will point to.
   */
  function setNextIfd(PelIfd $i) {
    $this->next = $i;
  }


  /**
   * Return the IFD pointed to by this directory.
   *
   * @return PelIfd the next IFD, following this IFD. If this is the
   * last IFD, null is returned.
   */
  function getNextIfd() {
    return $this->next;
  }


  /**
   * Check if this is the last IFD.
   *
   * @return boolean true if there are no following IFD, false
   * otherwise.
   */
  function isLastIfd() {
    return $this->next == null;
  }


  /**
   * Return a sub IFD.
   *
   * @param PelTag the tag of the sub IFD.  This should be one of
   * {@link PelTag::EXIF_IFD_POINTER}, {@link
   * PelTag::GPS_INFO_IFD_POINTER}, or {@link
   * PelTag::INTEROPERABILITY_IFD_POINTER}.
   *
   * @return PelIfd the IFD associated with the tag, or null if
   * that sub IFD does not exist.
   */
  function getSubIfd($tag) {
    if (isset($this->sub[$tag]))
      return $this->sub[$tag];
    else
      return null;
  }


  /**
   * Get all sub IFDs.
   *
   * @return array an array with ({@link PelTag}, {@link PelIfd})
   * pairs.
   */
  function getSubIfds() {
    return $this->sub;
  }


  /**
   * Turn this directory into bytes.
   *
   * This directory will be turned into a byte string, with the
   * specified byte order.  The offsets will be calculated from the
   * offset given.
   *
   * @param int the offset of the first byte of this directory.
   *
   * @param PelByteOrder the byte order that should be used when
   * turning integers into bytes.  This should be one of {@link
   * PelConvert::LITTLE_ENDIAN} and {@link PelConvert::BIG_ENDIAN}.
   */
  function getBytes($offset, $order) {
    $bytes = '';
    $extra_bytes = '';

    Pel::debug('Bytes from IDF will start at offset %d within EXIF data',
               $offset);
    
    $n = count($this->entries) + count($this->sub);
    if ($this->thumb_data != null) {
      /* We need two extra entries for the thumbnail offset and
       * length. */
      $n += 2;
    }

    $bytes .= PelConvert::shortToBytes($n, $order);

    /* Initialize offset of extra data.  This included the bytes
     * preceding this IFD, the bytes needed for the count of entries,
     * the entries themselves (and sub entries), the extra data in the
     * entries, and the IFD link.
     */
    $end = $offset + 2 + 12 * $n + 4;

    foreach ($this->entries as $tag => $entry) {
      /* Each entry is 12 bytes long. */
      $bytes .= PelConvert::shortToBytes($entry->getTag(), $order);
      $bytes .= PelConvert::shortToBytes($entry->getFormat(), $order);
      $bytes .= PelConvert::longToBytes($entry->getComponents(), $order);
      
      /*
       * Size? If bigger than 4 bytes, the actual data is not in
       * the entry but somewhere else.
       */
      $data = $entry->getBytes($order);
      $s = strlen($data);
      if ($s > 4) {
        Pel::debug('Data size %d too big, storing at offset %d instead.',
                   $s, $end);
        $bytes .= PelConvert::longToBytes($end, $order);
        $extra_bytes .= $data;
        $end += $s;
      } else {
        Pel::debug('Data size %d fits.', $s);
        /* Copy data directly, pad with NULL bytes as necessary to
         * fill out the four bytes available.*/
        $bytes .= $data . str_repeat(chr(0), 4 - $s);
      }
    }

    if ($this->thumb_data != null) {
      Pel::debug('Appending %d bytes of thumbnail data at %d',
                 $this->thumb_data->getSize(), $end);
      // TODO: make PelEntry a class that can be constructed with
      // arguments corresponding to the newt four lines.
      $bytes .= PelConvert::shortToBytes(PelTag::JPEG_INTERCHANGE_FORMAT_LENGTH,
                                         $order);
      $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
      $bytes .= PelConvert::longToBytes(1, $order);
      $bytes .= PelConvert::longToBytes($this->thumb_data->getSize(),
                                        $order);
      
      $bytes .= PelConvert::shortToBytes(PelTag::JPEG_INTERCHANGE_FORMAT,
                                         $order);
      $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
      $bytes .= PelConvert::longToBytes(1, $order);
      $bytes .= PelConvert::longToBytes($end, $order);
      
      $extra_bytes .= $this->thumb_data->getBytes();
      $end += $this->thumb_data->getSize();
    }

    
    /* Find bytes from sub IFDs. */
    $sub_bytes = '';
    foreach ($this->sub as $tag => $sub) {
      /* Make an aditional entry with the pointer. */
      $bytes .= PelConvert::shortToBytes($tag, $order);
      /* Next the format, which is always unsigned long. */
      $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
      /* There is only one component. */
      $bytes .= PelConvert::longToBytes(1, $order);

      $data = $sub->getBytes($end, $order);
      $s = strlen($data);
      $sub_bytes .= $data;

      $bytes .= PelConvert::longToBytes($end, $order);
      $end += $s;
    }

    /* Make link to next IFD, if any*/
    if ($this->isLastIFD()) {
      $link = 0;
    } else {
      $link = $end;
    }

    Pel::debug('Link to next IFD: %d', $link);
    
    $bytes .= PelConvert::longtoBytes($link, $order);

    $bytes .= $extra_bytes . $sub_bytes;

    if (!$this->isLastIfd())
      $bytes .= $this->next->getBytes($end, $order);

    return $bytes;
  }

  
  /**
   * Turn this directory into text.
   *
   * @return string information about the directory, mainly for
   * debugging.
   */
  function __toString() {
    $str = Pel::fmt("Dumping EXIF IFD %s with %d entries...\n",
                    $this->getName(), count($this->entries));
    
    foreach ($this->entries as $entry)
      $str .= $entry->__toString();

    $str .= Pel::fmt("Dumping %d sub IFDs...\n", count($this->sub));

    foreach ($this->sub as $tag => $ifd)
      $str .= $ifd->__toString();

    if ($this->next != null)
      $str .= $this->next->__toString();

    return $str;
  }


}

?>