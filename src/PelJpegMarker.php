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

use \lsolesen\pel\Pel;

/**
 * Classes for dealing with JPEG markers.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

/**
 * Class with static methods for JPEG markers.
 *
 * This class defines the constants to be used whenever one refers to
 * a JPEG marker. All the methods defined are static, and they all
 * operate on one argument which should be one of the class constants.
 * They will all be denoted by PelJpegMarker in the documentation.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelJpegMarker
{

    /**
     * Encoding (baseline)
     */
    const SOF0 = 0xC0;

    /**
     * Encoding (extended sequential)
     */
    const SOF1 = 0xC1;

    /**
     * Encoding (progressive)
     */
    const SOF2 = 0xC2;

    /**
     * Encoding (lossless)
     */
    const SOF3 = 0xC3;

    /**
     * Define Huffman table
     */
    const DHT = 0xC4;

    /**
     * Encoding (differential sequential)
     */
    const SOF5 = 0xC5;

    /**
     * Encoding (differential progressive)
     */
    const SOF6 = 0xC6;

    /**
     * Encoding (differential lossless)
     */
    const SOF7 = 0xC7;

    /**
     * Extension
     */
    const JPG = 0xC8;

    /**
     * Encoding (extended sequential, arithmetic)
     */
    const SOF9 = 0xC9;

    /**
     * Encoding (progressive, arithmetic)
     */
    const SOF10 = 0xCA;

    /**
     * Encoding (lossless, arithmetic)
     */
    const SOF11 = 0xCB;

    /**
     * Define arithmetic coding conditioning
     */
    const DAC = 0xCC;

    /**
     * Encoding (differential sequential, arithmetic)
     */
    const SOF13 = 0xCD;

    /**
     * Encoding (differential progressive, arithmetic)
     */
    const SOF14 = 0xCE;

    /**
     * Encoding (differential lossless, arithmetic)
     */
    const SOF15 = 0xCF;

    /**
     * Restart 0
     */
    const RST0 = 0xD0;

    /**
     * Restart 1
     */
    const RST1 = 0xD1;

    /**
     * Restart 2
     */
    const RST2 = 0xD2;

    /**
     * Restart 3
     */
    const RST3 = 0xD3;

    /**
     * Restart 4
     */
    const RST4 = 0xD4;

    /**
     * Restart 5
     */
    const RST5 = 0xD5;

    /**
     * Restart 6
     */
    const RST6 = 0xD6;

    /**
     * Restart 7
     */
    const RST7 = 0xD7;

    /**
     * Start of image
     */
    const SOI = 0xD8;

    /**
     * End of image
     */
    const EOI = 0xD9;

    /**
     * Start of scan
     */
    const SOS = 0xDA;

    /**
     * Define quantization table
     */
    const DQT = 0xDB;

    /**
     * Define number of lines
     */
    const DNL = 0xDC;

    /**
     * Define restart interval
     */
    const DRI = 0xDD;

    /**
     * Define hierarchical progression
     */
    const DHP = 0xDE;

    /**
     * Expand reference component
     */
    const EXP = 0xDF;

    /**
     * Application segment 0
     */
    const APP0 = 0xE0;

    /**
     * Application segment 1
     *
     * When a JPEG image contains Exif data, the data will normally be
     * stored in this section and a call to {@link PelJpeg::getExif()}
     * will return a {@link PelExif} object representing it.
     */
    const APP1 = 0xE1;

    /**
     * Application segment 2
     */
    const APP2 = 0xE2;

    /**
     * Application segment 3
     */
    const APP3 = 0xE3;

    /**
     * Application segment 4
     */
    const APP4 = 0xE4;

    /**
     * Application segment 5
     */
    const APP5 = 0xE5;

    /**
     * Application segment 6
     */
    const APP6 = 0xE6;

    /**
     * Application segment 7
     */
    const APP7 = 0xE7;

    /**
     * Application segment 8
     */
    const APP8 = 0xE8;

    /**
     * Application segment 9
     */
    const APP9 = 0xE9;

    /**
     * Application segment 10
     */
    const APP10 = 0xEA;

    /**
     * Application segment 11
     */
    const APP11 = 0xEB;

    /**
     * Application segment 12
     */
    const APP12 = 0xEC;

    /**
     * Application segment 13
     */
    const APP13 = 0xED;

    /**
     * Application segment 14
     */
    const APP14 = 0xEE;

    /**
     * Application segment 15
     */
    const APP15 = 0xEF;

    /**
     * Extension 0
     */
    const JPG0 = 0xF0;

    /**
     * Extension 1
     */
    const JPG1 = 0xF1;

    /**
     * Extension 2
     */
    const JPG2 = 0xF2;

    /**
     * Extension 3
     */
    const JPG3 = 0xF3;

    /**
     * Extension 4
     */
    const JPG4 = 0xF4;

    /**
     * Extension 5
     */
    const JPG5 = 0xF5;

    /**
     * Extension 6
     */
    const JPG6 = 0xF6;

    /**
     * Extension 7
     */
    const JPG7 = 0xF7;

    /**
     * Extension 8
     */
    const JPG8 = 0xF8;

    /**
     * Extension 9
     */
    const JPG9 = 0xF9;

    /**
     * Extension 10
     */
    const JPG10 = 0xFA;

    /**
     * Extension 11
     */
    const JPG11 = 0xFB;

    /**
     * Extension 12
     */
    const JPG12 = 0xFC;

    /**
     * Extension 13
     */
    const JPG13 = 0xFD;

    /**
     * Comment
     */
    const COM = 0xFE;

    /**
     * Check if a byte is a valid JPEG marker.
     *
     * @param
     *            PelJpegMarker the byte that will be checked.
     *
     * @return boolean if the byte is recognized true is returned,
     *         otherwise false will be returned.
     */
    public static function isValid($m)
    {
        return ($m >= self::SOF0 && $m <= self::COM);
    }

    /**
     * Turn a JPEG marker into bytes.
     *
     * @param PelJpegMarker $m
     *            the marker.
     *
     * @return string the marker as a string. This will be a string
     *         with just a single byte since all JPEG markers are simply single
     *         bytes.
     */
    public static function getBytes($m)
    {
        return chr($m);
    }

    /**
     * Return the short name for a marker.
     *
     * @param PelJpegMarker $m
     *            the marker.
     *
     * @return string the name of the marker, e.g., 'SOI' for the Start
     *         of Image marker.
     */
    public static function getName($m)
    {
        switch ($m) {
            case self::SOF0:
                return 'SOF0';
            case self::SOF1:
                return 'SOF1';
            case self::SOF2:
                return 'SOF2';
            case self::SOF3:
                return 'SOF3';
            case self::SOF5:
                return 'SOF5';
            case self::SOF6:
                return 'SOF6';
            case self::SOF7:
                return 'SOF7';
            case self::SOF9:
                return 'SOF9';
            case self::SOF10:
                return 'SOF10';
            case self::SOF11:
                return 'SOF11';
            case self::SOF13:
                return 'SOF13';
            case self::SOF14:
                return 'SOF14';
            case self::SOF15:
                return 'SOF15';
            case self::SOI:
                return 'SOI';
            case self::EOI:
                return 'EOI';
            case self::SOS:
                return 'SOS';
            case self::COM:
                return 'COM';
            case self::DHT:
                return 'DHT';
            case self::JPG:
                return 'JPG';
            case self::DAC:
                return 'DAC';
            case self::RST0:
                return 'RST0';
            case self::RST1:
                return 'RST1';
            case self::RST2:
                return 'RST2';
            case self::RST3:
                return 'RST3';
            case self::RST4:
                return 'RST4';
            case self::RST5:
                return 'RST5';
            case self::RST6:
                return 'RST6';
            case self::RST7:
                return 'RST7';
            case self::DQT:
                return 'DQT';
            case self::DNL:
                return 'DNL';
            case self::DRI:
                return 'DRI';
            case self::DHP:
                return 'DHP';
            case self::EXP:
                return 'EXP';
            case self::APP0:
                return 'APP0';
            case self::APP1:
                return 'APP1';
            case self::APP2:
                return 'APP2';
            case self::APP3:
                return 'APP3';
            case self::APP4:
                return 'APP4';
            case self::APP5:
                return 'APP5';
            case self::APP6:
                return 'APP6';
            case self::APP7:
                return 'APP7';
            case self::APP8:
                return 'APP8';
            case self::APP9:
                return 'APP9';
            case self::APP10:
                return 'APP10';
            case self::APP11:
                return 'APP11';
            case self::APP12:
                return 'APP12';
            case self::APP13:
                return 'APP13';
            case self::APP14:
                return 'APP14';
            case self::APP15:
                return 'APP15';
            case self::JPG0:
                return 'JPG0';
            case self::JPG1:
                return 'JPG1';
            case self::JPG2:
                return 'JPG2';
            case self::JPG3:
                return 'JPG3';
            case self::JPG4:
                return 'JPG4';
            case self::JPG5:
                return 'JPG5';
            case self::JPG6:
                return 'JPG6';
            case self::JPG7:
                return 'JPG7';
            case self::JPG8:
                return 'JPG8';
            case self::JPG9:
                return 'JPG9';
            case self::JPG10:
                return 'JPG10';
            case self::JPG11:
                return 'JPG11';
            case self::JPG12:
                return 'JPG12';
            case self::JPG13:
                return 'JPG13';
            case self::COM:
                return 'COM';
            default:
                return Pel::fmt('Unknown marker: 0x%02X', $m);
        }
    }

    /**
     * Returns a description of a JPEG marker.
     *
     * @param PelJpegMarker $m
     *            the marker.
     *
     * @return string the description of the marker.
     */
    public static function getDescription($m)
    {
        switch ($m) {
            case self::SOF0:
                return Pel::tra('Encoding (baseline)');
            case self::SOF1:
                return Pel::tra('Encoding (extended sequential)');
            case self::SOF2:
                return Pel::tra('Encoding (progressive)');
            case self::SOF3:
                return Pel::tra('Encoding (lossless)');
            case self::SOF5:
                return Pel::tra('Encoding (differential sequential)');
            case self::SOF6:
                return Pel::tra('Encoding (differential progressive)');
            case self::SOF7:
                return Pel::tra('Encoding (differential lossless)');
            case self::SOF9:
                return Pel::tra('Encoding (extended sequential, arithmetic)');
            case self::SOF10:
                return Pel::tra('Encoding (progressive, arithmetic)');
            case self::SOF11:
                return Pel::tra('Encoding (lossless, arithmetic)');
            case self::SOF13:
                return Pel::tra('Encoding (differential sequential, arithmetic)');
            case self::SOF14:
                return Pel::tra('Encoding (differential progressive, arithmetic)');
            case self::SOF15:
                return Pel::tra('Encoding (differential lossless, arithmetic)');
            case self::SOI:
                return Pel::tra('Start of image');
            case self::EOI:
                return Pel::tra('End of image');
            case self::SOS:
                return Pel::tra('Start of scan');
            case self::COM:
                return Pel::tra('Comment');
            case self::DHT:
                return Pel::tra('Define Huffman table');
            case self::JPG:
                return Pel::tra('Extension');
            case self::DAC:
                return Pel::tra('Define arithmetic coding conditioning');
            case self::RST0:
                return Pel::fmt('Restart %d', 0);
            case self::RST1:
                return Pel::fmt('Restart %d', 1);
            case self::RST2:
                return Pel::fmt('Restart %d', 2);
            case self::RST3:
                return Pel::fmt('Restart %d', 3);
            case self::RST4:
                return Pel::fmt('Restart %d', 4);
            case self::RST5:
                return Pel::fmt('Restart %d', 5);
            case self::RST6:
                return Pel::fmt('Restart %d', 6);
            case self::RST7:
                return Pel::fmt('Restart %d', 7);
            case self::DQT:
                return Pel::tra('Define quantization table');
            case self::DNL:
                return Pel::tra('Define number of lines');
            case self::DRI:
                return Pel::tra('Define restart interval');
            case self::DHP:
                return Pel::tra('Define hierarchical progression');
            case self::EXP:
                return Pel::tra('Expand reference component');
            case self::APP0:
                return Pel::fmt('Application segment %d', 0);
            case self::APP1:
                return Pel::fmt('Application segment %d', 1);
            case self::APP2:
                return Pel::fmt('Application segment %d', 2);
            case self::APP3:
                return Pel::fmt('Application segment %d', 3);
            case self::APP4:
                return Pel::fmt('Application segment %d', 4);
            case self::APP5:
                return Pel::fmt('Application segment %d', 5);
            case self::APP6:
                return Pel::fmt('Application segment %d', 6);
            case self::APP7:
                return Pel::fmt('Application segment %d', 7);
            case self::APP8:
                return Pel::fmt('Application segment %d', 8);
            case self::APP9:
                return Pel::fmt('Application segment %d', 9);
            case self::APP10:
                return Pel::fmt('Application segment %d', 10);
            case self::APP11:
                return Pel::fmt('Application segment %d', 11);
            case self::APP12:
                return Pel::fmt('Application segment %d', 12);
            case self::APP13:
                return Pel::fmt('Application segment %d', 13);
            case self::APP14:
                return Pel::fmt('Application segment %d', 14);
            case self::APP15:
                return Pel::fmt('Application segment %d', 15);
            case self::JPG0:
                return Pel::fmt('Extension %d', 0);
            case self::JPG1:
                return Pel::fmt('Extension %d', 1);
            case self::JPG2:
                return Pel::fmt('Extension %d', 2);
            case self::JPG3:
                return Pel::fmt('Extension %d', 3);
            case self::JPG4:
                return Pel::fmt('Extension %d', 4);
            case self::JPG5:
                return Pel::fmt('Extension %d', 5);
            case self::JPG6:
                return Pel::fmt('Extension %d', 6);
            case self::JPG7:
                return Pel::fmt('Extension %d', 7);
            case self::JPG8:
                return Pel::fmt('Extension %d', 8);
            case self::JPG9:
                return Pel::fmt('Extension %d', 9);
            case self::JPG10:
                return Pel::fmt('Extension %d', 10);
            case self::JPG11:
                return Pel::fmt('Extension %d', 11);
            case self::JPG12:
                return Pel::fmt('Extension %d', 12);
            case self::JPG13:
                return Pel::fmt('Extension %d', 13);
            case self::COM:
                return Pel::tra('Comment');
            default:
                return Pel::fmt('Unknown marker: 0x%02X', $m);
        }
    }
}
