# README file for PEL Examples

## PEL Examples

This directory contains various examples of how PEL can be used in
small scripts.  The scripts are meant to be executed from the command
line and they assume that you have PHP installed as /usr/bin/php.  If
that is not the case, then please adjust the first line before
executing the scripts, or simply execute them as

```
% php <script> <arguments>
```

and let your shell find the PHP executable.

The examples are:

* dirsort.php: an example of how to use PEL to automatically sort a
  collection of photos into different folders.

  The script accepts a number of filenames on the command line, and
  will move them to folders based on the month the photo was taken.

* dump-image.php: a simple script that will load an image and show the
  structure.

  A JPEG or TIFF image should be specified on the command line.  The
  dump will give detailed information about the structure in the
  image.

* edit-description.php: a big example showing how to update the
  ImageDescription Exif tag using PEL.

  The script is heavely commented, and should be used as a good
  reference as to how PEL works and how it should be used.

* gps.php: shows how to add GPS information to an image using PEL.

* rename.php: a script similar to dirsort.php, only that this one will
  rename photos to a filename containing the full date and time taken
  from the DateTime Exif tag.

* resize.php: a script to resize images.


## Contributing New Examples

More examples are needed!  If you have a neat example of how PEL can
be used, then please contribute it to PEL.  Please submit it as a new
item in the Github issue tracker:

  http://github.com/lsolesen/pel/issues

Or issue a pull request. It will then be included in the next release
of PEL, of course with full credit in the AUTHORS file.
