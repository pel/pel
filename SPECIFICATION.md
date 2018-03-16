# PEL Specification

Version 0.9 Draft

This document describes PEL implementation of the catalog of the EXIF components (IFDs and TAGs) it supports.

This specification intends to help maintainers and contributors to correctly use the provided information for obtaining appropriate information from the PEL library.
Furthermore, it is the basis for discussions on evolving the project.

## EXIF information structure

This document assumes you are familiar with the inner structure of the files that support EXIF information. A valuable read is at
the [EXIF](https://en.wikipedia.org/wiki/Exif) entry on Wikipedia.org. The one-stop shop for detailed information about Exif tags data
is at [ExifTool by Phil Harvey](http://owl.phy.queensu.ca/~phil/exiftool/TagNames/index.html).

## PEL specification

The PEL specification is built as a collection of YAML files. Each YAML file describes a single IFD, with its basic information (IFD type, etc.) and the information
for all the TAGs contained within.
In order to minimize processing at runtime, the set of YAML files is pre-compiled into a single `spec.php` PHP file that PEL then includes at runtime.
The default specification YAML files can be found in the `\spec` subdirectory. The compiled version is at `\resources\spec.php`.
Developers can add IFDs and their corresponding TAGs to the default specification and submit GitHub pull requests to have them merged,
but can also opt-out from the default specification and write their own for their projects.

## IFD - `ifd_[type].yaml` format

An IFD is fully described by a single YAML file. The file name should conventionally follow a `ifd_[type].yaml` pattern, where the
[type] is the value of the 'type' key below, or of one of its aliases. The structure of the file is as follows:

```
const: 0
type: '0'
class: PelIfd
alias:
  - 'IFD0'
  - 'Main'
tags:
    0x0100:
        const: IMAGE_WIDTH
        name: ImageWidth
        title: 'Image Width'
        components: 1
        format: [Short, Long]
```

The file includes some properties specific to the IFD itself, and the collection of TAGs that are expected to be
found in that IFD.

| Key        | Description                                                                                           |
| ---------- | ----------------------------------------------------------------------------------------------------- |
| const      | (Legacy) An integer identifying the IFD, corresponding to the constant values found in the `PelIfd` class, like `const IFD0 = 0;`. This will be dropped in a future version of PEL. |
| type       | A string identifying the IFD type. |
| class      | A string identifying the IFD's PHP class to be used to process the IFD information. |
| postLoad   | (Optional) An array of callbacks to be fired at the end of the IFD loading process. |
| alias      | (Optional) An array of strings alternatively identifying the IFD type. |
| tags       | An array of TAGs (see below). |
| makerNotes | (Optional) If the IFD is relative to custom manufacturer notes, this array of string specifies the values of the EXIF/MakerNote TAG that will match this type of maker notes. |

## TAG format

An TAG entry is an array describing a single EXIF tag. The structure of the array is as follows:

```
    0x0106:
        const: PHOTOMETRIC_INTERPRETATION
        name: PhotometricInterpretation
        title: 'Photometric Interpretation'
        components: 1
        format: Short
        text:
            mapping:
                2: 'RGB'
                6: 'YCbCr'
```

The TAG entry is identified by the HEX value of the EXIF tag, like `0x0106` in the example above.

| Key        | Description                                                                                           |
| ---------- | ----------------------------------------------------------------------------------------------------- |
| const      | (Legacy) A string identifying the TAG constant defined in the `PelTag` class, like `PHOTOMETRIC_INTERPRETATION` in the example above. This will be dropped in a future version of PEL. |
| name       | A string identifying the TAG short name. |
| title      | A string with a description of the TAG. |
| components | (Optional) An integer describing the exepcted number of data components in the TAG. |
| format     | (Optional) A string/array of strings identifying the expected data format of the tag. |
| class      | (Optional) A string identifying the TAG's PHP class. If not specified, the default class for the TAG format will be used. |
| ifd        | (Optional) If specified, identifies the TAG as a pointer to a sub-IFD, as the string of the relative IFD type.  |
| text       | (Optional) If specified, instructs PEL to decode the value of the TAG to a text string. This can be done either as a mapping between the value and the text (defined by the `mapping:` array), or by calling a callback method (indicated by the `decode:` key). |

## `pel compile` command

The `pel compile` command, found in the `\bin` subdirectory, is used to compile the YAML specification files in a PHP file used by PEL at runtime.

By default, `pel compile` will compile the specification contained in `\spec` to `\resources\spec.php`.

The full usage is as follows:
```
Usage:
  pel compile [<spec-dir>] [<resource-dir>]
Arguments:
  spec-dir              Path to the directory of the .yaml specification files
  resource-dir          Path to the directory of the spec.php file
```

It is possible to specify `<spec-dir>` only, in which case the compiled specification will be saved to `\resources\spec.php`. If also
`<resource-dir>` is specified, then the compiled specification will be saved to `<resource-dir>\spec.php`.

## Overriding the default specification at runtime

By default, the PEL library will use the specification found in `\resources\spec.php`. It is possible to indicate a different specification
to be used with the following code:

```php
...
use lsolesen\pel\PelSpec;
...

class MyClass
{
    public function myMethod()
    {
        ...
        PelSpec::setMap('my_resources/spec.php');
        $ifd_types = PelSpec::getIfdTypes();
        ...
    }
}
```
