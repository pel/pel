PEL: PHP Exif Library
=====================

[![Build Status](https://secure.travis-ci.org/lsolesen/pel.png?branch=master)](http://travis-ci.org/lsolesen/pel) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lsolesen/pel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lsolesen/pel/?branch=master) [![Latest Stable Version](https://poser.pugx.org/lsolesen/pel/v/stable)](https://packagist.org/packages/lsolesen/pel) [![Total Downloads](https://poser.pugx.org/lsolesen/pel/downloads)](https://packagist.org/packages/lsolesen/pel) [![License](https://poser.pugx.org/lsolesen/pel/license)](https://packagist.org/packages/lsolesen/pel)

README file for PEL: PHP Exif Library.  A library with support for
reading and writing Exif headers in JPEG and TIFF images using PHP.

Copyright (C) 2004, 2005, 2006  Martin Geisler.
Licensed under the GNU GPL, see COPYING for details.


Description
***********

The PHP Exif Library (PEL) makes it easy to develop programs that will
read and write the Exif metadata headers found in JPEG and TIFF
images.  See the file INSTALL for an introduction to how PEL can be
used by your application.

PEL is a library written entirely in PHP 5, which means that it does
not have any dependencies outside the core of PHP, it does not even
use the Exif module available for PHP.

Please note that the API for PEL is not yet frozen, and it will remain
changeable until version 1.0 is reached. Read the NEWS file for
important information about API changes.

Also, please go to the PEL development mailing list (look below) and
share your ideas about how the API should look like.


Documentation Overview
**********************

* README: gives you a short introduction to PEL (this file).
* INSTALL: explain how to install and get going with PEL.
* NEWS: contains important information about changes in PEL.
* examples/: small self-contained examples of how to use PEL.
* AUTHORS: list of people who have helped.
* run run-phpdoc.sh to generate API-documention or see it online at http://lsolesen.github.com/pel

Features of PEL
***************

* Reads and writes Exif metadata from both JPEG and TIFF images.
* Supports reading and writing all Exif tags.
* Supports internationalization.
* Extensible object-oriented design.
* Unit-tested with SimpleTest (http://sf.net/projects/simpletest).
* Documented with PhpDocumentor (http://phpdoc.org/).


Helping out
***********

Help will be very much appreciated. You can report issues, run the test
suite, add patches. The best way to help out is applying patches and
helping out with the tests. See instructions in the test/ directory.


Languages
*********

To work with the translations, you need the gettext package installed.


Getting Support
***************

The first place you should consult for support is the documentation
supplied with PEL, found in the doc/ directory.  There you will find a
complete API documentation with descriptions of all classes and files
in PEL.

The scripts found in the examples/ directory are also a good source of
information, especially the edit-description.php file which has tons
of comments.

PEL is hosted on Github and uses the tools found there for
support.  This means that all questions, bug reports, etc. should be
directed there (and not directly to the developers).

Please try the latest version before reporting bugs -- it might have
been fixed already.  The latest code can be found in the git
repository at

  http://github.com/lsolesen/pel

It is very helpful if you try out the latest code from the git
repository before submitting a bug report. The code found there is
generally very stable.


Contributing Test Images
************************

To make PEL as stable as possible, it is tested with images from a
number of different camera models.

New test images are very much appreciated -- please download the
existing test images and read the README file found there for
instructions.


Credits
*******

Please see the AUTHORS file for a list of people who have contributed
to PEL.
