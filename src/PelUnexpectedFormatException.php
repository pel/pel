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
 * Exception indicating that an unexpected format was found.
 *
 * The documentation for each tag in {@link PelTag} will detail any
 * constrains.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelUnexpectedFormatException extends \lsolesen\pel\PelEntryException
{

    /**
     * Construct a new exception indicating an invalid format.
     *
     * @param int $type
     *            the type of IFD.
     *
     * @param PelTag $tag
     *            the tag for which the violation was found.
     *
     * @param PelFormat $found
     *            the format found.
     *
     * @param PelFormat $expected
     *            the expected format.
     */
    public function __construct($type, $tag, $found, $expected)
    {
        parent::__construct('Unexpected format found for %s tag: PelFormat::%s. ' . 'Expected PelFormat::%s instead.', PelTag::getName($type, $tag), strtoupper(PelFormat::getName($found)), strtoupper(PelFormat::getName($expected)));
        $this->tag = $tag;
        $this->type = $type;
    }
}
