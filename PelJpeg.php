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
 * Classes representing JPEG data.
 *
 * The {@link PelJpeg} class defined here provides an abstraction for
 * dealing with a JPEG file.  The file will be contain a number of
 * sections containing some {@link PelJpegContent content} identified
 * by a {@link PelJpegMarker marker}.
 *
 * The {@link getSection()} method is used to pick out a particular
 * section --- the EXIF information is typically stored in the {@link
 * PelJpegMarker::APP1 APP1} section, and so one would get hold of it
 * by saying:
 *
 * <code>
 * $jpeg = new PelJpeg($data);
 * $tiff = $jpeg->getSection(PelJpegMarker::APP1);
 * $ifd0 = $tiff->getIfd();
 * $exif = $ifd0->getSubIfd(PelTag::EXIF_IFD_POINTER);
 * $ifd1 = $ifd0->getNextIfd();
 * </code>
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelJpegContent.php');
require_once('PelJpegMarker.php');
require_once('PelException.php');
require_once('PelExif.php');
require_once('Pel.php');
/**#@-*/


/**
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelJpegInvalidMarkerException extends PelException {

  function __construct($marker, $offset) {
    parent::__construct('Invalid marker found at offset %d: 0x%2X',
                        $offset, $marker);
  }
}

/**
 * Class for handling JPEG data.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelJpeg {

  private $count = 0;
  
  /**
   * The sections in the JPEG data.
   *
   * A JPEG file is built up as a sequence of sections, each section
   * is identified with a {@link PelJpegMarker}.  Some sections can
   * occur more than once in the JPEG stream (the {@link
   * PelJpegMarker::DQT DQT} and {@link PelJpegMarker::DHT DTH}
   * markers for example) and so this is an array of ({@link
   * PelJpegMarker}, {@link PelJpegContent}) pairs.
   *
   * The content can be either generic {@link PelJpegContent JPEG
   * content} or {@link PelExif EXIF data}.
   *
   * @var array
   */
  private $sections = array();

  /**
   * The JPEG image data.
   *
   * @var PelDataWindow
   */
  private $jpeg_data = null;


  /**
   * Construct a new JPEG object.
   *
   * The data supplied will be parsed and turned into an object
   * structure representing the image.  This structure can then be
   * manipulated and later turned back into an string of bytes.
   *
   * @param PelDataWindow the data that will be used to construct the
   * object.
   *
   * @todo Make the constructor take a plain string with bytes instead
   * of requiring the {@link PelDataWindow} object?
   */
  function __construct(PelDataWindow $d) {

    Pel::debug('Parsing %d bytes...', $d->getSize());

    /* JPEG data is stored in big-endian format. */
    $d->setByteOrder(PelConvert::BIG_ENDIAN);
    
    /* Run through the data to read the sections in the image.  After
     * each section is read, the start of the data window will be
     * moved forward, and after the last section we'll terminate with
     * no data left in the window. */
    while ($d->getSize() > 0) {
      /* JPEG sections start with 0xFF. The first byte that is not
       * 0xFF is a marker (hopefully).
       */
      for ($i = 0; $i < 7; $i++)
        if ($d->getByte($i) != 0xFF)
          break;

      $marker = $d->getByte($i);

      if (!PelJpegMarker::isValidMarker($marker))
        throw new PelJpegInvalidMarkerException($marker, $i);

      Pel::debug('Found marker 0x%X %-4s offset %d',
                 $marker, PelJpegMarker::getName($marker), $i);

      /* Move window so first byte becomes first byte in this
       * section. */
      $d->setWindowStart($i+1);

      if ($marker == PelJpegMarker::SOI || $marker == PelJpegMarker::EOI) {
        $content = new PelJpegContent(new PelDataWindow());
        $this->appendSection($marker, $content);
      } else {
        /* Read the length of the section.  The length includes the
         * two bytes used to store the length. */
        $len = $d->getShort(0) - 2;
        
        Pel::debug('Found %s section of length %d',
                   PelJpegMarker::getName($marker), $len);

        /* Skip past the length. */
        $d->setWindowStart(2);

        if ($marker == PelJpegMarker::APP1) {
          try {
            $content = new PelExif($d->getClone(0, $len));
          } catch (PelExifInvalidDataException $e) {
            Pel::warning('Found non-EXIF APP1 section.');
            /* We store the data as normal JPEG content if it could
             * not be parsed as EXIF data. */
            $content = new PelJpegContent($d->getClone(0, $len));
          }
          $this->appendSection($marker, $content);
        } else {
          $content = new PelJpegContent($d->getClone(0, $len));
          $this->appendSection($marker, $content);
          
          /* In case of SOS, image data will follow. */
          if ($marker == PelJpegMarker::SOS) {
            $this->jpeg_data = $d->getClone($len, -2);
            Pel::debug('JPEG data: ' . $this->jpeg_data->__toString());

            /* Skip past the JPEG data. */
            $d->setWindowStart($this->jpeg_data->getSize());
          }
        }
        /* Skip past the data from the last marker. */
        $d->setWindowStart($len);
      }
    }
  }
  

  /**
   * Add a new section.
   *
   * @param PelJpegMarker the marker identifying the new section.
   *
   * @param PelJpegContent the content of the new section.
   */
  function appendSection($marker, PelJpegContent $content) {
    $this->sections[] = array($marker, $content);
  }


  /**
   * Get a sections corresponding to a particular marker.
   *
   * This will search through the sections of this JPEG object,
   * looking for a section identified with the specified {@link
   * PelJpegMarker marker}.  The {@link PelJpegContent content} will
   * then be returned.  The optional argument can be used to skip over
   * some of the sections.  So if one is looking for the, say, third
   * {@link PelJpegMarker::DHT DHT} section one would do:
   *
   * <code>
   * $dht3 = $jpeg->getSection(PelJpegMarker::DHT, 2);
   * </code>
   *
   * whereas one can just do:
   *
   * <code>
   * $app1 = $jpeg->getSection(PelJpegMarker::APP1);
   * </code>
   *
   * to get hold of the first (and normally only) {@link
   * PelJpegMarker::APP1 APP1} section, which would hold the EXIF
   * data.
   *
   * @param PelJpegMarker the marker identifying the section.
   *
   * @param int the number of sections to be skipped.  This must be a
   * non-negative integer.
   *
   * @return PelJpegContent the content found, or null if there is no
   * content available.
   */
  function getSection($marker, $skip = 0) {
    foreach ($this->sections as $s) {
      if ($s[0] == $marker)
        if ($skip > 0)
          $skip--;
        else
          return $s[1];
    }

    return null;        
  }


  /**
   * Get all sections.
   *
   * @return array an array of ({@link PelJpegMarker}, {@link
   * PelJpegContent}) pairs.
   */
  function getSections() {
    return $this->sections;
  }


  /**
   * Turn this JPEG object into bytes.
   *
   * The bytes returned by this method is ready to be stored in a file
   * as a valid JPEG image.
   *
   * @return string bytes representing this JPEG object, including all
   * its sections and their associated data.
   */
  function getBytes() {
    $bytes = '';

    for ($i = 0; $i < $this->count; $i++) {
      $m = $this->sections[$i][0];
      $c = $this->sections[$i][1];

      /* Write the marker */
      $bytes .= "\xFF" . PelJpegMarker::getBytes($m);
      if ($m == PelJpegMarker::SOI ||
          $m == PelJpegMarker::EOI)
        continue;

      $data = $c->getBytes();
      $size = strlen($data);
      
      $bytes .= chr(($size + 2) >> 8);
      $bytes .= chr($size + 2);
      $bytes .= $data;
      
      /* In case of SOS, we need to write the JPEG data. */
      if ($m == PelJpegMarker::SOS)
        $bytes .= $this->jpeg_data->getBytes();
    }

    return $bytes;

  }


  /**
   * Make a string representation of this JPEG object.
   *
   * This is mainly usefull for debugging.  It will show the structure
   * of the image, and its sections.
   *
   * @return string debugging information about this JPEG object.
   */
  function __toString() {
    $str = Pel::tra("Dumping JPEG data...\n");
    for ($i = 0; $i < $this->count; $i++) {
      $m = $this->sections[$i][0];
      $c = $this->sections[$i][1];
      $str .= Pel::fmt("Section %d (marker 0x%02X - %s):\n",
                       $i, $m, PelJpegMarker::getName($m));
      $str .= Pel::fmt("  Description: %s\n",
                       PelJpegMarker::getDescription($m));
      
      if ($m == PelJpegMarker::SOI ||
          $m == PelJpegMarker::EOI)
        continue;
      
      if ($c instanceof PelExif) {
        $str .= Pel::tra("  Content    : EXIF data\n");
        $str .= $c->__toString() . "\n";
      } else {
        $str .= Pel::fmt("  Size       : %d bytes\n", $c->getSize()); 
        $str .= Pel::tra("  Content    : Unknown\n");
      }
    }

    return $str;
  }


  /**
   * Test data to see if it could be a valid JPEG image.
   *
   * The function will only look at the first few bytes of the data,
   * and try to determine if it could be a valid JPEG image based on
   * those bytes.  This means that the check is more like a heuristic
   * than a rigorous check.
   *
   * @param PelDataWindow the bytes that will be checked.
   *
   * @return boolean true if the bytes look like the beginning of a
   * JPEG image, false otherwise.
   *
   * @see PelTiff::isValid()
   */
  static function isValid(PelDataWindow $d) {
    /* JPEG data is stored in big-endian format. */
    $d->setByteOrder(PelConvert::BIG_ENDIAN);
    
    for ($i = 0; $i < 7; $i++)
      if ($d->getByte($i) != 0xFF)
        break;
    
    return $d->getByte($i) == PelJpegMarker::SOI;
  }

}

?>