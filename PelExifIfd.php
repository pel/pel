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
 * Classes for dealing with EXIF IFDs.
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
/** Class definition of {@link PelDataWindow}. */
include_once('PelDataWindow.php');

/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifIfdException extends PelException {}

/**
 * Class representing an EXIF IFD.
 *
 * {@link PelExifData EXIF data} is structured as a number of Image
 * File Directories, IFDs for short.  Each IFD contains a number of
 * {@link PelExifEntry entries}, some data and finally a link to the
 * next IFD.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage EXIF
 */
class PelExifIfd {

  const IFD0 = 0;
  const IFD1 = 1;
  const EXIF = 2;
  const GPS  = 3;
  const INTEROPERABILITY = 4;

  /* PelExifEntry array */
  private $entries = array();
  private $type;
  private $offset;
  private $order;
  /* The next PelExifIfd or null if this is the last. */
  private $next = null;
  /* Sub Ifds pointed to by this Ifd, as PelExifTag => PelExifIfd pairs. */
  private $sub = array();

  private $thumb_data = null;
  // TODO: use this format to choose between the
  // JPEG_INTERCHANGE_FORMAT and STRIP_OFFSETS tags.
  // private $thumb_format;

  
  /* Construct a new Image File Directory (IFD) from the data passed
   * in $data.  The IFD will be constructed using data starting at offset
   * $offset. */
  function __construct(PelDataWindow $d, $offset) {
    $thumb_offset = 0;
    $thumb_length = 0;

    $this->order  = $d->getByteOrder();
    $this->offset = $offset;

    // println('Constructing IFD at offset %d from %d bytes...', $offset, $d->getSize());

    /* Read the number of entries */
    $n = $d->getShort($offset);
    // println('Loading %d entries...', $n);
    
    $offset += 2;

    /* Check if we have enough data. */
    if ($offset + 12 * $n > $d->getSize()) {
      $n = floor(($offset - $d->getSize()) / 12);
      // println('Adjusted number of entries to %d.', $n);
    }

    for ($i = 0; $i < $n; $i++) {
      // TODO: increment window start instead of using offsets.
      $tag = $d->getShort($offset + 12 * $i);
      // println('Loading entry %s (%d of %d)...', PelExifTag::getName($tag), $i + 1, $n);
      
      switch ($tag) {
      case PelExifTag::EXIF_IFD_POINTER:
      case PelExifTag::GPS_INFO_IFD_POINTER:
      case PelExifTag::INTEROPERABILITY_IFD_POINTER:
        $o = $d->getLong($offset + 12 * $i + 8);
        // println('Found sub IFD');
        $this->sub[$tag] = new PelExifIfd($d, $o);
        break;
      case PelExifTag::JPEG_INTERCHANGE_FORMAT:
        $thumb_offset = $d->getLong($offset + 12 * $i + 8);
        // println('Thumbnail data at %d.', $thumb_offset);
        
        /* Load the thumbnail if we've found both the offset and the
         * length. */
        if ($thumb_offset > 0 && $thumb_length > 0)
          $this->thumb_data = $d->getClone($thumb_offset, $thumb_length);
        
        break;
      case PelExifTag::JPEG_INTERCHANGE_FORMAT_LENGTH:
        $thumb_length = $d->getLong($offset + 12 * $i + 8);
        // println('Thumbnail size: %d.', $thumb_length);

        /* Load the thumbnail if we've found both the offset and the
         * length. */
        if ($thumb_offset > 0 && $thumb_length > 0) {
          $this->thumb_data = $d->getClone($thumb_offset, $thumb_length);
          // println('Thumbail loaded: ' . $this->thumb_data->__toString());
        }        

        break;

      default:
        $format     = $d->getShort($offset + 12 * $i + 2);
        $components = $d->getLong($offset + 12 * $i + 4);
        
        /*
         * Size? If bigger than 4 bytes, the actual data is not in the
         * entry but somewhere else (offset).
         */
        $s = PelExifFormat::getSize($format) * $components;
        if ($s > 0) {    
          if ($s > 4)
            $doff = $d->getLong($offset + 12 * $i + 8);
          else
            $doff = $offset + 12 * $i + 8;

          /* Sanity check */
          // TODO: remove these checks if PelDataWindow is going to do them
          // anyway.
          //if ($d->getSize() < $doff + $s)
          //  throw new PelExifEntryException('Not enough data.');
          
          $data = $d->getClone($doff, $s);
        } else {
          $data = new PelDataWindow();
        }

        $entry = PelExifEntry::newFromData($tag, $format, $components, $data);
        $this->entries[$tag] = $entry;

        /* The format of the thumbnail is stored in this tag. */
//         TODO: handle TIFF thumbnail.
//         if ($tag == PelExifTag::COMPRESSION) {
//           $this->thumb_format = $data->getShort();
//         }
        
        
//         if (ExifTag::isKnownTag($tag)) {
//           $this->entries[] = new PelExifEntry($data, $offset + 12 * $i, $order);
//         } else {
//           // TODO: should we bail out completely like libexif does
//           // because we claim to know all EXIF tags?
//           printf("Unknown EXIF tag: 0x%02X\n", $tag);
//         }
        break;
      }
    }

    /* Offset to next IFD */
    // println('Current offset is %d, reading link at %d', $offset,  $offset + 12 * $n);
    $o = $d->getLong($offset + 12 * $n);
    if ($o > 0) {
      // println('Next IFD is at offset %d', $o);
      /* Sanity check. */
      if ($o > $d->getSize() - 6)
        throw new PelExifIfdException('Bogus offset!');

      $this->next = new PelExifIfd($d, $o);
    } else {
      // println('That was the last IFD');
    }
  }


  function getName() {
    switch ($this->type) {
    case self::IFD0: return '0';
    case self::IFD1: return '1';
    case self::EXIF: return 'EXIF';
    case self::GPS:  return 'GPS';
    case self::INTEROPERABILITY: return 'Interoperability';
    }
  }

  function addEntry(PelExifEntry $e) {
    $this->entries[$e->getTag()] = $e;
  }

  function getEntry($tag) {
    if (isset($this->entries[$tag]))
      return $this->entries[$tag];
    else
      return null;
  }

  function getEntries() {
    return $this->entries;
  }
  

  function setNextIfd(ExifIfd $i) {
    $this->next = $i;
  }

  function getNextIfd() {
    return $this->next;
  }

  function isLastIfd() {
    return $this->next == null;
  }


  /**
   * Return a sub IFD.
   *
   * @param PelExifTag the tag of the sub IFD.  This should be one of
   * {@link PelExifTag::EXIF_IFD_POINTER}, {@link
   * PelExifTag::GPS_INFO_IFD_POINTER}, or {@link
   * PelExifTag::INTEROPERABILITY_IFD_POINTER}.
   *
   * @return PelExifIfd the IFD associated with the tag, or null if
   * that sub IFD doesn't exist.
   */
  function getSubIfd($tag) {
    if (isset($this->sub[$tag]))
      return $this->sub[$tag];
    else
      return null;
  }

  function getSubIfds() {
    return $this->sub;
  }


  function getBytes($offset, $order) {
    $bytes = '';
    $extra_bytes = '';

    // println('Bytes from IDF will start at offset %d within EXIF data', $offset);

    $n = count($this->entries) + count($this->sub);
    if ($this->thumb_data != null) {
      /* We need two extra entries for the thumbnail offset and
       * length. */
      $n += 2;
    }

//     println('Writing %d + %d + %d = %d entries to bytes...',
//             count($this->entries),
//             count($this->sub),
//             $this->thumb_data == null ? 0 : 2,
//             $n);

    $bytes .= PelConvert::shortToBytes($n, $this->order);

    /* Initialize offset of extra data.  This included the bytes
     * preceding this IFD, the bytes needed for the count of entries,
     * the entries themselves (and sub entries), the extra data in the
     * entries, and the IFD link.
     */
    $end = $offset + 2 + 12 * $n + 4;

    // println('Final byte of this IFD minimum %d.', $end);

    foreach ($this->entries as $tag => $entry) {
      
      // println('Bytes from tag 0x%04X %s', $tag, PelExifTag::getName($tag));

      /* Each entry is 12 bytes long. */
      $bytes .= PelConvert::shortToBytes($entry->getTag(),
                                         $this->order);
      $bytes .= PelConvert::shortToBytes($entry->getFormat(),
                                         $this->order);
      $bytes .= PelConvert::longToBytes($entry->getComponents(),
                                        $this->order);
      
      /*
       * Size? If bigger than 4 bytes, the actual data is not in
       * the entry but somewhere else.
       */
      $data = $entry->getBytes($order);
      $s = strlen($data);
      if ($s > 4) {
        // println('Data size %d too big, storing at offset %d instead.', $s, $end);
        $bytes .= PelConvert::longToBytes($end, $this->order);
        $extra_bytes .= $data;
        $end += $s;
      } else {
        // println('Data size %d fits.', $s);
        /* Copy data directly, pad with NULL bytes as necessary to
         * fill out the four bytes available.*/
        $bytes .= $data . str_repeat(chr(0), 4 - $s);
      }
    }

    if ($this->thumb_data != null) {
//       println('Appending %d bytes of thumbnail data at %d',
//               $this->thumb_data->getSize(), $end);
      // TODO: make PelExifEntry a class that can be constructed with
      // arguments corresponding to the newt four lines.
      $bytes .= PelConvert::shortToBytes(PelExifTag::JPEG_INTERCHANGE_FORMAT_LENGTH,
                                      $this->order);
      $bytes .= PelConvert::shortToBytes(PelExifFormat::LONG, $this->order);
      $bytes .= PelConvert::longToBytes(1, $this->order);
      $bytes .= PelConvert::longToBytes($this->thumb_data->getSize(),
                                     $this->order);
      
      $bytes .= PelConvert::shortToBytes(PelExifTag::JPEG_INTERCHANGE_FORMAT,
                                      $this->order);
      $bytes .= PelConvert::shortToBytes(PelExifFormat::LONG, $this->order);
      $bytes .= PelConvert::longToBytes(1, $this->order);
      $bytes .= PelConvert::longToBytes($end, $this->order);
      
      $extra_bytes .= $this->thumb_data->getBytes();
      $end += $this->thumb_data->getSize();
    }

    
    /* Find bytes from sub IFDs. */
    $sub_bytes = '';
    foreach ($this->sub as $tag => $sub) {
      /* Make an aditional entry with the pointer. */
      $bytes .= PelConvert::shortToBytes($tag, $this->order);
      /* Next the format, which is always unsigned long. */
      $bytes .= PelConvert::shortToBytes(PelExifFormat::LONG, $this->order);
      /* There's only one component. */
      $bytes .= PelConvert::longToBytes(1, $this->order);

      $data = $sub->getBytes($end, $this->order);
      $s = strlen($data);
      $sub_bytes .= $data;

      $bytes .= PelConvert::longToBytes($end, $this->order);
      $end += $s;
    }

    /* Make link to next IFD, if any*/
    if (self::isLastIFD()) {
      $link = 0;
    } else {
      $link = $end;
    }

    // println('Link to next IFD: %d', $link);

    $bytes .= PelConvert::longtoBytes($link, $this->order);

    $bytes .= $extra_bytes . $sub_bytes;

    if (!self::isLastIfd())
      $bytes .= $this->next->getBytes($end, $this->order);

    return $bytes;
  }


  function __toString() {
    $str = sprintf("Dumping EXIF IFD %s with %d entries...\n",
                   self::getName(), count($this->entries));
    
    foreach ($this->entries as $entry)
      $str .= $entry->__toString();

    $str .= sprintf("Dumping %d sub IFDs...\n", count($this->sub));

    foreach ($this->sub as $tag => $ifd)
      $str .= $ifd->__toString();

    if ($this->next != null)
      $str .= $this->next->__toString();

    return $str;
  }


}

?>