<?php

/**
 *  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004, 2005, 2006  Martin Geisler.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program in the file COPYING; if not, write to the
 *  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 *  Boston, MA 02110-1301 USA
 */

/* $Id$ */


/**
 * Classes for dealing with Exif entries.
 *
 * This file defines two exception classes and the abstract class
 * {@link PelEntry} which provides the basic methods that all Exif
 * entries will have.  All Exif entries will be represented by
 * descendants of the {@link PelEntry} class --- the class itself is
 * abstract and so it cannot be instantiated.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelException.php');
require_once('PelFormat.php');
require_once('PelTag.php');
require_once('Pel.php');
/**#@-*/


/**
 * Exception indicating a problem with an entry.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelEntryException extends PelException {

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
     * {@link PelIfd::EXIF}, {@link PelIfd::GPS}, or {@link
     * PelIfd::INTEROPERABILITY}.  If no type is set, null is returned.
     */
    function getIfdType() {
        return $this->type;
    }


    /**
     * Get the tag associated with the exception.
     *
     * @return PelTag the tag.  If no tag is set, null is returned.
     */
    function getTag() {
        return $this->tag;
    }

}


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
class PelUnexpectedFormatException extends PelEntryException {

    /**
     * Construct a new exception indicating an invalid format.
     *
     * @param int the type of IFD.
     *
     * @param PelTag the tag for which the violation was found.
     *
     * @param PelFormat the format found.
     *
     * @param PelFormat the expected format.
     */
    function __construct($type, $tag, $found, $expected) {
        parent::__construct('Unexpected format found for %s tag: PelFormat::%s. ' .
                        'Expected PelFormat::%s instead.',
        PelTag::getName($type, $tag),
        strtoupper(PelFormat::getName($found)),
        strtoupper(PelFormat::getName($expected)));
        $this->tag  = $tag;
        $this->type = $type;
    }
}


/**
 * Exception indicating that an unexpected number of components was
 * found.
 *
 * Some tags have strict limits as to the allowed number of
 * components, and this exception is thrown if the data violates such
 * a constraint.  The documentation for each tag in {@link PelTag}
 * explains the expected number of components.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelWrongComponentCountException extends PelEntryException {

    /**
     * Construct a new exception indicating a wrong number of
     * components.
     *
     * @param int the type of IFD.
     *
     * @param PelTag the tag for which the violation was found.
     *
     * @param int the number of components found.
     *
     * @param int the expected number of components.
     */
    function __construct($type, $tag, $found, $expected) {
        parent::__construct('Wrong number of components found for %s tag: %d. ' .
                        'Expected %d.',
        PelTag::getName($type, $tag), $found, $expected);
        $this->tag  = $tag;
        $this->type = $type;
    }
}


/**
 * Common ancestor class of all {@link PelIfd} entries.
 *
 * As this class is abstract you cannot instantiate objects from it.
 * It only serves as a common ancestor to define the methods common to
 * all entries.  The most important methods are {@link getValue()} and
 * {@link setValue()}, both of which is abstract in this class.  The
 * descendants will give concrete implementations for them.
 *
 * If you have some data coming from an image (some raw bytes), then
 * the static method {@link newFromData()} is helpful --- it will look
 * at the data and give you a proper decendent of {@link PelEntry}
 * back.
 *
 * If you instead want to have an entry for some data which take the
 * form of an integer, a string, a byte, or some other PHP type, then
 * don't use this class.  You should instead create an object of the
 * right subclass ({@link PelEntryShort} for short integers, {@link
 * PelEntryAscii} for strings, and so on) directly.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
abstract class PelEntry {

    /**
     * Type of IFD containing this tag.
     *
     * This must be one of the constants defined in {@link PelIfd}:
     * {@link PelIfd::IFD0} for the main image IFD, {@link PelIfd::IFD1}
     * for the thumbnail image IFD, {@link PelIfd::EXIF} for the Exif
     * sub-IFD, {@link PelIfd::GPS} for the GPS sub-IFD, or {@link
     * PelIfd::INTEROPERABILITY} for the interoperability sub-IFD.
     *
     * @var int
     */
    protected $ifd_type;

    /**
     * The bytes representing this entry.
     *
     * Subclasses must either override {@link getBytes()} or, if
     * possible, maintain this property so that it always contains a
     * true representation of the entry.
     *
     * @var string
     */
    protected $bytes = '';

    /**
     * The {@link PelTag} of this entry.
     *
     * @var PelTag
     */
    protected $tag;

    /**
     * The {@link PelFormat} of this entry.
     *
     * @var PelFormat
     */
    protected $format;

    /**
     * The number of components of this entry.
     *
     * @var int
     */
    protected $components;


    /**
     * Return the tag of this entry.
     *
     * @return PelTag the tag of this entry.
     */
    function getTag() {
        return $this->tag;
    }


    /**
     * Return the type of IFD which holds this entry.
     *
     * @return int one of the constants defined in {@link PelIfd}:
     * {@link PelIfd::IFD0} for the main image IFD, {@link PelIfd::IFD1}
     * for the thumbnail image IFD, {@link PelIfd::EXIF} for the Exif
     * sub-IFD, {@link PelIfd::GPS} for the GPS sub-IFD, or {@link
     * PelIfd::INTEROPERABILITY} for the interoperability sub-IFD.
     */
    function getIfdType() {
        return $this->ifd_type;
    }


    /**
     * Update the IFD type.
     *
     * @param int must be one of the constants defined in {@link
     * PelIfd}: {@link PelIfd::IFD0} for the main image IFD, {@link
     * PelIfd::IFD1} for the thumbnail image IFD, {@link PelIfd::EXIF}
     * for the Exif sub-IFD, {@link PelIfd::GPS} for the GPS sub-IFD, or
     * {@link PelIfd::INTEROPERABILITY} for the interoperability
     * sub-IFD.
     */
    function setIfdType($type) {
        $this->ifd_type = $type;
    }


    /**
     * Return the format of this entry.
     *
     * @return PelFormat the format of this entry.
     */
    function getFormat() {
        return $this->format;
    }


    /**
     * Return the number of components of this entry.
     *
     * @return int the number of components of this entry.
     */
    function getComponents() {
        return $this->components;
    }


    /**
     * Turn this entry into bytes.
     *
     * @param PelByteOrder the desired byte order, which must be either
     * {@link Convert::LITTLE_ENDIAN} or {@link Convert::BIG_ENDIAN}.
     *
     * @return string bytes representing this entry.
     */
    function getBytes($o) {
        return $this->bytes;
    }


    /**
     * Get the value of this entry as text.
     *
     * The value will be returned in a format suitable for presentation,
     * e.g., rationals will be returned as 'x/y', ASCII strings will be
     * returned as themselves etc.
     *
     * @param boolean some values can be returned in a long or more
     * brief form, and this parameter controls that.
     *
     * @return string the value as text.
     */
    abstract function getText($brief = false);


    /**
     * Get the value of this entry.
     *
     * The value returned will generally be the same as the one supplied
     * to the constructor or with {@link setValue()}.  For a formatted
     * version of the value, one should use {@link getText()} instead.
     *
     * @return mixed the unformatted value.
     */
    abstract function getValue();


    /**
     * Set the value of this entry.
     *
     * The value should be in the same format as for the constructor.
     *
     * @param mixed the new value.
     *
     * @abstract
     */
    function setValue($value) {
        /* This (fake) abstract method is here to make it possible for the
         * documentation to refer to PelEntry::setValue().
         *
         * It cannot declared abstract in the proper PHP way, for then PHP
         * wont allow subclasses to define it with two arguments (which is
         * what PelEntryCopyright does).
         */
        throw new PelException('setValue() is abstract.');
    }


    /**
     * Turn this entry into a string.
     *
     * @return string a string representation of this entry.  This is
     * mostly for debugging.
     */
    function __toString() {
        $str = Pel::fmt("  Tag: 0x%04X (%s)\n",
        $this->tag, PelTag::getName($this->ifd_type, $this->tag));
        $str .= Pel::fmt("    Format    : %d (%s)\n",
        $this->format, PelFormat::getName($this->format));
        $str .= Pel::fmt("    Components: %d\n", $this->components);
        if ($this->getTag() != PelTag::MAKER_NOTE &&
        $this->getTag() != PelTag::PRINT_IM)
        $str .= Pel::fmt("    Value     : %s\n", print_r($this->getValue(), true));
        $str .= Pel::fmt("    Text      : %s\n", $this->getText());
        return $str;
    }
}

