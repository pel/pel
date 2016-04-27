# INSTALL


## Requirements

PEL requires PHP version 5.


## Installation

### Composer

The preferred way of installing PEL is through composer. Simply add a
dependency on ´lsolesen/pel´ to your projects composer.json.

    {
        "require": {
            "lsolesen/pel": "0.9.*"
        }
    }

For a system-wide installation via Composer, you can run:

    composer global require "lsolesen/pel=0.9.*"


### Clone via git

You can also use git to install it using:

  git clone git://github.com/lsolesen/pel.git
  git checkout <tag name>

Finally, you can install PEL by extracting it to a local directory. You can find
the compressed files here: https://github.com/lsolesen/pel/downloads.

Make sure that you extract the files to a path included in your include path:
You can set the include path using.

  set_include_path('/path/to/pel' . PATH_SEPARATOR . get_include_path());


## Upgrading

If you have already been using a previous version of PEL, then be sure
to read the CHANGELOG.md file before starting with a new version.


## Using PEL

Your application should include PelJpeg.php or PelTiff.php for working
with JPEG or TIFF files.  The files will define the PelJpeg and
PelTiff classes, which can hold a JPEG or TIFF image, respectively.
Please see the API documentation in the doc directory or online at

  http://lsolesen.github.com/pel/doc/

for the full story about those classes and all other available classes
in PEL.

Still, an example would be good.  The following example will load a
JPEG file given as a command line argument, parse the Exif data
within, change the image description to 'Edited by PEL', and finally
save the file again.  All in just six lines of code:

  ```php5
  <?php
  require_once('PelJpeg.php');

  $jpeg = new PelJpeg($argv[1]);
  $ifd0 = $jpeg->getExif()->getTiff()->getIfd();
  $entry = $ifd0->getEntry(PelTag::IMAGE_DESCRIPTION);
  $entry->setValue('Edited by PEL');
  $jpeg->saveFile($argv[1]);
  ?>
  ```

See the examples directory for this example (or rather a more
elaborate version in the file edit-description.php) and others as PHP
files.  You may have to adjust the path to PHP, found in the very
first line of the files before you can execute them.


## Changing PEL

If you find a bug in PEL then please send a report back so that it can
be fixed in the next version.  You can submit your bugs and other
requests here:

  http://github.com/lsolesen/pel/issues

If you change the code (to fix bugs or to implement enhancements), it
is highly recommended that you test your changes against known good
data.  Please see the test/README.md file for more information about
running the PEL test suite.
