<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.LESSER and COPYING files that are distributed with this source code.
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
use lsolesen\pel\PelTag;

/**
 * Exception indicating that an unexpected number of components was
 * found.
 *
 * Some tags have strict limits as to the allowed number of
 * components, and this exception is thrown if the data violates such
 * a constraint. The documentation for each tag in {@link PelTag}
 * explains the expected number of components.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelWrongComponentCountException extends \lsolesen\pel\PelEntryException
{

    /**
     * Construct a new exception indicating a wrong number of
     * components.
     *
     * @param int $type
     *            the type of IFD.
     *
     * @param PelTag $tag
     *            the tag for which the violation was found.
     *
     * @param int $found
     *            the number of components found.
     *
     * @param int $expected
     *            the expected number of components.
     */
    public function __construct($type, $tag, $found, $expected)
    {
        parent::__construct('Wrong number of components found for %s tag: %d. ' . 'Expected %d.', PelTag::getName($type, $tag), $found, $expected);
        $this->tag = $tag;
        $this->type = $type;
    }
}
