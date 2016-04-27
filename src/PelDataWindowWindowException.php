<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */
namespace lsolesen\pel;

/**
 * A container for bytes with a limited window of accessible bytes.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * An exception thrown when an invalid window is encountered.
 *
 * @package PEL
 * @subpackage Exception
 */
class PelDataWindowWindowException extends PelException
{
}
