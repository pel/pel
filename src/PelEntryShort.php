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
namespace lsolesen\pel;

class PelEntryShort extends PelEntryNumber
{

    private const IFD_TYPE_TRANSLATIONS = [
        PelIfd::CANON_SHOT_INFO => [
            PelTag::CANON_SI_WHITE_BALANCE => [
                0 => 'Auto',
                1 => 'Daylight',
                2 => 'Cloudy',
                3 => 'Tungsten',
                4 => 'Fluorescent',
                5 => 'Flash',
                6 => 'Custom',
                7 => 'Black & White',
                8 => 'Shade',
                9 => 'Manual Temperature (Kelvin)',
                10 => 'PC Set1',
                11 => 'PC Set2',
                12 => 'PC Set3',
                14 => 'Daylight Fluorescent',
                15 => 'Custom 1',
                16 => 'Custom 2',
                17 => 'Underwater',
                18 => 'Custom 3',
                19 => 'Custom 4',
                20 => 'PC Set4',
                21 => 'PC Set5',
                23 => 'Auto (ambience priority)'
            ],
            PelTag::CANON_SI_SLOW_SHUTTER => [
                0 => 'Off',
                1 => 'Night Scene',
                2 => 'On',
                3 => 'None'
            ],
            PelTag::CANON_SI_AF_POINT_USED => [
                0x3000 => 'None (MF)',
                0x3001 => 'Right',
                0x3002 => 'Center',
                0x3003 => 'Center+Right',
                0x3004 => 'Left',
                0x3005 => 'Left+Right',
                0x3006 => 'Left+Center',
                0x3007 => 'All'
            ],
            PelTag::CANON_SI_AUTO_EXPOSURE_BRACKETING => [
                - 1 => 'On',
                0 => 'Off',
                1 => 'On (shot 1)',
                2 => 'On (shot 2)',
                3 => 'On (shot 3)'
            ],
            PelTag::CANON_SI_CAMERA_TYPE => [
                248 => 'EOS High-end',
                250 => 'Compact',
                252 => 'EOS Mid-range',
                255 => 'DV Camera'
            ],
            PelTag::CANON_SI_AUTO_ROTATE => [
                0 => 'None',
                1 => 'Rotate 90 CW',
                2 => 'Rotate 180',
                3 => 'Rotate 270 CW'
            ],
            PelTag::CANON_SI_ND_FILTER => [
                0 => 'Off',
                1 => 'On'
            ]
        ],
        PelIfd::CANON_PANORAMA => [
            PelTag::CANON_PA_PANORAMA_DIRECTION => [
                0 => 'Left to Right',
                1 => 'Right to Left',
                2 => 'Bottom to Top',
                3 => 'Top to Bottom',
                4 => '2x2 Matrix (Clockwise)'
            ]
        ]
    ];

    private const PEL_TAG_TRANSLATIONS = [
        PelTag::METERING_MODE => [
            0 => 'Unknown',
            1 => 'Average',
            2 => 'Center-Weighted Average',
            3 => 'Spot',
            4 => 'Multi Spot',
            5 => 'Pattern',
            6 => 'Partial',
            255 => 'Other'
        ],
        PelTag::COMPRESSION => [
            1 => 'Uncompressed',
            6 => 'JPEG compression'
        ],
        PelTag::PLANAR_CONFIGURATION => [
            1 => 'chunky format',
            2 => 'planar format'
        ],
        PelTag::SENSING_METHOD => [
            1 => 'Not defined',
            2 => 'One-chip color area sensor',
            3 => 'Two-chip color area sensor',
            4 => 'Three-chip color area sensor',
            5 => 'Color sequential area sensor',
            7 => 'Trilinear sensor',
            8 => 'Color sequential linear sensor'
        ],
        PelTag::LIGHT_SOURCE => [
            0 => 'Unknown',
            1 => 'Daylight',
            2 => 'Fluorescent',
            3 => 'Tungsten (incandescent light)',
            4 => 'Flash',
            9 => 'Fine weather',
            10 => 'Cloudy weather',
            11 => 'Shade',
            12 => 'Daylight fluorescent',
            13 => 'Day white fluorescent',
            14 => 'Cool white fluorescent',
            15 => 'White fluorescent',
            17 => 'Standard light A',
            18 => 'Standard light B',
            19 => 'Standard light C',
            20 => 'D55',
            21 => 'D65',
            22 => 'D75',
            24 => 'ISO studio tungsten',
            255 => 'Other'
        ],
        PelTag::FOCAL_PLANE_RESOLUTION_UNIT => [
            2 => 'Inch',
            3 => 'Centimeter'
        ],
        PelTag::RESOLUTION_UNIT => [
            2 => 'Inch',
            3 => 'Centimeter'
        ],
        PelTag::EXPOSURE_PROGRAM => [
            0 => 'Not defined',
            1 => 'Manual',
            2 => 'Normal program',
            3 => 'Aperture priority',
            4 => 'Shutter priority',
            5 => 'Creative program (biased toward depth of field)',
            6 => 'Action program (biased toward fast shutter speed)',
            7 => 'Portrait mode (for closeup photos with the background out of focus',
            8 => 'Landscape mode (for landscape photos with the background in focus'
        ],
        PelTag::ORIENTATION => [
            1 => 'top - left',
            2 => 'top - right',
            3 => 'bottom - right',
            4 => 'bottom - left',
            5 => 'left - top',
            6 => 'right - top',
            7 => 'right - bottom',
            8 => 'left - bottom'
        ],
        PelTag::YCBCR_POSITIONING => [
            1 => 'centered',
            2 => 'co-sited'
        ],
        PelTag::PHOTOMETRIC_INTERPRETATION => [
            2 => 'RGB',
            6 => 'YCbCr'
        ],
        PelTag::COLOR_SPACE => [
            1 => 'sRGB',
            2 => 'Adobe RGB',
            0xffff => 'Uncalibrated'
        ],
        PelTag::FLASH => [
            0x0000 => 'Flash did not fire.',
            0x0001 => 'Flash fired.',
            0x0005 => 'Strobe return light not detected.',
            0x0007 => 'Strobe return light detected.',
            0x0009 => 'Flash fired, compulsory flash mode.',
            0x000d => 'Flash fired, compulsory flash mode, return light not detected.',
            0x000f => 'Flash fired, compulsory flash mode, return light detected.',
            0x0010 => 'Flash did not fire, compulsory flash mode.',
            0x0018 => 'Flash did not fire, auto mode.',
            0x0019 => 'Flash fired, auto mode.',
            0x001d => 'Flash fired, auto mode, return light not detected.',
            0x001f => 'Flash fired, auto mode, return light detected.',
            0x0020 => 'No flash function.',
            0x0041 => 'Flash fired, red-eye reduction mode.',
            0x0045 => 'Flash fired, red-eye reduction mode, return light not detected.',
            0x0047 => 'Flash fired, red-eye reduction mode, return light detected.',
            0x0049 => 'Flash fired, compulsory flash mode, red-eye reduction mode.',
            0x004d => 'Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected.',
            0x004f => 'Flash fired, compulsory flash mode, red-eye reduction mode, return light detected.',
            0x0058 => 'Flash did not fire, auto mode, red-eye reduction mode.',
            0x0059 => 'Flash fired, auto mode, red-eye reduction mode.',
            0x005d => 'Flash fired, auto mode, return light not detected, red-eye reduction mode.',
            0x005f => 'Flash fired, auto mode, return light detected, red-eye reduction mode.'
        ],
        PelTag::CUSTOM_RENDERED => [
            0 => 'Normal process',
            1 => 'Custom process'
        ],
        PelTag::EXPOSURE_MODE => [
            0 => 'Auto exposure',
            1 => 'Manual exposure',
            2 => 'Auto bracket'
        ],
        PelTag::WHITE_BALANCE => [
            0 => 'Auto white balance',
            1 => 'Manual white balance'
        ],
        PelTag::SCENE_CAPTURE_TYPE => [
            0 => 'Standard',
            1 => 'Landscape',
            2 => 'Portrait',
            3 => 'Night scene'
        ],
        PelTag::GAIN_CONTROL => [
            0 => 'Normal',
            1 => 'Low gain up',
            2 => 'High gain up',
            3 => 'Low gain down',
            4 => 'High gain down'
        ],
        PelTag::SATURATION => [
            0 => 'Normal',
            1 => 'Low saturation',
            2 => 'High saturation'
        ],
        PelTag::CONTRAST => [
            0 => 'Normal',
            1 => 'Soft',
            2 => 'Hard'
        ],
        PelTag::SHARPNESS => [
            0 => 'Normal',
            1 => 'Soft',
            2 => 'Hard'
        ],
        PelTag::SUBJECT_DISTANCE_RANGE => [
            0 => 'Unknown',
            1 => 'Macro',
            2 => 'Close view',
            3 => 'Distant view'
        ]
    ];

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
     * @param integer $tag
     *            the tag which this entry represents. This should be
     *            one of the constants defined in {@link PelTag}, e.g., {@link
     *            PelTag::IMAGE_WIDTH}, {@link PelTag::ISO_SPEED_RATINGS},
     *            or any other tag with format {@link PelFormat::SHORT}.
     * @param integer $value...
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
     * @param integer $number
     *            the number that should be converted.
     * @param boolean $order
     *            one of {@link PelConvert::LITTLE_ENDIAN} and
     *            {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
     * @return string bytes representing the number given.
     */
    public function numberToBytes($number, $order)
    {
        return PelConvert::shortToBytes($number, $order);
    }

    /**
     * Get the value of an entry as text.
     *
     * The value will be returned in a format suitable for presentation,
     * e.g., instead of returning '2' for a {@link
     * PelTag::METERING_MODE} tag, 'Center-Weighted Average' is
     * returned.
     *
     * @param boolean $brief
     *            some values can be returned in a long or more
     *            brief form, and this parameter controls that.
     * @return string the value as text.
     */
    public function getText($brief = false)
    {
        if (array_key_exists($this->ifd_type, self::IFD_TYPE_TRANSLATIONS)) {
            if (array_key_exists($this->value[0], self::IFD_TYPE_TRANSLATIONS[$this->ifd_type])) {
                return Pel::tra(self::IFD_TYPE_TRANSLATIONS[$this->ifd_type][$this->value[0]]);
            } else {
                return $this->value[0];
            }
        } elseif ($this->tag === PelTag::YCBCR_SUB_SAMPLING) {
            if ($this->value[0] == 2 && $this->value[1] == 1) {
                return 'YCbCr4:2:2';
            }
            if ($this->value[0] == 2 && $this->value[1] == 2) {
                return 'YCbCr4:2:0';
            }
            return $this->value[0] . ', ' . $this->value[1];
        } elseif ($this->tag === PelTag::SUBJECT_AREA) {
            switch ($this->components) {
                case 2:
                    return Pel::fmt('(x,y) = (%d,%d)', $this->value[0], $this->value[1]);
                case 3:
                    return Pel::fmt('Within distance %d of (x,y) = (%d,%d)', $this->value[0], $this->value[1], $this->value[2]);
                case 4:
                    return Pel::fmt('Within rectangle (width %d, height %d) around (x,y) = (%d,%d)', $this->value[0], $this->value[1], $this->value[2], $this->value[3]);
                default:
                    return Pel::fmt('Unexpected number of components (%d, expected 2, 3, or 4).', $this->components);
            }
        } elseif (array_key_exists($this->tag, self::PEL_TAG_TRANSLATIONS)) {
            if (array_key_exists($this->value[0], self::PEL_TAG_TRANSLATIONS[$this->tag])) {
                return Pel::tra(self::PEL_TAG_TRANSLATIONS[$this->tag][$this->value[0]]);
            } else {
                return $this->value[0];
            }
        }
        return parent::getText($brief);
    }
}
