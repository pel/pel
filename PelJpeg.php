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
 * The {@link PelJpeg} class defined here provides an abstraction
 * for dealing with a JPEG file.  The file will be contain a number of
 * sections indicated by markers, which is modeled with the {@link
 * PelJpegSection} and {@link PelJpegMarker} classes.
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
require_once('PelJpegSection.php');
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
  private $sections = array();

  /* Just JPEG image data */
  private $jpeg_data = null;


  /**
   * @todo Make the constructor take a plain string with bytes instead
   * of requiring the {@link PelDataWindow} object?
   */
  function __construct(PelDataWindow $d) {

    Pel::debug('Parsing %d bytes...', $d->getSize());

    /* JPEG data is stored in little-endian format. */
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
        $section = new PelJpegSection($marker, $content);
        $this->appendSection($section);
      } else {
        /* Read the length of the section.  The length includes the
         * two bytes used to store the length. */
        $len = $d->getShort(0) - 2;
        
        Pel::debug('Found %s section of length %d',
                   PelJpegMarker::getName($marker), $len);

        /* Skip past the length. */
        $d->setWindowStart(2);

        if ($marker == PelJpegMarker::APP1) {
          $content = new PelExif($d->getClone(0, $len));
          $section = new PelJpegSection($marker, $content);
          $this->appendSection($section);
        } else {
          $content = new PelJpegContent($d->getClone(0, $len));
          $section = new PelJpegSection($marker, $content);
          $this->appendSection($section);
          
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
  

  function appendSection(PelJpegSection $s) {
    $this->sections[] = $s;
    $this->count++;
  }


  function getSection($i) {
    return $this->sections[$i];
  }


  function getSections() {
    return $this->sections;
  }

  function getBytes() {
    $bytes = '';

    for ($i = 0; $i < $this->count; $i++) {
      $s = $this->sections[$i];
      $m = $s->getMarker();
      //printf ("Writing marker 0x%X...\n", $m);

      /* Write the marker */
      $bytes .= "\xFF" . PelJpegMarker::getBytes($m);
      if ($m == PelJpegMarker::SOI ||
          $m == PelJpegMarker::EOI)
        continue;

      $data = $s->getContent()->getBytes();
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


  function __toString() {
    $str = Pel::tra("Dumping JPEG data...\n");
    for ($i = 0; $i < $this->count; $i++) {
      $m = $this->sections[$i]->getMarker();
      $c = $this->sections[$i]->getContent();
      $str .= Pel::fmt("Section %d (marker 0x%02X - %s):\n",
                       $i, $m, PelJpegMarker::getName($m));
      $str .= Pel::fmt("  Description: %s\n",
                       PelJpegMarker::getDescription($m));
      
      if ($m == PelJpegMarker::SOI ||
          $m == PelJpegMarker::EOI)
        continue;
      
      if ($m == PelJpegMarker::APP1) {
        $str .= $c->__toString() . "\n";
      } else {
        $str .= Pel::fmt("  Size: %d bytes\n", $c->getSize()); 
        $str .= Pel::tra("  Unknown content\n");
      }
    }

    return $str;
  }


  function isValid(PelDataWindow $d) {
    /* JPEG data is stored in little-endian format. */
    $d->setByteOrder(PelConvert::BIG_ENDIAN);
    
    for ($i = 0; $i < 7; $i++)
      if ($d->getByte($i) != 0xFF)
        break;
    
    return $d->getByte($i) == PelJpegMarker::SOI;
  }

}

?>