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
 * Class representing content in a JPEG file.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 * @subpackage JPEG
 */

/** Class definition of {@link PelDataWindow}. */
include_once('PelDataWindow.php');

/**
 * Class representing content in a JPEG file.
 *
 * A JPEG file consists of a sequence of {@link PelJpegSection
 * sections} each of which has an associated {@link PelJpegMarker}
 * marker} and some content.  This class represents the content, and
 * this basic type is just a simple holder of such content,
 * represented by a {@link PelDataWindow} object.  The {@link
 * PelExifData} class is an example of more specialized JPEG content.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 * @subpackage JPEG
 */
class PelJpegContent {
  private $data = null;

  function __construct(PelDataWindow $data) {
    $this->data = $data;
  }

  function getBytes() {
    return $this->data->getBytes();
  }
  
  function getSize() {
    return $this->data->getSize();
  }
}

?>