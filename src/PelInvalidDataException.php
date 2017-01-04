<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005 Martin Geisler.
 *
 * For licensing, see LICENSE.md distributed with this source code.
 */
namespace lsolesen\pel;

use lsolesen\pel\PelException;

/**
 * Standard PEL exception.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */

/**
 * Exception throw if invalid data is found.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 * @subpackage Exception
 */
class PelInvalidDataException extends PelException
{
}
