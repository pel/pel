# README file for PEL Test Suite

The tests run automatically on each commit on TravisCI. Status for the
master branch is:

[![Build Status](https://secure.travis-ci.org/pel/pel.png?branch=master)](http://travis-ci.org/pel/pel)


## PEL Test Suite

This directory holds the PHPUnit test suite for PEL. The test
suite consists of a number of core tests which exercise the basic
functionality of PEL.

In addition to the core tests, one can download a set of image tests.
These consist of example images taken from as many different camera
models as possible together with a test case that will ensure that PEL
can read the data in the image, and that it keeps interpreting the
data in the same way.  This ensures stability in the development
process by making sure that PEL keeps reading images in the same way.


## Running the Test Suite

First the make sure PHPUnit is downloaded. You can do so in
the project's top directory via composer

```bash
composer update
```

Now from the top of the project, you can run

```bash
phpunit
```

## Failing Tests

Should one or more of the tests fail, then first ensure that
SimpleTest is placed correctly so that run-tests.php can find it. If
everything seems correct, then please report the error to the PEL
developers:

  https://github.com/lsolesen/pel/issues

Remember to include all the output in your bug report.
