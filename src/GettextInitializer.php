<?php
/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 * Copyright (C) 2015 Johannes Weberhofer
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
 * Initialize Gettext, if available. This must be done before any
 * part of PEL calls Pel::tra() or Pel::fmt() --- this is ensured if
 * every piece of code using those two functions require() this file.
 * If Gettext is not available, wrapper functions will be created,
 * allowing PEL to function, but without any translations.
 * The PEL translations are stored in './locale'. It is important to
 * use an absolute path here because the lookups will be relative to
 * the current directory.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

if (function_exists('dgettext')) {
    bindtextdomain('pel', __DIR__ . '/locale');
} else {
    /**
     * Pretend to lookup a message in a specific domain.
     *
     * This is just a stub which will return the original message
     * untranslated. The function will only be defined if the Gettext
     * extension has not already defined it.
     *
     * @param string $domain
     *            the domain.
     *
     * @param string $str
     *            the message to be translated.
     *
     * @return string the original, untranslated message.
     */
    function dgettext($domain, $str)
    {
        return $str;
    }
}
