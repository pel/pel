#!/usr/bin/php
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
error_reporting(E_ALL);

require_once dirname(dirname(__FILE__)) . '/autoload.php';
require_once dirname(dirname(__FILE__)) . '/vendor/lastcraft/simpletest/unit_tester.php';
require_once dirname(dirname(__FILE__)) . '/vendor/lastcraft/simpletest/reporter.php';

if (! empty($argc) and $argc > 1) {
    // If command line arguments are given, then only test those.
    array_shift($argv);
    $tests = $argv;
    $group = new TestSuite('Selected PEL tests');
} else {
    // otherwive test all .php files, except this file (run-tests.php).
    $tests = array_diff(glob(__DIR__ . '/*.php'), array(
        __DIR__ . '/run-tests.php',
        __DIR__ . '/config.local.php',
        __DIR__ . '/config.local.example.php'
    ));
    $group = new TestSuite('All PEL tests');

    // Also test all image tests (if they are available).
    if (is_dir(dirname(__FILE__) . '/image-tests')) {
        $image_tests = array_diff(glob(dirname(__FILE__) . '/image-tests/*.php'), array(
            dirname(__FILE__) . '/image-tests/make-image-test.php'
        ));
        $image_group = new TestSuite('Image Tests');
        foreach ($image_tests as $image_test) {
            $image_group->addFile($image_test);
        }

        $group->add($image_group);
    } else {
        echo "Found no image tests, only core functionality will be tested.\n";
        echo "Image tests are available from http://github.com/lsolesen/pel/.\n";
    }
}

foreach ($tests as $test) {
    $group->addFile($test);
}
$group->run(new TextReporter());
