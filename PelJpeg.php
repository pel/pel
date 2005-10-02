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
 *  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 *  Boston, MA 02110-1301 USA
 */

/* $Id$ */


/**
 * Classes representing JPEG data.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelJpegContent.php');
require_once('PelDataWindow.php');
require_once('PelJpegMarker.php');
require_once('PelException.php');
require_once('PelExif.php');
require_once('Pel.php');
/**#@-*/


/**
 * Exception thrown when an invalid marker is found.
 *
 * This exception is thrown when PEL expects to find a {@link
 * PelJpegMarker} and instead finds a byte that isn't a known marker.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelJpegInvalidMarkerException extends PelException {

  /**
   * Construct a new invalid marker exception.
   *
   * The exception will contain a message describing the error,
   * including the byte found and the offset of the offending byte.
   *
   * @param int the byte found.
   *
   * @param int the offset in the data.
   */
  function __construct($marker, $offset) {
    parent::__construct('Invalid marker found at offset %d: 0x%2X',
                        $offset, $marker);
  }
}

/**
 * Class for handling JPEG data.
 *
 * The {@link PelJpeg} class defined here provides an abstraction for
 * dealing with a JPEG file.  The file will be contain a number of
 * sections containing some {@link PelJpegContent content} identified
 * by a {@link PelJpegMarker marker}.
 *
 * The {@link getSection()} method is used to pick out a particular
 * section --- the EXIF information is typically stored in the {@link
 * PelJpegMarker::APP1 APP1} section, and so if the name of the JPEG
 * file is stored in $filename, then one would get hold of the EXIF
 * data by saying:
 *
 * <code>
 * $jpeg = new PelJpeg();
 * $jpeg->loadFile($filename);
 * $app1 = $jpeg->getSection(PelJpegMarker::APP1);
 * $tiff = $app1->getTiff();
 * $ifd0 = $tiff->getIfd();
 * $exif = $ifd0->getSubIfd(PelIfd::EXIF);
 * $ifd1 = $ifd0->getNextIfd();
 * </code>
 *
 * The $idf0 and $ifd1 variables will then be two {@link PelTiff TIFF}
 * {@link PelIfd Image File Directories}, in which the data is stored
 * under the keys found in {@link PelTag}.
 *
 * Should one have some image data (in the form of a {@link
 * PelDataWindow}) of an unknown type, then the {@link
 * PelJpeg::isValid()} function is handy: it will quickly test if the
 * data could be valid JPEG data.  The {@link PelTiff::isValid()}
 * function does the same for TIFF images.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelJpeg {

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
   * The new object will be empty, use the {@link load()} or {@link
   * loadFile()} methods to load JPEG data from a {@link
   * PelDataWindow} or a file, respectively.
   *
   * Individual sections of JPEG content can be added with the {@link
   * appendSection()} method --- use this method to add a {@link
   * PelExif} object as the {@link PelJpegMarker::APP1} section of an
   * existing file without EXIF information:
   *
   * <code>
   * $jpeg = new PelJpeg();
   * // Initialize $jpeg with some data:
   * $jpeg->load($data);
   * // Create container for the EXIF information:
   * $exif = new PelExif();
   * // Now Add a PelTiff object with a PelIfd object with one or more
   * // PelEntry objects to $exif.  Finally add $exif to $jpeg:
   * $jpeg->appendSection($exif, PelJpegMarker::APP1);
   * </code>
   */
  function __construct() {

  }

  /**
   * Load data into a JPEG object.
   *
   * The data supplied will be parsed and turned into an object
   * structure representing the image.  This structure can then be
   * manipulated and later turned back into an string of bytes.
   *
   * This methods can be called at any time after a JPEG object has
   * been constructed, also after the {@link appendSection()} has been
   * called to append custom sections.  Loading several JPEG images
   * into one object will accumulate the sections, but there will only
   * be one {@link PelJpegMarker::SOS} section at any given time.
   *
   * @param PelDataWindow the data that will be turned into JPEG
   * sections.
   */
  function load(PelDataWindow $d) {

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

      if (!PelJpegMarker::isValid($marker))
        throw new PelJpegInvalidMarkerException($marker, $i);

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
            $content = new PelExif();
            $content->load($d->getClone(0, $len));
          } catch (PelInvalidDataException $e) {
            /* We store the data as normal JPEG content if it could
             * not be parsed as EXIF data. */
            $content = new PelJpegContent($d->getClone(0, $len));
          }
          $this->appendSection($marker, $content);
          /* Skip past the data. */
          $d->setWindowStart($len);
        } else {
          $content = new PelJpegContent($d->getClone(0, $len));
          $this->appendSection($marker, $content);
          /* Skip past the data. */
          $d->setWindowStart($len);
          
          /* In case of SOS, image data will follow. */
          if ($marker == PelJpegMarker::SOS) {
            /* Some images have some trailing (garbage?) following the
             * EOI marker.  To handle this we seek backwards until we
             * find the EOI marker.  Any trailing content is stored as
             * a PelJpegContent object. */

            $length = $d->getSize();
            while ($d->getByte($length-2) != 0xFF ||
                   $d->getByte($length-1) != PelJpegMarker::EOI) {
              $length--;
            }

            $this->jpeg_data = $d->getClone(0, $length-2);
            Pel::debug('JPEG data: ' . $this->jpeg_data->__toString());

            /* Append the EOI. */
            $this->appendSection(PelJpegMarker::EOI,
                                 new PelJpegContent(new PelDataWindow()));

            /* Now check to see if there are any trailing data. */
            if ($length != $d->getSize()) {
              Pel::maybeThrow(new PelException('Found trailing content ' .
                                               'after EOI: %d bytes',
                                               $d->getSize() - $length));
              $content = new PelJpegContent($d->getClone($length));
              /* We don't have a proper JPEG marker for trailing
               * garbage, so we just use 0x00... */
              $this->appendSection(0x00, $content);
            }

            /* Done with the loop. */
            break;
          }
        }
      }
    } /* while ($d->getSize() > 0) */
  }


  /**
   * Load data from a file into a JPEG object.
   *
   * @param string the filename.  This must be a readable file.
   */
  function loadFile($filename) {
    $this->load(new PelDataWindow(file_get_contents($filename)));
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
   * Insert a new section.
   *
   * @param PelJpegMarker the marker for the new section.
   *
   * @param PelJpegContent the content of the new section.
   *
   * @param int the offset where the new section will be inserted ---
   * use 0 to insert it at the very beginning, use 1 to insert it
   * between sections 1 and 2, etc.
   */
  function insertSection($marker, PelJpegContent $content, $offset) {
    array_splice($this->sections, $offset, 0, array(array($marker, $content)));
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
   * PelJpegContent}) pairs.  Each pair is an array with the {@link
   * PelJpegMarker} as the first element and the {@link
   * PelJpegContent} as the second element, so the return type is an
   * array of arrays.
   *
   * So to loop through all the sections in a given JPEG image do
   * this:
   *
   * <code>
   * foreach ($jpeg->getSections() as $section) {
   *   $marker = $section[0];
   *   $content = $section[1];
   *   // Use $marker and $content here.
   * }
   * </code>
   *
   * instead of this:
   *
   * <code>
   * foreach ($jpeg->getSections() as $marker => $content) {
   *   // Does not work.
   * }
   * </code>
   *
   * The problem is that there could be several sections with the same
   * marker, and thsu a simple associative array does not suffice.
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

    foreach ($this->sections as $section) {
      $m = $section[0];
      $c = $section[1];

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
    for ($i = 0; $i < count($this->sections); $i++) {
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