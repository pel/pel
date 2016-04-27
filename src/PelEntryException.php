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
 * Exception indicating a problem with an entry.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelEntryException extends \lsolesen\pel\PelException
{

    /**
     * The IFD type (if known).
     *
     * @var int
     */
    protected $type;

    /**
     * The tag of the entry (if known).
     *
     * @var PelTag
     */
    protected $tag;

    /**
     * Get the IFD type associated with the exception.
     *
     * @return int one of {@link PelIfd::IFD0}, {@link PelIfd::IFD1},
     *         {@link PelIfd::EXIF}, {@link PelIfd::GPS}, or {@link
     *         PelIfd::INTEROPERABILITY}. If no type is set, null is returned.
     */
    public function getIfdType()
    {
        return $this->type;
    }

    /**
     * Get the tag associated with the exception.
     *
     * @return PelTag the tag. If no tag is set, null is returned.
     */
    public function getTag()
    {
        return $this->tag;
    }
}
