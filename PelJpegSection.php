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
 * Class representing a JPEG section.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelJpegContent.php');
require_once('PelJpegMarker.php');
/**#@-*/


/**
 * Class representing a JPEG section.
 *
 * Each section in a JPEG file has a {@link PelJpegMarker JPEG marker}
 * and some JPEG content.  The content can be either generic {@link
 * PelJpegContent JPEG content} or {@link PelExifData EXIF data}.
 * This class is simply a pair of a {@link PelJpegMarker} and a {@link
 * PelJpegContent}, where the latter could be an {@link PelExifData}
 * object instead.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelJpegSection {

  private $marker  = null;
  private $content = null;

  function __construct($m, PelJpegContent $c) {
    $this->marker = $m;
    $this->content = $c;
  }

  function getMarker() {
    return $this->marker;
  }

  function getContent() {
    return $this->content;
  }

}

?>