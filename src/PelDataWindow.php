<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the file COPYING; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA 02110-1301 USA
 */
namespace lsolesen\pel;

/**
 * The window.
 *
 * @package PEL
 */
class PelDataWindow
{

    /**
     * The data held by this window.
     *
     * The string can contain any kind of data, including binary data.
     *
     * @var string
     */
    private $data = '';

    /**
     * The byte order currently in use.
     *
     * This will be the byte order used when data is read using the for
     * example the {@link getShort} function. It must be one of {@link
     * PelConvert::LITTLE_ENDIAN} and {@link PelConvert::BIG_ENDIAN}.
     *
     * @var PelByteOrder
     * @see setByteOrder, getByteOrder
     */
    private $order;

    /**
     * The start of the current window.
     *
     * All offsets used for access into the data will count from this
     * offset, effectively limiting access to a window starting at this
     * byte.
     *
     * @var int
     * @see setWindowStart
     */
    private $start = 0;

    /**
     * The size of the current window.
     *
     * All offsets used for access into the data will be limited by this
     * variable. A valid offset must be strictly less than this
     * variable.
     *
     * @var int
     * @see setWindowSize
     */
    private $size = 0;

    /**
     * Construct a new data window with the data supplied.
     *
     * @param
     *            mixed the data that this window will contain. This can
     *            either be given as a string (interpreted litteraly as a sequence
     *            of bytes) or a PHP image resource handle. The data will be copied
     *            into the new data window.
     *
     * @param
     *            boolean the initial byte order of the window. This must
     *            be either {@link PelConvert::LITTLE_ENDIAN} or {@link
     *            PelConvert::BIG_ENDIAN}. This will be used when integers are
     *            read from the data, and it can be changed later with {@link
     *            setByteOrder()}.
     */
    public function __construct($data = '', $endianess = PelConvert::LITTLE_ENDIAN)
    {
        if (is_string($data)) {
            $this->data = $data;
        } elseif (is_resource($data) && get_resource_type($data) == 'gd') {
            /*
             * The ImageJpeg() function insists on printing the bytes
             * instead of returning them in a more civil way as a string, so
             * we have to buffer the output...
             */
            ob_start();
            ImageJpeg($data, null, Pel::getJPEGQuality());
            $this->data = ob_get_clean();
        } else {
            throw new PelInvalidArgumentException('Bad type for $data: %s', gettype($data));
        }

        $this->order = $endianess;
        $this->size = strlen($this->data);
    }

    /**
     * Get the size of the data window.
     *
     * @return int the number of bytes covered by the window. The
     *         allowed offsets go from 0 up to this number minus one.
     *
     * @see getBytes()
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Change the byte order of the data.
     *
     * @param
     *            PelByteOrder the new byte order. This must be either
     *            {@link PelConvert::LITTLE_ENDIAN} or {@link
     *            PelConvert::BIG_ENDIAN}.
     */
    public function setByteOrder($o)
    {
        $this->order = $o;
    }

    /**
     * Get the currently used byte order.
     *
     * @return PelByteOrder this will be either {@link
     *         PelConvert::LITTLE_ENDIAN} or {@link PelConvert::BIG_ENDIAN}.
     */
    public function getByteOrder()
    {
        return $this->order;
    }

    /*
     * Move the start of the window forward.
     * @param int the new start of the window. All new offsets will be
     * calculated from this new start offset, and the size of the window
     * will shrink to keep the end of the window in place.
     */
    public function setWindowStart($start)
    {
        if ($start < 0 || $start > $this->size) {
            throw new PelDataWindowWindowException('Window [%d, %d] does ' . 'not fit in window [0, %d]', $start, $this->size, $this->size);
        }
        $this->start += $start;
        $this->size -= $start;
    }

    /**
     * Adjust the size of the window.
     *
     * The size can only be made smaller.
     *
     * @param
     *            int the desired size of the window. If the argument is
     *            negative, the window will be shrunk by the argument.
     */
    public function setWindowSize($size)
    {
        if ($size < 0) {
            $size += $this->size;
        }
        if ($size < 0 || $size > $this->size) {
            throw new PelDataWindowWindowException('Window [0, %d] ' . 'does not fit in window [0, %d]', $size, $this->size);
        }
        $this->size = $size;
    }

    /**
     * Make a new data window with the same data as the this window.
     *
     * @param
     *            mixed if an integer is supplied, then it will be the start
     *            of the window in the clone. If left unspecified, then the clone
     *            will inherit the start from this object.
     *
     * @param
     *            mixed if an integer is supplied, then it will be the size
     *            of the window in the clone. If left unspecified, then the clone
     *            will inherit the size from this object.
     *
     * @return PelDataWindow a new window that operates on the same data
     *         as this window, but (optionally) with a smaller window size.
     */
    public function getClone($start = false, $size = false)
    {
        $c = clone $this;

        if (is_int($start)) {
            $c->setWindowStart($start);
        }
        if (is_int($size)) {
            $c->setWindowSize($size);
        }
        return $c;
    }

    /**
     * Validate an offset against the current window.
     *
     * @param
     *            int the offset to be validated. If the offset is negative
     *            or if it is greater than or equal to the current window size,
     *            then a {@link PelDataWindowOffsetException} is thrown.
     *
     * @return void if the offset is valid nothing is returned, if it is
     *         invalid a new {@link PelDataWindowOffsetException} is thrown.
     */
    private function validateOffset($o)
    {
        if ($o < 0 || $o >= $this->size) {
            throw new PelDataWindowOffsetException('Offset %d not within [%d, %d]', $o, 0, $this->size - 1);
        }
    }

    /**
     * Return some or all bytes visible in the window.
     *
     * This method works just like the standard {@link substr()}
     * function in PHP with the exception that it works within the
     * window of accessible bytes and does strict range checking.
     *
     * @param
     *            int the offset to the first byte returned. If a negative
     *            number is given, then the counting will be from the end of the
     *            window. Invalid offsets will result in a {@link
     *            PelDataWindowOffsetException} being thrown.
     *
     * @param
     *            int the size of the sub-window. If a negative number is
     *            given, then that many bytes will be omitted from the result.
     *
     * @return string a subset of the bytes in the window. This will
     *         always return no more than {@link getSize()} bytes.
     */
    public function getBytes($start = false, $size = false)
    {
        if (is_int($start)) {
            if ($start < 0) {
                $start += $this->size;
            }

            $this->validateOffset($start);
        } else {
            $start = 0;
        }

        if (is_int($size)) {
            if ($size <= 0) {
                $size += $this->size - $start;
            }

            $this->validateOffset($start + $size);
        } else {
            $size = $this->size - $start;
        }

        return substr($this->data, $this->start + $start, $size);
    }

    /**
     * Return an unsigned byte from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first byte in the current allowed window. The last
     *            valid offset is equal to {@link getSize()}-1. Invalid offsets
     *            will result in a {@link PelDataWindowOffsetException} being
     *            thrown.
     *
     * @return int the unsigned byte found at offset.
     */
    public function getByte($o = 0)
    {
        /*
         * Validate the offset --- this throws an exception if offset is
         * out of range.
         */
        $this->validateOffset($o);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return an unsigned byte. */
        return PelConvert::bytesToByte($this->data, $o);
    }

    /**
     * Return a signed byte from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first byte in the current allowed window. The last
     *            valid offset is equal to {@link getSize()}-1. Invalid offsets
     *            will result in a {@link PelDataWindowOffsetException} being
     *            thrown.
     *
     * @return int the signed byte found at offset.
     */
    public function getSByte($o = 0)
    {
        /*
         * Validate the offset --- this throws an exception if offset is
         * out of range.
         */
        $this->validateOffset($o);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return a signed byte. */
        return PelConvert::bytesToSByte($this->data, $o);
    }

    /**
     * Return an unsigned short read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first short available in the current allowed window.
     *            The last valid offset is equal to {@link getSize()}-2. Invalid
     *            offsets will result in a {@link PelDataWindowOffsetException}
     *            being thrown.
     *
     * @return int the unsigned short found at offset.
     */
    public function getShort($o = 0)
    {
        /*
         * Validate the offset+1 to see if we can safely get two bytes ---
         * this throws an exception if offset is out of range.
         */
        $this->validateOffset($o);
        $this->validateOffset($o + 1);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return an unsigned short. */
        return PelConvert::bytesToShort($this->data, $o, $this->order);
    }

    /**
     * Return a signed short read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first short available in the current allowed window.
     *            The last valid offset is equal to {@link getSize()}-2. Invalid
     *            offsets will result in a {@link PelDataWindowOffsetException}
     *            being thrown.
     *
     * @return int the signed short found at offset.
     */
    public function getSShort($o = 0)
    {
        /*
         * Validate the offset+1 to see if we can safely get two bytes ---
         * this throws an exception if offset is out of range.
         */
        $this->validateOffset($o);
        $this->validateOffset($o + 1);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return a signed short. */
        return PelConvert::bytesToSShort($this->data, $o, $this->order);
    }

    /**
     * Return an unsigned long read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first long available in the current allowed window.
     *            The last valid offset is equal to {@link getSize()}-4. Invalid
     *            offsets will result in a {@link PelDataWindowOffsetException}
     *            being thrown.
     *
     * @return int the unsigned long found at offset.
     */
    public function getLong($o = 0)
    {
        /*
         * Validate the offset+3 to see if we can safely get four bytes
         * --- this throws an exception if offset is out of range.
         */
        $this->validateOffset($o);
        $this->validateOffset($o + 3);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return an unsigned long. */
        return PelConvert::bytesToLong($this->data, $o, $this->order);
    }

    /**
     * Return a signed long read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first long available in the current allowed window.
     *            The last valid offset is equal to {@link getSize()}-4. Invalid
     *            offsets will result in a {@link PelDataWindowOffsetException}
     *            being thrown.
     *
     * @return int the signed long found at offset.
     */
    public function getSLong($o = 0)
    {
        /*
         * Validate the offset+3 to see if we can safely get four bytes
         * --- this throws an exception if offset is out of range.
         */
        $this->validateOffset($o);
        $this->validateOffset($o + 3);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Return a signed long. */
        return PelConvert::bytesToSLong($this->data, $o, $this->order);
    }

    /**
     * Return an unsigned rational read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first rational available in the current allowed
     *            window. The last valid offset is equal to {@link getSize()}-8.
     *            Invalid offsets will result in a {@link
     *            PelDataWindowOffsetException} being thrown.
     *
     * @return array the unsigned rational found at offset. A rational
     *         number is represented as an array of two numbers: the enumerator
     *         and denominator. Both of these numbers will be unsigned longs.
     */
    public function getRational($o = 0)
    {
        return array(
            $this->getLong($o),
            $this->getLong($o + 4)
        );
    }

    /**
     * Return a signed rational read from the data.
     *
     * @param
     *            int the offset into the data. An offset of zero will
     *            return the first rational available in the current allowed
     *            window. The last valid offset is equal to {@link getSize()}-8.
     *            Invalid offsets will result in a {@link
     *            PelDataWindowOffsetException} being thrown.
     *
     * @return array the signed rational found at offset. A rational
     *         number is represented as an array of two numbers: the enumerator
     *         and denominator. Both of these numbers will be signed longs.
     */
    public function getSRational($o = 0)
    {
        return array(
            $this->getSLong($o),
            $this->getSLong($o + 4)
        );
    }

    /**
     * String comparison on substrings.
     *
     * @param
     *            int the offset into the data. An offset of zero will make
     *            the comparison start with the very first byte available in the
     *            window. The last valid offset is equal to {@link getSize()}
     *            minus the length of the string. If the string is too long, then
     *            a {@link PelDataWindowOffsetException} will be thrown.
     *
     * @param
     *            string the string to compare with.
     *
     * @return boolean true if the string given matches the data in the
     *         window, at the specified offset, false otherwise. The comparison
     *         will stop as soon as a mismatch if found.
     */
    public function strcmp($o, $str)
    {
        /*
         * Validate the offset of the final character we might have to
         * check.
         */
        $s = strlen($str);
        $this->validateOffset($o);
        $this->validateOffset($o + $s - 1);

        /* Translate the offset into an offset into the data. */
        $o += $this->start;

        /* Check each character, return as soon as the answer is known. */
        for ($i = 0; $i < $s; $i ++) {
            if ($this->data{$o + $i} != $str{$i}) {
                return false;
            }
        }

        /* All characters matches each other, return true. */
        return true;
    }

    /**
     * Return a string representation of the data window.
     *
     * @return string a description of the window with information about
     *         the number of bytes accessible, the total number of bytes, and
     *         the window start and stop.
     */
    public function __toString()
    {
        return Pel::fmt('DataWindow: %d bytes in [%d, %d] of %d bytes', $this->size, $this->start, $this->start + $this->size, strlen($this->data));
    }
}
