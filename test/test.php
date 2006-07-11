#!/usr/bin/php
<?php

/*  PEL: PHP Exif Library.  A library with support for reading and
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

error_reporting(E_ALL);

/* This assumes that SimpleTest is installed in a directory parallel
 * to the PEL directory. */
define('SIMPLE_TEST', '../../simpletest/');

if (!is_dir(SIMPLE_TEST)) {
  printf("The directory SimpleTest directory (%s) does not exist \n" .
         "and so no tests can be made.\n" .
         "Please download SimpleTest from http://simpletest.sf.net/\n" .
         "and unpack it in the directory mentioned above.\n", SIMPLE_TEST);
  exit(1);
}

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

if ($argc > 1) {
  array_shift($argv);
  $tests = $argv;
  $group = new GroupTest('Selected PEL tests');
} else {
  $tests = array_diff(glob('*.php'), array('test.php'));
  $group = new GroupTest('All PEL tests');
}

foreach ($tests as $test)
  $group->addTestFile($test);

if ($argc == 1) {
  if (is_dir('image-tests')) {
    $image_tests = array_diff(glob('image-tests/*.php'),
                              array('image-tests/make-image-test.php'));
    $image_group = new GroupTest('Image Tests');
    foreach ($image_tests as $image_test)
      $image_group->addTestFile($image_test);
    
    $group->addTestCase($image_group);
  } else {
    echo "Found no image tests, only core functionality will be tested.\n";
    echo "Image tests are available from http://pel.sourceforge.net/.\n";
  }
}

$group->run(new TextReporter());

?>