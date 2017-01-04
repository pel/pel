<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2005, 2007 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * Class for dealing with JPEG comments.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * Class representing JPEG comments.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelJpegComment extends PelJpegContent
{

    /**
     * The comment.
     *
     * @var string
     */
    private $comment = '';

    /**
     * Construct a new JPEG comment.
     *
     * The new comment will contain the string given.
     *
     * @param string $comment
     */
    public function __construct($comment = '')
    {
        $this->comment = $comment;
    }

    /**
     * Load and parse data.
     *
     * This will load the comment from the data window passed.
     *
     * @param PelDataWindow $d
     */
    public function load(PelDataWindow $d)
    {
        $this->comment = $d->getBytes();
    }

    /**
     * Update the value with a new comment.
     *
     * Any old comment will be overwritten.
     *
     * @param string $comment
     *            the new comment.
     */
    public function setValue($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the comment.
     *
     * @return string the comment.
     */
    public function getValue()
    {
        return $this->comment;
    }

    /**
     * Turn this comment into bytes.
     *
     * @return string bytes representing this comment.
     */
    public function getBytes()
    {
        return $this->comment;
    }

    /**
     * Return a string representation of this object.
     *
     * @return string the same as {@link getValue()}.
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
