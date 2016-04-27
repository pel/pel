<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
namespace lsolesen\pel;

use \lsolesen\pel\PelDataWindow;

/**
 * Class representing content in a JPEG file.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * Class representing content in a JPEG file.
 *
 * A JPEG file consists of a sequence of each of which has an
 * associated {@link PelJpegMarker marker} and some content. This
 * class represents the content, and this basic type is just a simple
 * holder of such content, represented by a {@link PelDataWindow}
 * object. The {@link PelExif} class is an example of more
 * specialized JPEG content.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelJpegContent
{

    private $data = null;

    /**
     * Make a new piece of JPEG content.
     *
     * @param PelDataWindow $data
     *            the content.
     */
    public function __construct(PelDataWindow $data)
    {
        $this->data = $data;
    }

    /**
     * Return the bytes of the content.
     *
     * @return string bytes representing this JPEG content. These bytes
     *         will match the bytes given to {@link __construct the
     *         constructor}.
     */
    public function getBytes()
    {
        return $this->data->getBytes();
    }
}
