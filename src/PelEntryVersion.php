<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005 Martin Geisler.
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
 * Classes used to hold data for Exif tags of format undefined.
 *
 * This file contains the base class {@link PelEntryUndefined} and
 * the subclasses {@link PelEntryUserComment} which should be used
 * to manage the {@link PelTag::USER_COMMENT} tag, and {@link
 * PelEntryVersion} which is used to manage entries with version
 * information.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

/**
 * Class to hold version information.
 *
 * There are three Exif entries that hold version information: the
 * {@link PelTag::EXIF_VERSION}, {@link
 * PelTag::FLASH_PIX_VERSION}, and {@link
 * PelTag::INTEROPERABILITY_VERSION} tags. This class manages
 * those tags.
 *
 * The class is used in a very straight-forward way:
 * <code>
 * $entry = new PelEntryVersion(PelTag::EXIF_VERSION, 2.2);
 * </code>
 * This creates an entry for an file complying to the Exif 2.2
 * standard. It is easy to test for standards level of an unknown
 * entry:
 * <code>
 * if ($entry->getTag() == PelTag::EXIF_VERSION &&
 * $entry->getValue() > 2.0) {
 * echo 'Recent Exif version.';
 * }
 * </code>
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryVersion extends PelEntry
{

    /**
     * The version held by this entry.
     *
     * @var float
     */
    private $version;

    /**
     * The value held by this entry.
     *
     * @var array
     */
    protected $value = [];

    /**
     * Make a new entry for holding a version.
     *
     * @param integer $tag
     *            This should be one of {@link
     *            PelTag::EXIF_VERSION}, {@link PelTag::FLASH_PIX_VERSION},
     *            or {@link PelTag::INTEROPERABILITY_VERSION}.
     *
     * @param float $version
     *            The size of the entries leave room for
     *            exactly four digits: two digits on either side of the decimal
     *            point.
     */
    public function __construct($tag, $version = 0.0)
    {
        $this->tag = $tag;
        $this->format = PelFormat::UNDEFINED;
        $this->setValue($version);
    }

    /**
     * Get arguments for the instance constructor from file data.
     *
     * @param int $ifd_id
     *            the IFD id.
     * @param int $tag_id
     *            the TAG id.
     * @param int $format
     *            the format of the entry as defined in {@link PelFormat}.
     * @param int $components
     *            the components in the entry.
     * @param PelDataWindow $data
     *            the data which will be used to construct the entry.
     * @param int $data_offset
     *            the offset of the main DataWindow where data is stored.
     *
     * @return array a list or arguments to be passed to the PelEntry subclass
     *            constructor.
     */
    public static function getInstanceArgumentsFromData($ifd_id, $tag_id, $format, $components, PelDataWindow $data, $data_offset)
    {
        if ($format != PelFormat::UNDEFINED) {
            throw new PelUnexpectedFormatException($ifd_id, $tag_id, $format, PelFormat::UNDEFINED);
        }
        return [$data->getBytes() / 100];
    }

    /**
     * Set the version held by this entry.
     *
     * @param float $version
     *            The size of the entries leave room for
     *            exactly four digits: two digits on either side of the decimal
     *            point.
     */
    public function setValue($version = 0.0)
    {
        $this->version = $version;
        $this->value[0] = $version;
        $major = floor($version);
        $minor = ($version - $major) * 100;
        $strValue = sprintf('%02.0f%02.0f', $major, $minor);
        $this->components = strlen($strValue);
        $this->bytes = $strValue;
    }

    /**
     * Return the version held by this entry.
     *
     * @return float This will be the same as the value
     *         given to {@link setValue} or {@link __construct the
     *         constructor}.
     */
    public function getValue()
    {
        return $this->version;
    }

    /**
     * Validates a version string.
     *
     * @param string $value
     *            the string version.
     *
     * @return string
     *            the validated string version.
     */
    private static function validateVersion($value)
    {
        return floor($value) == $value ? $value .= '.0' : $value;
    }

    /**
     * Decode text for an Exif/ExifVersion tag.
     *
     * @param PelEntry $entry
     *            the TAG PelEntry object.
     * @param bool $brief
     *            (Optional) indicates to use brief output.
     *
     * @return string
     *            the TAG text.
     */
    public static function decodeExifVersion(PelEntry $entry, $brief = false)
    {
        $version = static::validateVersion($entry->getValue());
        if ($brief) {
            return Pel::fmt('Exif %s', $version);
        } else {
            return Pel::fmt('Exif Version %s', $version);
        }
    }

    /**
     * Decode text for an Exif/FlashPixVersion tag.
     *
     * @param PelEntry $entry
     *            the TAG PelEntry object.
     * @param bool $brief
     *            (Optional) indicates to use brief output.
     *
     * @return string
     *            the TAG text.
     */
    public static function decodeFlashPixVersion(PelEntry $entry, $brief = false)
    {
        $version = static::validateVersion($entry->getValue());
        if ($brief) {
            return Pel::fmt('FlashPix %s', $version);
        } else {
            return Pel::fmt('FlashPix Version %s', $version);
        }
    }

    /**
     * Decode text for an Interoperability/InteroperabilityVersion tag.
     *
     * @param PelEntry $entry
     *            the TAG PelEntry object.
     * @param bool $brief
     *            (Optional) indicates to use brief output.
     *
     * @return string
     *            the TAG text.
     */
    public static function decodeInteroperabilityVersion(PelEntry $entry, $brief = false)
    {
        $version = static::validateVersion($entry->getValue());
        if ($brief) {
            return Pel::fmt('Interoperability %s', $version);
        } else {
            return Pel::fmt('Interoperability Version %s', $version);
        }
    }

    /**
     * Return a text string with the version.
     *
     * @param boolean $brief
     *            controls if the output should be brief. Brief
     *            output omits the word 'Version' so the result is just 'Exif x.y'
     *            instead of 'Exif Version x.y' if the entry holds information
     *            about the Exif version --- the output for FlashPix is similar.
     *
     * @return string the version number with the type of the tag,
     *         either 'Exif' or 'FlashPix'.
     */
    public function getText($brief = false)
    {
        // If PelSpec can return the text, return it.
        if (($tag_text = parent::getText($brief)) !== null) {
            return $tag_text;
        }

        $version = static::validateVersion($this->value[0]);
        if ($brief) {
            return $version;
        } else {
            return Pel::fmt('Version %s', $version);
        }
    }
}
