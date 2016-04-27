#!/usr/bin/php
<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
 *
 * Dual licensed. For the full copyright and license information, please view
 * the COPYING.LESSER and COPYING files that are distributed with this source code.
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
