<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.LESSER and COPYING files that are distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * Standard PEL exception.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * A printf() capable exception.
 *
 * This class is a simple extension of the standard Exception class in
 * PHP, and all the methods defined there retain their original
 * meaning.
 *
 * @package PEL
 * @subpackage Exception
 */
class PelException extends \Exception
{

    /**
     * Construct a new PEL exception.
     *
     * @param string $fmt
     *            an optional format string can be given. It
     *            will be used as a format string for vprintf(). The remaining
     *            arguments will be available for the format string as usual with
     *            vprintf().
     *
     * @param mixed $args,...
     *            any number of arguments to be used with
     *            the format string.
     */
    public function __construct()
    {
        $args = func_get_args();
        $fmt = array_shift($args);
        parent::__construct(vsprintf($fmt, $args));
    }
}
