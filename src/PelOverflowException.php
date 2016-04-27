<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * Classes for dealing with Exif entries.
 *
 * This file defines two exception classes and the abstract class
 * {@link PelEntry} which provides the basic methods that all Exif
 * entries will have. All Exif entries will be represented by
 * descendants of the {@link PelEntry} class --- the class itself is
 * abstract and so it cannot be instantiated.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * Exception cast when numbers overflow.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelOverflowException extends PelException
{

    /**
     * Construct a new overflow exception.
     *
     * @param int $v
     *            the value that is out of range.
     *
     * @param int $min
     *            the minimum allowed value.
     *
     * @param int $max
     *            the maximum allowed value.
     */
    public function __construct($v, $min, $max)
    {
        parent::__construct('Value %.0f out of range [%.0f, %.0f]', $v, $min, $max);
    }
}
