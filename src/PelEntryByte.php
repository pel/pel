<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * Classes used to hold bytes, both signed and unsigned.
 * The {@link
 * PelEntryWindowsString} class is used to manipulate strings in the
 * format Windows XP needs.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * Class for holding unsigned bytes.
 *
 * This class can hold bytes, either just a single byte or an array of
 * bytes. The class will be used to manipulate any of the Exif tags
 * which has format {@link PelFormat::BYTE}.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryByte extends PelEntryNumber
{

    /**
     * Make a new entry that can hold an unsigned byte.
     *
     * The method accept several integer arguments. The {@link
     * getValue} method will always return an array except for when a
     * single integer argument is given here.
     *
     * @param PelTag $tag
     *            the tag which this entry represents. This
     *            should be one of the constants defined in {@link PelTag}
     *            which has format {@link PelFormat::BYTE}.
     *
     * @param int $value...
     *            the byte(s) that this entry will represent.
     *            The argument passed must obey the same rules as the argument to
     *            {@link setValue}, namely that it should be within range of an
     *            unsigned byte, that is between 0 and 255 (inclusive). If not,
     *            then a {@link PelOverflowException} will be thrown.
     */
    public function __construct($tag, $value = null)
    {
        $this->tag = $tag;
        $this->min = 0;
        $this->max = 255;
        $this->format = PelFormat::BYTE;

        $value = func_get_args();
        array_shift($value);
        $this->setValueArray($value);
    }

    /**
     * Convert a number into bytes.
     *
     * @param int $number
     *            the number that should be converted.
     *
     * @param PelByteOrder $order
     *            one of {@link PelConvert::LITTLE_ENDIAN} and
     *            {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
     *
     * @return string bytes representing the number given.
     */
    public function numberToBytes($number, $order)
    {
        return chr($number);
    }
}
