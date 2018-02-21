<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
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
 * Classes used to hold shorts, both signed and unsigned.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

/**
 * Class for holding signed shorts.
 *
 * This class can hold shorts, either just a single short or an array
 * of shorts. The class will be used to manipulate any of the Exif
 * tags which has format {@link PelFormat::SHORT} like in this
 * example:
 *
 * <code>
 * $w = $ifd->getEntry(PelTag::EXIF_IMAGE_WIDTH);
 * $w->setValue($w->getValue() / 2);
 * $h = $ifd->getEntry(PelTag::EXIF_IMAGE_HEIGHT);
 * $h->setValue($h->getValue() / 2);
 * </code>
 *
 * Here the width and height is updated to 50% of their original
 * values.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryShort extends PelEntryNumber
{

    /**
     * Make a new entry that can hold an unsigned short.
     *
     * The method accept several integer arguments. The {@link
     * getValue} method will always return an array except for when a
     * single integer argument is given here.
     *
     * This means that one can conveniently use objects like this:
     * <code>
     * $a = new PelEntryShort(PelTag::EXIF_IMAGE_HEIGHT, 42);
     * $b = $a->getValue() + 314;
     * </code>
     * where the call to {@link getValue} will return an integer
     * instead of an array with one integer element, which would then
     * have to be extracted.
     *
     * @param int $tag
     *            the tag which this entry represents. This should be
     *            one of the constants defined in {@link PelTag}, e.g., {@link
     *            PelTag::IMAGE_WIDTH}, {@link PelTag::ISO_SPEED_RATINGS},
     *            or any other tag with format {@link PelFormat::SHORT}.
     *
     * @param int $value...
     *            the short(s) that this entry will
     *            represent. The argument passed must obey the same rules as the
     *            argument to {@link setValue}, namely that it should be within
     *            range of an unsigned short, that is between 0 and 65535
     *            (inclusive). If not, then a {@link PelOverFlowException} will be
     *            thrown.
     */
    public function __construct($tag, $value = null)
    {
        $this->tag = $tag;
        $this->min = 0;
        $this->max = 65535;
        $this->format = PelFormat::SHORT;

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
     * @param boolean $order
     *            one of {@link PelConvert::LITTLE_ENDIAN} and
     *            {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
     *
     * @return string bytes representing the number given.
     */
    public function numberToBytes($number, $order)
    {
        return PelConvert::shortToBytes($number, $order);
    }

    /**
     * Decode text for a IFD0/YCbCrSubSampling tag.
     *
     * @param int $components
     *            the number of components of the TAG.
     * @param array $value
     *            the TAG value.
     * @param bool $brief
     *            indicates to use brief output.
     *
     * @return string
     *            the TAG text.
     */
    public static function decodeYCbCrSubSampling($components, $value, $brief)
    {
        if ($value[0] == 2 && $value[1] == 1) {
            return 'YCbCr4:2:2';
        }
        if ($value[0] == 2 && $value[1] == 2) {
            return 'YCbCr4:2:0';
        }
        return $value[0] . ', ' . $value[1];
    }

    /**
     * Decode text for an Exif/SubjectArea tag.
     *
     * @param int $components
     *            the number of components of the TAG.
     * @param array $value
     *            the TAG value.
     * @param bool $brief
     *            indicates to use brief output.
     *
     * @return string
     *            the TAG text.
     */
    public static function decodeSubjectArea($components, $value, $brief)
    {
        switch ($components) {
            case 2:
                return Pel::fmt('(x,y) = (%d,%d)', $value[0], $value[1]);
            case 3:
                return Pel::fmt('Within distance %d of (x,y) = (%d,%d)', $value[0], $value[1], $value[2]);
            case 4:
                return Pel::fmt('Within rectangle (width %d, height %d) around (x,y) = (%d,%d)', $value[0], $value[1], $value[2], $value[3]);
            default:
                return Pel::fmt('Unexpected number of components (%d, expected 2, 3, or 4).', $components);
        }
    }
}
