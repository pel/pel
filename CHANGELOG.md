# CHANGELOG

## 0.9.8 - 2020-02-11

* Improved PHP 7.4 compatibility
* Improved TIFF handling

## 0.9.7 - 2019-12-03

Fixes some errors, refactor code and make compatible to PHP 7.4.

* Simplify phpunit dependency (#143)
* Updates in the README (#139, #137, #108)
* TravisCI tests up to PHP 7.4 and fix PHP 7.4 syntax (#142)
* XP tags fixed (#115)
* Improve IFD type names for Canon Maker Notes (#124)
* Move non-camera specific tests from /test/imagetests to /test (#123)
* Refactor ReadWriteTest and fix NumberTest (#122)
* Clean up the code and all the tests to match coding standards (#121)
* Convert to new array syntax (PHP 5.4) (#120)
* Update tests to run under PHPUnit 6+ and backwards to PHP 5.5 and 5.4 (#118)
* Catch DataWindow exceptions in PelIfd (#114)
* Fix several types (#113)
* Fix static makerNotes in PelIfd (#112)
* Fixes for [pel-Bugs-2979466 ] endless loop in PelIfd->load (#110)
* Fix build status badge (#111)
* Fix skipped tests for PHP 7.1+ (#109)
* Parsing canon maker notes (#99)
* Exif section corrections (#101)
* Enabled code rating (#106)
* Changed access of the $sections property to allow section manipulations in subclasses. (#104)
* Now available from PEL organization (#97)
* Enable PHP 7.2 build on TravisCI (#102)
* Rating percent tag (#100)
* Add composer installation instructions (#96)
* HHVM needs to run on Trusty (#95)
* Added reverse lookup methods, fixed PHPDOC for PelTag enumerations (#93)

## 0.9.6 - 2017-02-03

* Trim null characters from the end of ascii fields only when available. Fixes #77 

## 0.9.5 - 2017-01-31

This release improves the code quality and the test coverage.
New features:

* new method PelTiff::saveFile()
* PHP 7.1 compatibility

## 0.9.4 - 2016-03-21

Notes:

This is mainly a cleanup version and better composer integration.
We added Scrutinizer, which should make sure that the code improves
in the future.

Changes:

* Improved performance of PelJpeg.

* Fixed wrong usage of private variable in examples.


## 0.9.3 - 2015-08-08

Notes:

This is a major update, and should have been the first tag of the
0.10.0 series. If you want to use the latest stable version without
namespaces, you should use 0.9.2.

Changes:

* Introduced namespaces.

* Added composer support and made it available on
  [packagist.org](https://packagist.org/packages/lsolesen/pel) and
  introduced PSR-4 autoloader.

* Major cleanup of the code and following PSR-2 standards.


## 0.9.2 - 2010-03-09

Notes:

This release is the last release before introducing namespaces.

Added a static method, Pel::setJPEGQuality(), for controlling the
quality for encoding JPEG images. Fixed bug in conversion between
Julian Day count and UNIX timestamps and removed dependency on the
calendar PHP extension. Fixed placement of Windows XP tags. Added GPS
example.

Changes:

* Added an example of how GPS information can be added. Thanks Andac
  Aydin for contributing and testing this.

* Fixed PelJpegComment::getBytes(): it didn't return anything! Thanks
  macondos.

* Fixed SF bug #1699489: Incorrect UNIX/Julian conversion.

* PEL 0.9.1 introduced a dependency on the calendar extension for PHP.
  The necessary functions have now been reimplemented in pure PHP. The
  patch was supplied by Francois Pirsch, thanks.

* Fixed doc comment for PelEntryTime, the variables for date() was
  swapped. Thanks Francois Pirsch.

* Added static Pel::setJPEGQuality() and Pel::getJPEGQuality() method
  for setting and getting the quality used when PelJpeg automatically
  converts an image resource to a JPEG image. Thanks Csaba Gabor for
  asking about this.

* Moved the XP specific tags from the Exif IFD to the IFD0/1 IFD.
  Thanks Piotr Golebiowski for noticing this.

* Added links from PelTag::XP_* tags to the PelEntryWindowsString
  class. Thanks Garrison Locke for indirectly pointing out the need
  for this.


## 0.9.1 - 2016-12-19

Notes:

Added setExif(), getExif(), and clearExif() methods as a convenient
and recommended way of manipulating the Exif data in a PelJpeg object.
Improved PelEntryTime to deal with timestamps in the full range from
year 0 to year 9999. Removed PelTag::getDescription() because the
descriptions were out of context. A new example demonstrates how to
resize images while keeping the Exif data intact. Added a Japanese and
updated the French and Danish translations.

Changes:

* The constructors of PelJpeg and PelTiff can now take an argument
  which is used for initialization. This can be a filename (equivalent
  to calling loadFromFile()), a PelDataWindow (equivalent to load()).
  The PelJpeg constructor will also accept an image resource.

* Added PelJpeg::setExif(). This method should always be used in
  preference to PelJpeg::insertSection() and PelJpeg::appendSection().
  One should actually not be using appendSection() unless one is very
  sure that the image has not been ended by a EOI marker.

* Added PelJpeg::getExif().  This method is the new preferred way of
  obtaining the PelExif object from a PelJpeg object.  Updated the
  examples and code to make use of it.

* An example of how to resize images while keeping the Exif data
  intact is given in resize.php.

* The PelTag::getDescription() method is no more. The descriptions
  were taken directly from the Exif specification and they were often
  impossible to translate in a meaningful out of context because they
  had references to figures and tables from said specification.

* Fixed bug in edit-description.php which still called the constructor
  of PelIfd in the old pre-0.9 way.

* Updated documentation of PelIfd to make it clearer that it can be
  used as an array because it implements the ArrayAccess SPL (Standard
  PHP Library) interface.

* Added Japanese translation by Tadashi Jokagi.

* Update by David Lesieur of the French translation.

* Rewrote entry for version 0.9 in NEWS to highlight the API
  incompatible changes made from version 0.8.

* Renamed test.php to run-tests.php and implemented a simple search
  functionality for finding the SimpleTest installation.

* Rewrote make-release.sh script to work with Subversion.

## 0.9.0 - 2006-01-08

Notes:

Added full support for GPS information (this breaks API compatibility
with version 0.8), JPEG comments, the Gamma tag, and Windows XP
specific title, comment, author, keywords, and subject tags.
Implemented a non-strict mode for broken images where most errors wont
result in visible exceptions.  The edit-description.php example now
correctly deals with images with no previous Exif data.  A partial
Polish translation was added. The API documentation was updated with
details about the constrains on format and number of components for
each tag.

API incompatible changes:

* Changed PelIfd::getSubIfd() to take an IFD type as argument instead
  of a PelTag.  The IFD types are constants in PelIfd.  So use

    $exif = $ifd0->getSubIfd(PelIfd::EXIF);

  instead of

    $exif = $ifd0->getSubIfd(PelTag::EXIF_IFD_POINTER);

  in your code.

* Added support for the GPS IFD.  This API break compatibility with
  version 0.8.  The problem is that the GPS related tags have the same
  value as some other tags, and so the function PelTag::getName(),
  PelTag::getTitle(), and PelTag::getDescription() has been changed to
  take an extra argument specifying IFD type of the tag.

  This might change very well further in the future.

Changes:

* Added support for JPEG comments through the PelJpegComment class
  which works almost like PelEntry (use getValue() and setValue() to
  read and write the comment).

* Enabled iterating a PelIfd object with foreach().  It will iterate
  over (PelTag, PelEntry) pairs.

* Added PelIfd::getValidTags() which return an array of tags valid for
  the IFD in question.  Using this, PEL now reject entries in wrong
  IFDs.  For example, you cannot have a UserComment tag in a IFD for
  GPS information.

* Added a new concept of strict/non-strict mode.  The old behavior
  was strict mode where an errors would abort the loading of an image
  because of exceptions --- in non-strict mode most exceptions will be
  trapped and broken images can still be loaded.  See the description
  in Pel.php and the answer in the FAQ for more information.

* Added support for the 0xA500 Gamma tag.

* Changed paths in example shell scripts to /usr/bin/php and explained
  in the README how to execute them.

* Updated FAQ with information about making Gettext work and the new
  strict/non-strict mode.

* Added support for Windows XP specific title, comment, author,
  keywords, and subject tags.  These tags can be edited in Windows XP
  in the Properties dialog found by right-clicking on an image.

* A number of translations in the German, French, and Spanish
  translations were inactive because of small differences between PHP
  and C (such as using %d and %i in format strings).

* Added Polish translation by Jakub Bogusz from the libexif project.

* Corrected tag documentation in PelTag.

* Made edit-description.php correctly add an empty Exif structure in
  case the original image has none.

* Removed PelJpegContent::getSize() method.  Calling this method in
  the PelExif subclass resulted in an error, and overriding it
  correctly in PelExif would have required too much code to justify
  the effort.

* Better doc comments and small code cleanups in PelJpeg.php,
  PelExif.php, and PelIfd.php.

* PelEntry.php now unconditionally includes the class definitions of
  all the entry types.  The conditionally loading only worked when one
  created a new PelJpeg object, but not when one had stored such an
  object in, say, a session.

* Moved PelEntry::newFromData() to PelIfd::newEntryFromData() since it
  needs knowledge about PelIfd::$type.  Updated the documentation it
  to indicate that one shouldn't use this method unless the data comes
  directly from an image.  The method signature was corrected with a
  type hint, so that $data really is a PelDataWindow.

* Updated the documentation in PelTag.  All tags now details their
  expected format and the expected number of components.  One can
  still freely choose to obey or disregard these constrains, but doing
  so will lead to non-compliant images, which might cause PEL to throw
  exceptions when reloading.

* Updated the documentation in PelFormat with links to the PelEntry
  classes corresponding to each format.

* Updated the make-release.sh script to use a run-phpdoc.sh script for
  generating the API documentation.


## 0.8.0 - 2005-02-18

Notes:

Erroneous entries will now be skipped while loading instead of causing
a total abort.  The documentation was expanded with a short tutorial
and a FAQ.  New test images were added from Leica D-LUX, Olympos C50Z
and C765 cameras.

Changes:

* Added more documentation in the form of a short tutorial and a FAQ.

* Instead of aborting on load errors, PelIfd::load() will now continue
  with the next entry.  A warning will be issued if debugging is
  turned on in PEL.

* Added a PelEntryException class.  When an entry cannot be loaded in
  PelEntry::newFromData(), an appropriate subclass of this exception
  will be thrown.

* Described the requirements in terms of formats and component counts
  in the documentation for individual tags in PelTag.

* Fixed the edit-description.php example, it still used PelEntryString
  instead of PelEntryAscii.  Thanks goes to Achim Gerber.

* Fixed the throwing of a PelWrongComponentCountException in PelEntry,
  the class name was misspelled.

* Added abstract getValue() and setValue() methods to PelEntry, to
  better describe that all objects representing Exif entries have
  those two methods.

* Updated copyright statements throughout the source to year 2005.

* Fixed (some) of the XHTML errors in the phpDocumentor template.


## 0.7.0 - 2004-10-10

Notes:

Running PEL under PHP version 5.0.2 would produce incorrect Exif data,
this was fixed so that PEL works correctly on all versions of PHP 5.
PEL now runs on installations without support for Gettext, but does so
with English texts only.  A new example script was added, showing how
one can mass-rename images based on their timestamps using PEL.  The
Danish translation was updated slightly.  The collection of test
images has been split out as a separate download, cutting down on the
size of a PEL download.

Changes:

* The image tests are now split into their own, separate download.

* Added a test image from a Canon PowerShot S60.

* Fixed a bug caused by a change in the way PHP 5.0.2 handles integers
  larger than 2^31-1.  This change means that one can no longer use
  PelConvert::longToBytes() to convert both signed and unsigned bytes,
  one must now use sLongToBytes() for signed longs and longToBytes()
  for unsigned bytes.

* Added a work-around, so the PEL will run (with English texts only)
  on installations without support for Gettext.

* Added test/rename.php which shows how one can easily rename images
  based on their Exif timestamps.

* Updated the Danish translation.

* Removed trailing newlines at the end of Pel.php and PelConvert.php.


## 0.6 - 2004-07-21

Notes:

The interface for PelJpeg and PelTiff was changed so that one can now
add new content from scratch to JPEG and TIFF images.  Bugs in the
loading of signed bytes and shorts were fixed, as well as a bug where
timestamps were saved in UTC time, but loaded in local time.  The code
that turned PelJpeg objects into bytes was fixed, and new test cases
were written to test the writing and reading of PelJpeg objects to and
from files.  New images from Nikon models E950, E5000, and Coolscan IV
have been added to the test suite, bringing the total number of tests
up to more than 1000.

Changes:

* The timestamps were saved as UTC time in PelEntryTime, but loaded as
  local time in PelEntry.  This lead to differences when one tried to
  load a previously saved timestamp.

* Changed the constructors in PelJpeg, PelExif, PelTiff, and PelIfd so
  that one can now make new objects without filling them with data
  immediately.  This makes it possible to add, say, a new APP1 section
  with Exif to a JPEG image lacking such information.

* Fixed loading of signed bytes and shorts in PelConvert.

* Renamed the isValidMarker() method into just isValid() in
  PelJpegMarker, so that it matches the other isValid() methods found
  in PelJpeg and PelTiff.

* Added test images from Nikon models E950, E5000 and the film scanner
  Coolscan IV ED, and added tests that would read their contents.

* The shell scripts could only be run from the test directory because
  of the use of relative paths in the require_once() statements.  The
  scripts can now be run from any directory.

* A stupid bug that prevented PelJpeg objects from being turned into
  bytes was fixed.

* Fixed the output of PelEntryRationals::getText().


## 0.5.0 - 2004-06-28

Notes:

This release has been tested with images from a number of different
camera models (from Fujifilm, Nikon, Ricoh, Sony, and Canon), leading
to the discovery and fixing of a number of bugs.  The API for
PelJpeg::getSection() was changed slightly, making it more convenient
to use.  All classes and methods are now documented.

Changes:

* Some images have content following the EOI marker --- this would
  make PEL thrown an exception.  The content is now stored as a
  PelJpegContent object associated with the fictive marker 0x00.

* Added code to handle images where the length of the thumbnail image
  is broken.  PEL would previously throw an exception, but the length
  is now adjusted instead, and the parsing continues.

* Fixed a number of bugs regarding the conversion back and forth
  between integers and bytes.  These bugs affected the parsing of
  large integers that would overflow a signed 32 bit integer.

* Fixed bug #976782.  If an image contains two APP1 sections, PEL
  would crash trying to parse the second non-Exif section.  PEL will
  now just store a non-Exif APP1 section as a generic PelJpegContent
  object.

* Removed the PelJpegSection class.  This lead to a rewrite of the
  PelJpeg::getSection() method, so that it now takes a PelJpegMarker
  as argument instead of the section number.

* The byte order can now be specified when a PelTiff object is
  converted into bytes.

* Updated documentation, PEL is now fully documented.


## 0.4.0 - 2004-06-09

Notes:

The infrastructure for internationalization has been put in place.
Preliminary translations for Danish, German, French, and Spanish is
included.  Support for tags with GPS information were disabled due to
conflicts with a number of normal tags.

Changes:

* Disabled the code that tries to look up the title and description of
  the GPS related tags, since those tags have the same hexadecimal
  value as a number of other normal tags.  This means that there is no
  support for tags with GPS information.

* Marked strings for translation throughout the source code.

* Added German, French, and Spanish translations taken from libexif.
  The translations were made by Lutz M�ller, Arnaud Launay, and Fabian
  Mandelbaum, respectively.

* Added Danish translation.

* Added new static methods Pel::tra() and Pel::fmt() which are used
  for interaction with Gettext.  The first function simply translates
  its argument, the second will in addition function like sprintf()
  when given several arguments.

* Updated documentation, both the doc comments in the code and the
  README and INSTALL files.


## 0.3.0 - 2004-05-25

Notes:

Support was added for parsing TIFF images, leading to a mass renaming
of files and classes to cleanup the class hierarchy.  The decoding of
Exif data is now tested against known values (over 400 individual
tests), this lead to the discovery of a couple of subtle bugs.  The
documentation has been updated and expanded.

Changes:

* Renamed all files and classes so that only Exif specific code is
  labeled with Exif.  So, for example, PelExifIfd is now PelIfd, since
  the IFD structure is not specific to Exif but rather to TIFF images.
  The same applies to the former PelExifEntry* classes.

* Fixed offset bug in PelDataWindow::getBytes() which caused the
  method to return too much data.

* Added support for the SCENE_TYPE tag.

* Fixed display of integer version numbers.  Version x.0 would be
  displayed as just version 'x' before.

* Unit tests for Exif decoding.  PEL is now tested with an image from
  a Sony DSC V1 and one from a Canon IXUS II.

* Changed all occurrences of include_once() to require_once() since
  the files are required.

* Updated documentation all over.


## 0.2.0 - 2004-05-16

Notes:

This release brings updated documentation and better support for the
Exif user comment tag and tags containing version information.  The
code is now tested using SimpleTest.

Changes:

* All PelExifEntry descendant classes now use setValue() and
  getValue() methods consistently.

* Signed and unsigned numbers (bytes, shorts, longs, and rationals)
  are now handled correctly.

* The SimpleTest (http://sf.net/projects/simpletest) framework is used
  for regression testing.

* Added new PelExifEntryUserComment class to better support the Exif
  user comment tag.

* Added new PelExifEntryVersion class to support the Exif tags with
  version information, namely the EXIF_VERSION, FLASH_PIX_VERSION, and
  INTEROPERABILITY_VERSION tags.

* Updated doc comments all over.


## 0.1.0 - 2004-05-08

Notes:

The initial release of PEL.  Most of the functionality is in place:
JPEG files are parsed, Exif entries are found and interpreted, the
entries can be edited and new entries can be added, and finally, the
whole thing can be turned into bytes and saved as a valid JPEG file.

The API is still subject to change, and will remain so until version
1.0 is reached.
