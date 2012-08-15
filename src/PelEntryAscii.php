<?php

/**
 *  PEL: PHP Exif Library.  A library with support for reading and
 *  writing all Exif headers in JPEG and TIFF images using PHP.
 *
 *  Copyright (C) 2004, 2005, 2006, 2007  Martin Geisler.
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
 * Classes used to hold ASCII strings.
 *
 * The classes defined here are to be used for Exif entries holding
 * ASCII strings, such as {@link PelTag::MAKE}, {@link
 * PelTag::SOFTWARE}, and {@link PelTag::DATE_TIME}.  For
 * entries holding normal textual ASCII strings the class {@link
 * PelEntryAscii} should be used, but for entries holding
 * timestamps the class {@link PelEntryTime} would be more
 * convenient instead.  Copyright information is handled by the {@link
 * PelEntryCopyright} class.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */

/**#@+ Required class definitions. */
require_once('PelEntry.php');
/**#@-*/


/**
 * Class for holding a plain ASCII string.
 *
 * This class can hold a single ASCII string, and it will be used as in
 * <code>
 * $entry = $ifd->getEntry(PelTag::IMAGE_DESCRIPTION);
 * print($entry->getValue());
 * $entry->setValue('This is my image.  I like it.');
 * </code>
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryAscii extends PelEntry {

    /**
     * The string hold by this entry.
     *
     * This is the string that was given to the {@link __construct
     * constructor} or later to {@link setValue}, without any final NULL
     * character.
     *
     * @var string
     */
    private $str;


    /**
     * Make a new PelEntry that can hold an ASCII string.
     *
     * @param int the tag which this entry represents.  This should be
     * one of the constants defined in {@link PelTag}, e.g., {@link
     * PelTag::IMAGE_DESCRIPTION}, {@link PelTag::MODEL}, or any other
     * tag with format {@link PelFormat::ASCII}.
     *
     * @param string the string that this entry will represent.  The
     * string must obey the same rules as the string argument to {@link
     * setValue}, namely that it should be given without any trailing
     * NULL character and that it must be plain 7-bit ASCII.
     */
    function __construct($tag, $str = '') {
        $this->tag    = $tag;
        $this->format = PelFormat::ASCII;
        self::setValue($str);
    }


    /**
     * Give the entry a new ASCII value.
     *
     * This will overwrite the previous value.  The value can be
     * retrieved later with the {@link getValue} method.
     *
     * @param string the new value of the entry.  This should be given
     * without any trailing NULL character.  The string must be plain
     * 7-bit ASCII, the string should contain no high bytes.
     *
     * @todo Implement check for high bytes?
     */
    function setValue($str) {
        $this->components = strlen($str)+1;
        $this->str        = $str;
        $this->bytes      = $str . chr(0x00);
    }


    /**
     * Return the ASCII string of the entry.
     *
     * @return string the string held, without any final NULL character.
     * The string will be the same as the one given to {@link setValue}
     * or to the {@link __construct constructor}.
     */
    function getValue() {
        return $this->str;
    }


    /**
     * Return the ASCII string of the entry.
     *
     * This methods returns the same as {@link getValue}.
     *
     * @param boolean not used with ASCII entries.
     *
     * @return string the string held, without any final NULL character.
     * The string will be the same as the one given to {@link setValue}
     * or to the {@link __construct constructor}.
     */
    function getText($brief = false) {
        return $this->str;
    }

}


/**
 * Class for holding a date and time.
 *
 * This class can hold a timestamp, and it will be used as
 * in this example where the time is advanced by one week:
 * <code>
 * $entry = $ifd->getEntry(PelTag::DATE_TIME_ORIGINAL);
 * $time = $entry->getValue();
 * print('The image was taken on the ' . date('jS', $time));
 * $entry->setValue($time + 7 * 24 * 3600);
 * </code>
 *
 * The example used a standard UNIX timestamp, which is the default
 * for this class.
 *
 * But the Exif format defines dates outside the range of a UNIX
 * timestamp (about 1970 to 2038) and so you can also get access to
 * the timestamp in two other formats: a simple string or a Julian Day
 * Count. Please see the Calendar extension in the PHP Manual for more
 * information about the Julian Day Count.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryTime extends PelEntryAscii {

    /**
     * Constant denoting a UNIX timestamp.
     */
    const UNIX_TIMESTAMP   = 1;
    /**
     * Constant denoting a Exif string.
     */
    const EXIF_STRING      = 2;
    /**
     * Constant denoting a Julian Day Count.
     */
    const JULIAN_DAY_COUNT = 3;

    /**
     * The Julian Day Count of the timestamp held by this entry.
     *
     * This is an integer counting the number of whole days since
     * January 1st, 4713 B.C. The fractional part of the timestamp held
     * by this entry is stored in {@link $seconds}.
     *
     * @var int
     */
    private $day_count;

    /**
     * The number of seconds into the day of the timestamp held by this
     * entry.
     *
     * The number of whole days is stored in {@link $day_count} and the
     * number of seconds left-over is stored here.
     *
     * @var int
     */
    private $seconds;


    /**
     * Make a new entry for holding a timestamp.
     *
     * @param int the Exif tag which this entry represents.  There are
     * only three standard tags which hold timestamp, so this should be
     * one of the constants {@link PelTag::DATE_TIME}, {@link
     * PelTag::DATE_TIME_ORIGINAL}, or {@link
     * PelTag::DATE_TIME_DIGITIZED}.
     *
     * @param int the timestamp held by this entry in the correct form
     * as indicated by the third argument. For {@link UNIX_TIMESTAMP}
     * this is an integer counting the number of seconds since January
     * 1st 1970, for {@link EXIF_STRING} this is a string of the form
     * 'YYYY:MM:DD hh:mm:ss', and for {@link JULIAN_DAY_COUNT} this is a
     * floating point number where the integer part denotes the day
     * count and the fractional part denotes the time of day (0.25 means
     * 6:00, 0.75 means 18:00).
     *
     * @param int the type of the timestamp. This must be one of
     * {@link UNIX_TIMESTAMP}, {@link EXIF_STRING}, or
     * {@link JULIAN_DAY_COUNT}.
     */
    function __construct($tag, $timestamp, $type = self::UNIX_TIMESTAMP) {
        parent::__construct($tag);
        $this->setValue($timestamp, $type);
    }


    /**
     * Return the timestamp of the entry.
     *
     * The timestamp held by this entry is returned in one of three
     * formats: as a standard UNIX timestamp (default), as a fractional
     * Julian Day Count, or as a string.
     *
     * @param int the type of the timestamp. This must be one of
     * {@link UNIX_TIMESTAMP}, {@link EXIF_STRING}, or
     * {@link JULIAN_DAY_COUNT}.
     *
     * @return int the timestamp held by this entry in the correct form
     * as indicated by the type argument. For {@link UNIX_TIMESTAMP}
     * this is an integer counting the number of seconds since January
     * 1st 1970, for {@link EXIF_STRING} this is a string of the form
     * 'YYYY:MM:DD hh:mm:ss', and for {@link JULIAN_DAY_COUNT} this is a
     * floating point number where the integer part denotes the day
     * count and the fractional part denotes the time of day (0.25 means
     * 6:00, 0.75 means 18:00).
     */
    function getValue($type = self::UNIX_TIMESTAMP) {
        switch ($type) {
            case self::UNIX_TIMESTAMP:
                $seconds = $this->convertJdToUnix($this->day_count);
                if ($seconds === false)
                /* We get false if the Julian Day Count is outside the range
                 * of a UNIX timestamp. */
                return false;
                else
                return $seconds + $this->seconds;

            case self::EXIF_STRING:
                list($year, $month, $day) = $this->convertJdToGregorian($this->day_count);
                $hours   = (int)($this->seconds / 3600);
                $minutes = (int)($this->seconds % 3600 / 60);
                $seconds = $this->seconds % 60;
                return sprintf('%04d:%02d:%02d %02d:%02d:%02d',
                $year, $month, $day, $hours, $minutes, $seconds);
            case self::JULIAN_DAY_COUNT:
                return $this->day_count + $this->seconds / 86400;
            default:
                throw new PelInvalidArgumentException('Expected UNIX_TIMESTAMP (%d), ' .
                                            'EXIF_STRING (%d), or ' .
                                            'JULIAN_DAY_COUNT (%d) for $type, '.
                                            'got %d.',
                self::UNIX_TIMESTAMP,
                self::EXIF_STRING,
                self::JULIAN_DAY_COUNT,
                $type);
        }
    }


    /**
     * Update the timestamp held by this entry.
     *
     * @param int the timestamp held by this entry in the correct form
     * as indicated by the third argument. For {@link UNIX_TIMESTAMP}
     * this is an integer counting the number of seconds since January
     * 1st 1970, for {@link EXIF_STRING} this is a string of the form
     * 'YYYY:MM:DD hh:mm:ss', and for {@link JULIAN_DAY_COUNT} this is a
     * floating point number where the integer part denotes the day
     * count and the fractional part denotes the time of day (0.25 means
     * 6:00, 0.75 means 18:00).
     *
     * @param int the type of the timestamp. This must be one of
     * {@link UNIX_TIMESTAMP}, {@link EXIF_STRING}, or
     * {@link JULIAN_DAY_COUNT}.
     */
    function setValue($timestamp, $type = self::UNIX_TIMESTAMP) {
        #if (empty($timestamp))
        #  debug_print_backtrace();

        switch ($type) {
            case self::UNIX_TIMESTAMP:
                $this->day_count = $this->convertUnixToJd($timestamp);
                $this->seconds   = $timestamp % 86400;
                break;

            case self::EXIF_STRING:
                /* Clean the timestamp: some timestamps are broken other
                 * separators than ':' and ' '. */
                $d = preg_split('/[^0-9]+/', $timestamp);
                $this->day_count = $this->convertGregorianToJd($d[0], $d[1], $d[2]);
                $this->seconds   = $d[3]*3600 + $d[4]*60 + $d[5];
                break;

            case self::JULIAN_DAY_COUNT:
                $this->day_count = (int)floor($timestamp);
                $this->seconds = (int)(86400 * ($timestamp - floor($timestamp)));
                break;

            default:
                throw new PelInvalidArgumentException('Expected UNIX_TIMESTAMP (%d), ' .
                                            'EXIF_STRING (%d), or ' .
                                            'JULIAN_DAY_COUNT (%d) for $type, '.
                                            'got %d.',
                self::UNIX_TIMESTAMP,
                self::EXIF_STRING,
                self::JULIAN_DAY_COUNT,
                $type);
        }

        /* Now finally update the string which will be used when this is
         * turned into bytes. */
        parent::setValue($this->getValue(self::EXIF_STRING));
    }


    // The following four functions are used for converting back and
    // forth between the date formats. They are used in preference to
    // the ones from the PHP calendar extension to avoid having to
    // fiddle with timezones and to avoid depending on the extension.
    //
    // See http://www.hermetic.ch/cal_stud/jdn.htm#comp for a reference.

    /**
     * Converts a date in year/month/day format to a Julian Day count.
     *
     * @param int $year  the year.
     * @param int $month the month, 1 to 12.
     * @param int $day   the day in the month.
     * @return int the Julian Day count.
     */
    function convertGregorianToJd($year, $month, $day) {
        // Special case mapping 0/0/0 -> 0
        if ($year == 0 || $month == 0 || $day == 0)
        return 0;

        $m1412 = ($month <= 2) ? -1 : 0;
        return floor(( 1461 * ( $year + 4800 + $m1412 ) ) / 4) +
        floor(( 367 * ( $month - 2 - 12 * $m1412 ) ) / 12) -
        floor(( 3 * floor( ( $year + 4900 + $m1412 ) / 100 ) ) / 4) +
        $day - 32075;
    }

    /**
     * Converts a Julian Day count to a year/month/day triple.
     *
     * @param int the Julian Day count.
     * @return array an array with three entries: year, month, day.
     */
    function convertJdToGregorian($jd) {
        // Special case mapping 0 -> 0/0/0
        if ($jd == 0)
        return array(0,0,0);

        $l = $jd + 68569;
        $n = floor(( 4 * $l ) / 146097);
        $l = $l - floor(( 146097 * $n + 3 ) / 4);
        $i = floor(( 4000 * ( $l + 1 ) ) / 1461001);
        $l = $l - floor(( 1461 * $i ) / 4) + 31;
        $j = floor(( 80 * $l ) / 2447);
        $d = $l - floor(( 2447 * $j ) / 80);
        $l = floor($j / 11);
        $m = $j + 2 - ( 12 * $l );
        $y = 100 * ( $n - 49 ) + $i + $l;
        return array($y, $m, $d);
    }

    /**
     * Converts a UNIX timestamp to a Julian Day count.
     *
     * @param int $timestamp the timestamp.
     * @return int the Julian Day count.
     */
    function convertUnixToJd($timestamp) {
        return (int)(floor($timestamp / 86400) + 2440588);
    }

    /**
     * Converts a Julian Day count to a UNIX timestamp.
     *
     * @param int $jd the Julian Day count.

     * @return mixed $timestamp the integer timestamp or false if the
     * day count cannot be represented as a UNIX timestamp.
     */
    function convertJdToUnix($jd) {
        $timestamp = ($jd - 2440588) * 86400;
        if ($timestamp != (int)$timestamp)
        return false;
        else
        return $timestamp;
    }

}


/**
 * Class for holding copyright information.
 *
 * The Exif standard specifies a certain format for copyright
 * information where the one {@link PelTag::COPYRIGHT copyright
 * tag} holds both the photographer and editor copyrights, separated
 * by a NULL character.
 *
 * This class is used to manipulate that tag so that the format is
 * kept to the standard.  A common use would be to add a new copyright
 * tag to an image, since most cameras do not add this tag themselves.
 * This would be done like this:
 *
 * <code>
 * $entry = new PelEntryCopyright('Copyright, Martin Geisler, 2004');
 * $ifd0->addEntry($entry);
 * </code>
 *
 * Here we only set the photographer copyright, use the optional
 * second argument to specify the editor copyright.  If there is only
 * an editor copyright, then let the first argument be the empty
 * string.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
class PelEntryCopyright extends PelEntryAscii {

    /**
     * The photographer copyright.
     *
     * @var string
     */
    private $photographer;

    /**
     * The editor copyright.
     *
     * @var string
     */
    private $editor;


    /**
     * Make a new entry for holding copyright information.
     *
     * @param string the photographer copyright.  Use the empty string
     * if there is no photographer copyright.
     *
     * @param string the editor copyright.  Use the empty string if
     * there is no editor copyright.
     */
    function __construct($photographer = '', $editor = '') {
        parent::__construct(PelTag::COPYRIGHT);
        $this->setValue($photographer, $editor);
    }


    /**
     * Update the copyright information.
     *
     * @param string the photographer copyright.  Use the empty string
     * if there is no photographer copyright.
     *
     * @param string the editor copyright.  Use the empty string if
     * there is no editor copyright.
     */
    function setValue($photographer = '', $editor = '') {
        $this->photographer = $photographer;
        $this->editor       = $editor;

        if ($photographer == '' && $editor != '')
        $photographer = ' ';

        if ($editor == '')
        parent::setValue($photographer);
        else
        parent::setValue($photographer . chr(0x00) . $editor);
    }


    /**
     * Retrive the copyright information.
     *
     * The strings returned will be the same as the one used previously
     * with either {@link __construct the constructor} or with {@link
     * setValue}.
     *
     * @return array an array with two strings, the photographer and
     * editor copyrights.  The two fields will be returned in that
     * order, so that the first array index will be the photographer
     * copyright, and the second will be the editor copyright.
     */
    function getValue() {
        return array($this->photographer, $this->editor);
    }


    /**
     * Return a text string with the copyright information.
     *
     * The photographer and editor copyright fields will be returned
     * with a '-' in between if both copyright fields are present,
     * otherwise only one of them will be returned.
     *
     * @param boolean if false, then the strings '(Photographer)' and
     * '(Editor)' will be appended to the photographer and editor
     * copyright fields (if present), otherwise the fields will be
     * returned as is.
     *
     * @return string the copyright information in a string.
     */
    function getText($brief = false) {
        if ($brief) {
            $p = '';
            $e = '';
        } else {
            $p = ' ' . Pel::tra('(Photographer)');
            $e = ' ' . Pel::tra('(Editor)');
        }

        if ($this->photographer != '' && $this->editor != '')
        return $this->photographer . $p . ' - ' . $this->editor . $e;

        if ($this->photographer != '')
        return $this->photographer . $p;

        if ($this->editor != '')
        return $this->editor . $e;

        return '';
    }
}

