<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * Classes representing JPEG data.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

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
class PelJpegInvalidMarkerException extends \lsolesen\pel\PelException
{

    /**
     * Construct a new invalid marker exception.
     *
     * The exception will contain a message describing the error,
     * including the byte found and the offset of the offending byte.
     *
     * @param int $marker
     *            the byte found.
     *
     * @param int $offset
     *            the offset in the data.
     */
    public function __construct($marker, $offset)
    {
        parent::__construct('Invalid marker found at offset %d: 0x%2X', $offset, $marker);
    }
}
