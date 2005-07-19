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
 * Classes for dealing with EXIF data.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelJpegContent.php');
require_once('PelException.php');
require_once('PelFormat.php');
require_once('PelEntry.php');
require_once('PelTiff.php');
require_once('PelIfd.php');
require_once('PelTag.php');
require_once('Pel.php');
/**#@-*/


/**
 * Class representing EXIF data.
 *
 * EXIF data resides as {@link PelJpegContent data} and consists of a
 * header followed by a number of {@link PelJpegIfd IFDs}.
 *
 * The interesting method in this class is {@link getTiff()} which
 * will return the {@link PelTiff} object which really holds the data
 * which one normally think of when talking about EXIF data.  This is
 * because EXIF data is stored as an extension of the TIFF file
 * format.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelExif extends PelJpegContent {

  /**
   * EXIF header.
   *
   * The EXIF data must start with these six bytes to be considered
   * valid.
   */
  const EXIF_HEADER = "Exif\0\0";

  /**
   * The PelTiff object contained within.
   *
   * @var PelTiff
   */
  private $tiff = null;


  /**
   * Construct a new EXIF object.
   *
   * The new object will be empty --- use the {@link load()} method to
   * load EXIF data from a {@link PelDataWindow} object, or use the
   * {@link setTiff()} to change the {@link PelTiff} object, which is
   * the true holder of the EXIF {@link PelEntry entries}.
   */
  function __construct() {

  }


  /**
   * Load and parse EXIF data.
   *
   * This will populate the object with EXIF data, contained as a
   * {@link PelTiff} object.  This TIFF object can be accessed with
   * the {@link getTiff()} method.
   */
  function load(PelDataWindow $d) {
    Pel::debug('Parsing %d bytes of EXIF data...', $d->getSize());

    /* There must be at least 6 bytes for the EXIF header. */
    if ($d->getSize() < 6)
      throw new PelInvalidDataException('Expected at least 6 bytes of EXIF ' .
                                        'data, found just %d bytes.',
                                        $d->getSize());
    
    /* Verify the EXIF header */
    if ($d->strcmp(0, self::EXIF_HEADER)) {
      $d->setWindowStart(strlen(self::EXIF_HEADER));
    } else {
      throw new PelInvalidDataException('EXIF header not found.');
    }

    /* The rest of the data is TIFF data. */
    $this->tiff = new PelTiff();
    $this->tiff->load($d);
  }


  /**
   * Change the TIFF information.
   *
   * EXIF data is really stored as TIFF data, and this method can be
   * used to change this data from one {@link PelTiff} object to
   * another.
   *
   * @param PelTiff the new TIFF object.
   */
  function setTiff(PelTiff $tiff) {
    $this->tiff = $tiff;
  }


  /**
   * Get the underlying TIFF object.
   *
   * The actual EXIF data is stored in a {@link PelTiff} object, and
   * this method provides access to it.
   *
   * @return PelTiff the TIFF object with the EXIF data.
   */
  function getTiff() {
    return $this->tiff;
  }


  /**
   * Produce bytes for the EXIF data.
   *
   * @return string bytes representing this object.
   */
  function getBytes() {
    return self::EXIF_HEADER . $this->tiff->getBytes();
  }

  
  /**
   * Return a string representation of this object.
   *
   * @return string a string describing this object.  This is mostly
   * useful for debugging.
   */
  function __toString() {
    return Pel::tra("Dumping EXIF data...\n") .
      $this->tiff->__toString();
  }

}

?>