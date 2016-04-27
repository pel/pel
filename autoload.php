<?php
/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2015, Johannes Weberhofer.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.MIT and COPYING.GPL files that are distributed with this source code.
 */

/**
 * Register autoloader for pel
 */
spl_autoload_register(function ($class) {
    if (substr_compare($class, 'lsolesen\\pel\\', 0, 13) === 0) {
        $classname = str_replace('lsolesen\\pel\\', '', $class);
        $load = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $classname . '.php');
        if ($load !== false) {
            include_once realpath($load);
        }
    }
});
