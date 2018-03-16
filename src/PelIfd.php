<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007, 2008 Martin Geisler.
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
 * Classes for dealing with Exif IFDs.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

/**
 * Class representing an Image File Directory (IFD).
 *
 * {@link PelTiff TIFF data} is structured as a number of Image File
 * Directories, IFDs for short. Each IFD contains a number of {@link
 * PelEntry entries}, some data and finally a link to the next IFD.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelIfd implements \IteratorAggregate, \ArrayAccess
{
    /**
     * Main image IFD.
     *
     * Pass this to the constructor when creating an IFD which will be
     * the IFD of the main image.
     */
    const IFD0 = 0;

    /**
     * Thumbnail image IFD.
     *
     * Pass this to the constructor when creating an IFD which will be
     * the IFD of the thumbnail image.
     */
    const IFD1 = 1;

    /**
     * Exif IFD.
     *
     * Pass this to the constructor when creating an IFD which will be
     * the Exif sub-IFD.
     */
    const EXIF = 2;

    /**
     * GPS IFD.
     *
     * Pass this to the constructor when creating an IFD which will be
     * the GPS sub-IFD.
     */
    const GPS = 3;

    /**
     * Interoperability IFD.
     *
     * Pass this to the constructor when creating an IFD which will be
     * the interoperability sub-IFD.
     */
    const INTEROPERABILITY = 4;

    /**
     * The entries held by this directory.
     *
     * Each tag in the directory is represented by a {@link PelEntry}
     * object in this array.
     *
     * @var array
     */
    protected $entries = [];

    /**
     * The type of this directory.
     *
     * Initialized in the constructor.
     *
     * @var int
     */
    protected $type;

    /**
     * The next directory.
     *
     * This will be initialized in the constructor, or be left as null
     * if this is the last directory.
     *
     * @var PelIfd
     */
    protected $next = null;

    /**
     * Sub-directories pointed to by this directory.
     *
     * This will be an array of ({@link PelTag}, {@link PelIfd}) pairs.
     *
     * @var array
     */
    protected $sub = [];

    /**
     * The thumbnail data.
     *
     * This will be initialized in the constructor, or be left as null
     * if there are no thumbnail as part of this directory.
     *
     * @var PelDataWindow
     */
    protected $thumb_data = null;
    // TODO: use this format to choose between the
    // JPEG_INTERCHANGE_FORMAT and STRIP_OFFSETS tags.
    // private $thumb_format;

    /**
     * Construct a new Image File Directory (IFD).
     *
     * The IFD will be empty, use the {@link addEntry()} method to add
     * an {@link PelEntry}. Use the {@link setNext()} method to link
     * this IFD to another.
     *
     * @param int $type
     *            the type of this IFD, as found in PelSpec. A
     *            {@link PelIfdException} will be thrown if unknown.
     */
    public function __construct($type)
    {
        if (PelSpec::getIfdType($type) === null) {
            throw new PelIfdException('Unknown IFD type: %d', $type);
        }

        $this->type = $type;
    }

    /**
     * Load data into a Image File Directory (IFD).
     *
     * @param PelDataWindow $d
     *            the data window that will provide the data.
     * @param int $offset
     *            the offset within the window where the directory will
     *            be found.
     * @param int $components
     *            (Optional) the number of components held by this IFD.
     * @param int $nesting_level
     *            (Optional) the level of nesting of this IFD in the overall
     *            structure.
     */
    public function load(PelDataWindow $d, $offset, $components = 1, $nesting_level = 0)
    {
        $starting_offset = $offset;

        $thumb_offset = 0;
        $thumb_length = 0;

        /* Read the number of entries */
        $n = $d->getShort($offset);
        Pel::debug(
            str_repeat("  ", $nesting_level) . "** Constructing IFD '%s' with %d entries at offset %d from %d bytes...",
            $this->getName(),
            $n,
            $offset,
            $d->getSize()
        );

        $offset += 2;

        /* Check if we have enough data. */
        if ($offset + 12 * $n > $d->getSize()) {
            $n = floor(($offset - $d->getSize()) / 12);
            Pel::maybeThrow(new PelIfdException('Adjusted to: %d.', $n));
        }

        for ($i = 0; $i < $n; $i++) {
            // TODO: increment window start instead of using offsets.
            $tag = $d->getShort($offset + 12 * $i);
            $tag_format = $d->getShort($offset + 12 * $i + 2);
            $tag_components = $d->getLong($offset + 12 * $i + 4);

            // Check if PEL can support this TAG.
            if (!$this->isValidTag($tag)) {
                Pel::maybeThrow(
                    new PelIfdException(
                        str_repeat("  ", $nesting_level) . "No specification available for TAG 0x%04X in IFD '%s', skipping (%d of %d)...",
                        $tag,
                        $this->getName(),
                        $i + 1,
                        $n
                    )
                );
                continue;
            }

            Pel::debug(
                str_repeat("  ", $nesting_level) . 'Tag 0x%04X: (%s) Fmt: %d (%s) Components: %d (%d of %d)...',
                $tag,
                PelSpec::getTagName($this->type, $tag),
                $tag_format,
                PelFormat::getName($tag_format),
                $tag_components,
                $i + 1,
                $n
            );

            // Load a subIfd.
            if (PelSpec::isTagAnIfdPointer($this->type, $tag)) {
                // If the tag is an IFD pointer, loads the IFD.
                $type = PelSpec::getIfdIdFromTag($this->type, $tag);
                $o = $d->getLong($offset + 12 * $i + 8);
                if ($starting_offset != $o) {
                    $ifd_class = PelSpec::getIfdClass($type);
                    $ifd = new $ifd_class($type);
                    try {
                        $ifd->load($d, $o, $tag_components, $nesting_level + 1);
                        $this->sub[$type] = $ifd;
                    } catch (PelDataWindowOffsetException $e) {
                        Pel::maybeThrow(new PelIfdException($e->getMessage()));
                    }
                } else {
                    Pel::maybeThrow(new PelIfdException('Bogus offset to next IFD: %d, same as offset being loaded from.', $o));
                }
                continue;
            }

            // Manage Thumbnail data.
            if (PelSpec::getTagName($this->type, $tag) === 'JPEGInterchangeFormat') {
                // Aka 'Thumbnail Offset'.
                $thumb_offset = $d->getLong($offset + 12 * $i + 8);
                $this->safeSetThumbnail($d, $thumb_offset, $thumb_length);
                continue;
            }
            if (PelSpec::getTagName($this->type, $tag) === 'JPEGInterchangeFormatLength') {
                // Aka 'Thumbnail Length'.
                $thumb_length = $d->getLong($offset + 12 * $i + 8);
                $this->safeSetThumbnail($d, $thumb_offset, $thumb_length);
                continue;
            }

            // Load a TAG entry.
            if ($entry = PelEntry::createFromData($this->type, $tag, $d, $offset, $i)) {
                $this->addEntry($entry);
            }
        }

        /* Offset to next IFD */
        $o = $d->getLong($offset + 12 * $n);
        Pel::debug(str_repeat("  ", $nesting_level) . 'Current offset is %d, link at %d points to %d.', $offset, $offset + 12 * $n, $o);

        if ($o > 0) {
            /* Sanity check: we need 6 bytes */
            if ($o > $d->getSize() - 6) {
                Pel::maybeThrow(new PelIfdException('Bogus offset to next IFD: ' . '%d > %d!', $o, $d->getSize() - 6));
            } else {
                if (PelSpec::getIfdType($this->type) === '1') {
                    // IFD1 shouldn't link further...
                    Pel::maybeThrow(new PelIfdException('IFD1 links to another IFD!'));
                }
                $this->next = new PelIfd(PelSpec::getIfdIdByType('1'));
                $this->next->load($d, $o);
            }
        }

        Pel::debug(str_repeat("  ", $nesting_level) . "** End of loading IFD '%s'.", $this->getName());

        // Invoke post-load callbacks.
        foreach (PelSpec::getIfdPostLoadCallbacks($this->type) as $callback) {
            call_user_func($callback, $d, $this);
        }
    }

    /**
     * Load a single value which didn't match any special {@link PelTag}.
     *
     * This method will add a single value given by the {@link PelDataWindow} and it's offset ($offset) and element counter ($i).
     *
     * Please note that the data you pass to this method should come
     * from an image, that is, it should be raw bytes. If instead you
     * want to create an entry for holding, say, an short integer, then
     * create a {@link PelEntryShort} object directly and load the data
     * into it.
     *
     * @param PelDataWindow $d
     *            the data window that will provide the data.
     *
     * @param integer $offset
     *            the offset within the window where the directory will
     *            be found.
     *
     * @param int $i
     *            the element's position in the {@link PelDataWindow} $d.
     *
     * @param int $tag
     *            the tag of the entry as defined in {@link PelSpec}.
     *
     * @deprecated Use PelEntry::createFromData instead.
     */
    public function loadSingleValue($d, $offset, $i, $tag)
    {
        $this->addEntry(PelEntry::createFromData($this->type, $tag, $d, $offset, $i));
    }

    /**
     * Make a new entry from a bunch of bytes.
     *
     * This method will create the proper subclass of {@link PelEntry}
     * corresponding to the {@link PelTag} and {@link PelFormat} given.
     * The entry will be initialized with the data given.
     *
     * Please note that the data you pass to this method should come
     * from an image, that is, it should be raw bytes. If instead you
     * want to create an entry for holding, say, an short integer, then
     * create a {@link PelEntryShort} object directly and load the data
     * into it.
     *
     * A {@link PelUnexpectedFormatException} is thrown if a mismatch is
     * discovered between the tag and format, and likewise a {@link
     * PelWrongComponentCountException} is thrown if the number of
     * components does not match the requirements of the tag. The
     * requirements for a given tag (if any) can be found in the
     * documentation for {@link PelSpec}.
     *
     * @param integer $tag
     *            the tag of the entry as defined in {@link PelSpec}.
     *
     * @param integer $format
     *            the format of the entry as defined in {@link PelFormat}.
     *
     * @param int $components
     *            the components in the entry.
     *
     * @param PelDataWindow $data
     *            the data which will be used to construct the
     *            entry.
     *
     * @return PelEntry a newly created entry, holding the data given.
     *
     * @deprecated Use PelEntry::createFromData instead.
     */
    public function newEntryFromData($tag, $format, $components, PelDataWindow $data)
    {
        $class = PelSpec::getTagClass($this->type, $tag, $format);
        $arguments = call_user_func($class . '::getInstanceArgumentsFromData', $this->type, $tag, $format, $components, $data, null);
        return call_user_func($class . '::createInstance', $this->type, $tag, $arguments);
    }

    /**
     * Extract thumbnail data safely.
     *
     * It is safe to call this method repeatedly with either the offset
     * or the length set to zero, since it requires both of these
     * arguments to be positive before the thumbnail is extracted.
     *
     * When both parameters are set it will check the length against the
     * available data and adjust as necessary. Only then is the
     * thumbnail data loaded.
     *
     * @param PelDataWindow $d
     *            the data from which the thumbnail will be
     *            extracted.
     *
     * @param int $offset
     *            the offset into the data.
     *
     * @param int $length
     *            the length of the thumbnail.
     */
    protected function safeSetThumbnail(PelDataWindow $d, $offset, $length)
    {
        /*
         * Load the thumbnail if both the offset and the length is
         * available.
         */
        if ($offset > 0 && $length > 0) {
            /*
             * Some images have a broken length, so we try to carefully
             * check the length before we store the thumbnail.
             */
            if ($offset + $length > $d->getSize()) {
                Pel::maybeThrow(
                    new PelIfdException(
                        'Thumbnail length %d bytes ' . 'adjusted to %d bytes.',
                        $length,
                        $d->getSize() - $offset
                    )
                );
                $length = $d->getSize() - $offset;
            }

            /* Now set the thumbnail normally. */
            try {
                $this->setThumbnail($d->getClone($offset, $length));
            } catch (PelDataWindowWindowException $e) {
                Pel::maybeThrow(new PelIfdException($e->getMessage()));
            }
        }
    }

    /**
     * Set thumbnail data.
     *
     * Use this to embed an arbitrary JPEG image within this IFD. The
     * data will be checked to ensure that it has a proper {@link
     * PelJpegMarker::EOI} at the end. If not, then the length is
     * adjusted until one if found. An {@link PelIfdException} might be
     * thrown (depending on {@link Pel::$strict}) this case.
     *
     * @param PelDataWindow $d
     *            the thumbnail data.
     */
    public function setThumbnail(PelDataWindow $d)
    {
        $size = $d->getSize();
        /* Now move backwards until we find the EOI JPEG marker. */
        while ($d->getByte($size - 2) != 0xFF || $d->getByte($size - 1) != PelJpegMarker::EOI) {
            $size --;
        }

        if ($size != $d->getSize()) {
            Pel::maybeThrow(new PelIfdException('Decrementing thumbnail size ' . 'to %d bytes', $size));
        }
        $this->thumb_data = $d->getClone(0, $size);
    }

    /**
     * Get the type of this directory.
     *
     * @return int the type of this directory, as identified in PelSpec.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Is a given tag valid for this IFD?
     *
     * Different types of IFDs can contain different kinds of tags ---
     * the {@link IFD0} type, for example, cannot contain a {@link
     * PelTag::GPS_LONGITUDE} tag.
     *
     * A special exception is tags with values above 0xF000. They are
     * treated as private tags and will be allowed everywhere (use this
     * for testing or for implementing your own types of tags).
     *
     * @param int $tag
     *            the tag.
     *
     * @return boolean true if the tag is considered valid in this IFD,
     *         false otherwise.
     *
     * @see getValidTags()
     */
    public function isValidTag($tag)
    {
        return $tag > 0xF000 || in_array($tag, $this->getValidTags());
    }

    /**
     * Returns a list of valid tags for this IFD.
     *
     * @return array an array of {@link PelTag}s which are valid for
     *         this IFD.
     */
    public function getValidTags()
    {
        return PelSpec::getIfdSupportedTagIds($this->type);

        /*
         * TODO: Where do these tags belong?
         * PelTag::FILL_ORDER,
         * PelTag::TRANSFER_RANGE,
         * PelTag::JPEG_PROC,
         * PelTag::BATTERY_LEVEL,
         * PelTag::IPTC_NAA,
         * PelTag::INTER_COLOR_PROFILE,
         * PelTag::CFA_REPEAT_PATTERN_DIM,
         */
    }

    /**
     * Get the name of an IFD type.
     *
     * @param int $type
     *            the type of the directory, as identified in PelSpec.
     *
     * @return string the name of type.
     */
    public static function getTypeName($type)
    {
        if (PelSpec::getIfdType($type) !== null) {
            return PelSpec::getIfdType($type);
        }
        throw new PelIfdException('Unknown IFD type: %d', $type);
    }

    /**
     * Get the name of this directory.
     *
     * @return string the name of this directory.
     */
    public function getName()
    {
        return $this->getTypeName($this->type);
    }

    /**
     * Adds an entry to the directory.
     *
     * @param PelEntry $e
     *            the entry that will be added. If the entry is not
     *            valid in this IFD (as per {@link isValidTag()}) an
     *            {@link PelInvalidDataException} is thrown.
     *
     * @todo The entry will be identified with its tag, so each
     *       directory can only contain one entry with each tag. Is this a
     *       bug?
     */
    public function addEntry(PelEntry $e)
    {
        if ($this->isValidTag($e->getTag())) {
            $e->setIfdType($this->type);
            $this->entries[$e->getTag()] = $e;
        } else {
            throw new PelInvalidDataException("IFD %s cannot hold\n%s", $this->getName(), $e->__toString());
        }
    }

    /**
     * Does a given tag exist in this IFD?
     *
     * This methods is part of the ArrayAccess SPL interface for
     * overriding array access of objects, it allows you to check for
     * existance of an entry in the IFD:
     *
     * <code>
     * if (isset($ifd[PelTag::FNUMBER]))
     * // ... do something with the F-number.
     * </code>
     *
     * @param int $tag
     *            the offset to check.
     *
     * @return boolean whether the tag exists.
     */
    public function offsetExists($tag)
    {
        return isset($this->entries[$tag]);
    }

    /**
     * Retrieve a given tag from this IFD.
     *
     * This methods is part of the ArrayAccess SPL interface for
     * overriding array access of objects, it allows you to read entries
     * from the IFD the same was as for an array:
     *
     * <code>
     * $entry = $ifd[PelTag::FNUMBER];
     * </code>
     *
     * @param int $tag
     *            the tag to return. It is an error to ask for a tag
     *            which is not in the IFD, just like asking for a non-existant
     *            array entry.
     *
     * @return PelEntry the entry.
     */
    public function offsetGet($tag)
    {
        return $this->entries[$tag];
    }

    /**
     * Set or update a given tag in this IFD.
     *
     * This methods is part of the ArrayAccess SPL interface for
     * overriding array access of objects, it allows you to add new
     * entries or replace esisting entries by doing:
     *
     * <code>
     * $ifd[PelTag::EXPOSURE_BIAS_VALUE] = $entry;
     * </code>
     *
     * Note that the actual array index passed is ignored! Instead the
     * {@link PelTag} from the entry is used.
     *
     * @param int $tag
     *            unused.
     *
     * @param PelEntry $e
     *            the new value.
     */
    public function offsetSet($tag, $e)
    {
        if ($e instanceof PelEntry) {
            $tag = $e->getTag();
            $this->entries[$tag] = $e;
        } else {
            throw new PelInvalidArgumentException('Argument "%s" must be a PelEntry.', $e);
        }
    }

    /**
     * Unset a given tag in this IFD.
     *
     * This methods is part of the ArrayAccess SPL interface for
     * overriding array access of objects, it allows you to delete
     * entries in the IFD by doing:
     *
     * <code>
     * unset($ifd[PelTag::EXPOSURE_BIAS_VALUE])
     * </code>
     *
     * @param int $tag
     *            the offset to delete.
     */
    public function offsetUnset($tag)
    {
        unset($this->entries[$tag]);
    }

    /**
     * Retrieve an entry.
     *
     * @param int $tag
     *            the tag identifying the entry.
     *
     * @return PelEntry the entry associated with the tag, or null if no
     *         such entry exists.
     */
    public function getEntry($tag)
    {
        if (isset($this->entries[$tag])) {
            return $this->entries[$tag];
        } else {
            return null;
        }
    }

    /**
     * Returns all entries contained in this IFD.
     *
     * @return array an array of {@link PelEntry} objects, or rather
     *         descendant classes. The array has {@link PelTag}s as keys
     *         and the entries as values.
     *
     * @see getEntry
     * @see getIterator
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Return an iterator for all entries contained in this IFD.
     *
     * Used with foreach as in
     *
     * <code>
     * foreach ($ifd as $tag => $entry) {
     * // $tag is now a PelTag and $entry is a PelEntry object.
     * }
     * </code>
     *
     * @return Iterator an iterator using the {@link PelTag tags} as
     *         keys and the entries as values.
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->entries);
    }

    /**
     * Returns available thumbnail data.
     *
     * @return string the bytes in the thumbnail, if any. If the IFD
     *         does not contain any thumbnail data, the empty string is
     *         returned.
     *
     * @todo Throw an exception instead when no data is available?
     *
     * @todo Return the $this->thumb_data object instead of the bytes?
     */
    public function getThumbnailData()
    {
        if ($this->thumb_data !== null) {
            return $this->thumb_data->getBytes();
        } else {
            return '';
        }
    }

    /**
     * Make this directory point to a new directory.
     *
     * @param PelIfd $i
     *            the IFD that this directory will point to.
     */
    public function setNextIfd(PelIfd $i)
    {
        $this->next = $i;
    }

    /**
     * Return the IFD pointed to by this directory.
     *
     * @return PelIfd the next IFD, following this IFD. If this is the
     *         last IFD, null is returned.
     */
    public function getNextIfd()
    {
        return $this->next;
    }

    /**
     * Check if this is the last IFD.
     *
     * @return boolean true if there are no following IFD, false
     *         otherwise.
     */
    public function isLastIfd()
    {
        return $this->next === null;
    }

    /**
     * Add a sub-IFD.
     *
     * Any previous sub-IFD of the same type will be overwritten.
     *
     * @param PelIfd $sub
     *            the sub IFD.
     */
    public function addSubIfd(PelIfd $sub)
    {
        $this->sub[$sub->type] = $sub;
    }

    /**
     * Return a sub IFD.
     *
     * @param int $type
     *            the type of the sub IFD.
     *
     * @return PelIfd the IFD associated with the type, or null if that
     *         sub IFD does not exist.
     */
    public function getSubIfd($type)
    {
        if (isset($this->sub[$type])) {
            return $this->sub[$type];
        } else {
            return null;
        }
    }

    /**
     * Get all sub IFDs.
     *
     * @return array an associative array with (IFD-type, {@link
     *         PelIfd}) pairs.
     */
    public function getSubIfds()
    {
        return $this->sub;
    }

    /**
     * Turn this directory into bytes.
     *
     * This directory will be turned into a byte string, with the
     * specified byte order. The offsets will be calculated from the
     * offset given.
     *
     * @param int $offset
     *            the offset of the first byte of this directory.
     *
     * @param boolean $order
     *            the byte order that should be used when
     *            turning integers into bytes. This should be one of {@link
     *            PelConvert::LITTLE_ENDIAN} and {@link PelConvert::BIG_ENDIAN}.
     */
    public function getBytes($offset, $order)
    {
        $bytes = '';
        $extra_bytes = '';

        Pel::debug('Bytes from IDF will start at offset %d within Exif data', $offset);

        $n = count($this->entries) + count($this->sub);
        if ($this->thumb_data !== null) {
            /*
             * We need two extra entries for the thumbnail offset and
             * length.
             */
            $n += 2;
        }

        $bytes .= PelConvert::shortToBytes($n, $order);

        /*
         * Initialize offset of extra data. This included the bytes
         * preceding this IFD, the bytes needed for the count of entries,
         * the entries themselves (and sub entries), the extra data in the
         * entries, and the IFD link.
         */
        $end = $offset + 2 + 12 * $n + 4;

        foreach ($this->entries as $tag => $entry) {
            /* Each entry is 12 bytes long. */
            $bytes .= PelConvert::shortToBytes($entry->getTag(), $order);
            $bytes .= PelConvert::shortToBytes($entry->getFormat(), $order);
            $bytes .= PelConvert::longToBytes($entry->getComponents(), $order);

            /*
             * Size? If bigger than 4 bytes, the actual data is not in
             * the entry but somewhere else.
             */
            $data = $entry->getBytes($order);
            $s = strlen($data);
            if ($s > 4) {
                Pel::debug('Data size %d too big, storing at offset %d instead.', $s, $end);
                $bytes .= PelConvert::longToBytes($end, $order);
                $extra_bytes .= $data;
                $end += $s;
            } else {
                Pel::debug('Data size %d fits.', $s);
                /*
                 * Copy data directly, pad with NULL bytes as necessary to
                 * fill out the four bytes available.
                 */
                $bytes .= $data . str_repeat(chr(0), 4 - $s);
            }
        }

        if ($this->thumb_data !== null) {
            Pel::debug('Appending %d bytes of thumbnail data at %d', $this->thumb_data->getSize(), $end);
            // TODO: make PelEntry a class that can be constructed with
            // arguments corresponding to the newt four lines.
            $bytes .= PelConvert::shortToBytes(PelSpec::getTagIdByName($this->type, 'JPEGInterchangeFormatLength'), $order);
            $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
            $bytes .= PelConvert::longToBytes(1, $order);
            $bytes .= PelConvert::longToBytes($this->thumb_data->getSize(), $order);

            $bytes .= PelConvert::shortToBytes(PelSpec::getTagIdByName($this->type, 'JPEGInterchangeFormat'), $order);
            $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
            $bytes .= PelConvert::longToBytes(1, $order);
            $bytes .= PelConvert::longToBytes($end, $order);

            $extra_bytes .= $this->thumb_data->getBytes();
            $end += $this->thumb_data->getSize();
        }

        /* Find bytes from sub IFDs. */
        $sub_bytes = '';
        foreach ($this->sub as $type => $sub) {
            if (PelSpec::getIfdType($type) === 'Exif') {
                $tag = PelSpec::getTagIdByName($this->type, 'ExifIFDPointer');
            } elseif (PelSpec::getIfdType($type) === 'GPS') {
                $tag = PelSpec::getTagIdByName($this->type, 'GPSInfoIFDPointer');
            } elseif (PelSpec::getIfdType($type) === 'Interoperability') {
                $tag = PelSpec::getTagIdByName($this->type, 'InteroperabilityIFDPointer');
            } else {
                // PelConvert::BIG_ENDIAN is the default used by PelConvert
                $tag = PelConvert::BIG_ENDIAN;
            }
            /* Make an aditional entry with the pointer. */
            $bytes .= PelConvert::shortToBytes($tag, $order);
            /* Next the format, which is always unsigned long. */
            $bytes .= PelConvert::shortToBytes(PelFormat::LONG, $order);
            /* There is only one component. */
            $bytes .= PelConvert::longToBytes(1, $order);

            $data = $sub->getBytes($end, $order);
            $s = strlen($data);
            $sub_bytes .= $data;

            $bytes .= PelConvert::longToBytes($end, $order);
            $end += $s;
        }

        /* Make link to next IFD, if any */
        if ($this->isLastIFD()) {
            $link = 0;
        } else {
            $link = $end;
        }

        Pel::debug('Link to next IFD: %d', $link);

        $bytes .= PelConvert::longtoBytes($link, $order);

        $bytes .= $extra_bytes . $sub_bytes;

        if (! $this->isLastIfd()) {
            $bytes .= $this->next->getBytes($end, $order);
        }
        return $bytes;
    }

    /**
     * Turn this directory into text.
     *
     * @return string information about the directory, mainly for
     *         debugging.
     */
    public function __toString()
    {
        $str = Pel::fmt("Dumping IFD %s with %d entries...\n", $this->getName(), count($this->entries));

        foreach ($this->entries as $entry) {
            $str .= $entry->__toString();
        }
        $str .= Pel::fmt("Dumping %d sub IFDs...\n", count($this->sub));

        foreach ($this->sub as $type => $ifd) {
            $str .= $ifd->__toString();
        }
        if ($this->next !== null) {
            $str .= $this->next->__toString();
        }
        return $str;
    }
}
