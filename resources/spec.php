<?php
/**
 * This file is generated automatically by executing the 'pel compile' command.
 *
 * DO NOT CHANGE MANUALLY.
 */
return array (
  'ifds' =>
  array (
    9 => 'Canon Picture Information',
    4 => 'Interoperability',
    3 => 'GPS',
    2 => 'Exif',
    5 => 'Canon Maker Notes',
    6 => 'Canon Camera Settings',
    10 => 'Canon File Information',
    7 => 'Canon Shot Information',
    8 => 'Canon Panorama Information',
    0 => '0',
    1 => '1',
  ),
  'ifdsByType' =>
  array (
    'Canon Picture Information' => 9,
    'Interoperability' => 4,
    'Interop' => 4,
    'GPS' => 3,
    'Exif' => 2,
    'Canon Maker Notes' => 5,
    'Canon Camera Settings' => 6,
    'Canon File Information' => 10,
    'Canon Shot Information' => 7,
    'Canon Panorama Information' => 8,
    0 => 0,
    'IFD0' => 0,
    'Main' => 0,
    1 => 1,
    'IFD1' => 1,
    'Thumbnail' => 1,
  ),
  'tags' =>
  array (
    9 =>
    array (
      2 =>
      array (
        'const' => 'CANON_PI_IMAGE_WIDTH',
        'name' => 'ImageWidth',
        'title' => 'Image Width',
      ),
      3 =>
      array (
        'const' => 'CANON_PI_IMAGE_HEIGHT',
        'name' => 'ImageHeight',
        'title' => 'Image Height',
      ),
      4 =>
      array (
        'const' => 'CANON_PI_IMAGE_WIDTH_AS_SHOT',
        'name' => 'ImageWidthAsShot',
        'title' => 'Image Width As Shot',
      ),
      5 =>
      array (
        'const' => 'CANON_PI_IMAGE_HEIGHT_AS_SHOT',
        'name' => 'ImageHeightAsShot',
        'title' => 'Image Height As Shot',
      ),
      22 =>
      array (
        'const' => 'CANON_PI_AF_POINTS_USED',
        'name' => 'AFPointsUsed',
        'title' => 'AF Points Used',
      ),
      26 =>
      array (
        'const' => 'CANON_PI_AF_POINTS_USED_20D',
        'name' => 'AFPointsUsed(20D)',
        'title' => 'AF Points Used (20D)',
      ),
    ),
    4 =>
    array (
      1 =>
      array (
        'const' => 'INTEROPERABILITY_INDEX',
        'name' => 'InteroperabilityIndex',
        'title' => 'Interoperability Index',
        'components' => 4,
        'format' => 'Ascii',
      ),
      2 =>
      array (
        'const' => 'INTEROPERABILITY_VERSION',
        'name' => 'InteroperabilityVersion',
        'title' => 'Interoperability Version',
        'components' => 4,
        'format' => 'Version',
        'text' =>
        array (
          'decode' => 'PelEntryVersion::decodeInteroperabilityVersion',
        ),
      ),
      4096 =>
      array (
        'const' => 'RELATED_IMAGE_FILE_FORMAT',
        'name' => 'RelatedImageFileFormat',
        'title' => 'Related Image File Format',
        'components' => 'Unknown',
        'format' => 'Unknown',
      ),
      4097 =>
      array (
        'const' => 'RELATED_IMAGE_WIDTH',
        'name' => 'RelatedImageWidth',
        'title' => 'Related Image Width',
        'components' => 'Unknown',
        'format' => 'Unknown',
      ),
      4098 =>
      array (
        'const' => 'RELATED_IMAGE_LENGTH',
        'name' => 'RelatedImageLength',
        'title' => 'Related Image Length',
        'components' => 'Unknown',
        'format' => 'Unknown',
      ),
    ),
    3 =>
    array (
      0 =>
      array (
        'const' => 'GPS_VERSION_ID',
        'name' => 'GPSVersionID',
        'title' => 'GPSVersionID',
        'components' => 4,
        'format' => 'Byte',
      ),
      1 =>
      array (
        'const' => 'GPS_LATITUDE_REF',
        'name' => 'GPSLatitudeRef',
        'title' => 'GPSLatitudeRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      2 =>
      array (
        'const' => 'GPS_LATITUDE',
        'name' => 'GPSLatitude',
        'title' => 'GPSLatitude',
        'components' => 3,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeGPSLatitude',
        ),
      ),
      3 =>
      array (
        'const' => 'GPS_LONGITUDE_REF',
        'name' => 'GPSLongitudeRef',
        'title' => 'GPSLongitudeRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      4 =>
      array (
        'const' => 'GPS_LONGITUDE',
        'name' => 'GPSLongitude',
        'title' => 'GPSLongitude',
        'components' => 3,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeGPSLongitude',
        ),
      ),
      5 =>
      array (
        'const' => 'GPS_ALTITUDE_REF',
        'name' => 'GPSAltitudeRef',
        'title' => 'GPSAltitudeRef',
        'components' => 1,
        'format' => 'Byte',
      ),
      6 =>
      array (
        'const' => 'GPS_ALTITUDE',
        'name' => 'GPSAltitude',
        'title' => 'GPSAltitude',
        'components' => 1,
        'format' => 'Rational',
      ),
      7 =>
      array (
        'const' => 'GPS_TIME_STAMP',
        'name' => 'GPSTimeStamp',
        'title' => 'GPSTimeStamp',
        'components' => 3,
        'format' => 'Rational',
      ),
      8 =>
      array (
        'const' => 'GPS_SATELLITES',
        'name' => 'GPSSatellites',
        'title' => 'GPSSatellites',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      9 =>
      array (
        'const' => 'GPS_STATUS',
        'name' => 'GPSStatus',
        'title' => 'GPSStatus',
        'components' => 2,
        'format' => 'Ascii',
      ),
      10 =>
      array (
        'const' => 'GPS_MEASURE_MODE',
        'name' => 'GPSMeasureMode',
        'title' => 'GPSMeasureMode',
        'components' => 2,
        'format' => 'Ascii',
      ),
      11 =>
      array (
        'const' => 'GPS_DOP',
        'name' => 'GPSDOP',
        'title' => 'GPSDOP',
        'components' => 1,
        'format' => 'Rational',
      ),
      12 =>
      array (
        'const' => 'GPS_SPEED_REF',
        'name' => 'GPSSpeedRef',
        'title' => 'GPSSpeedRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      13 =>
      array (
        'const' => 'GPS_SPEED',
        'name' => 'GPSSpeed',
        'title' => 'GPSSpeed',
        'components' => 1,
        'format' => 'Rational',
      ),
      14 =>
      array (
        'const' => 'GPS_TRACK_REF',
        'name' => 'GPSTrackRef',
        'title' => 'GPSTrackRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      15 =>
      array (
        'const' => 'GPS_TRACK',
        'name' => 'GPSTrack',
        'title' => 'GPSTrack',
        'components' => 1,
        'format' => 'Rational',
      ),
      16 =>
      array (
        'const' => 'GPS_IMG_DIRECTION_REF',
        'name' => 'GPSImgDirectionRef',
        'title' => 'GPSImgDirectionRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      17 =>
      array (
        'const' => 'GPS_IMG_DIRECTION',
        'name' => 'GPSImgDirection',
        'title' => 'GPSImgDirection',
        'components' => 1,
        'format' => 'Rational',
      ),
      18 =>
      array (
        'const' => 'GPS_MAP_DATUM',
        'name' => 'GPSMapDatum',
        'title' => 'GPSMapDatum',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      19 =>
      array (
        'const' => 'GPS_DEST_LATITUDE_REF',
        'name' => 'GPSDestLatitudeRef',
        'title' => 'GPSDestLatitudeRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      20 =>
      array (
        'const' => 'GPS_DEST_LATITUDE',
        'name' => 'GPSDestLatitude',
        'title' => 'GPSDestLatitude',
        'components' => 3,
        'format' => 'Rational',
      ),
      21 =>
      array (
        'const' => 'GPS_DEST_LONGITUDE_REF',
        'name' => 'GPSDestLongitudeRef',
        'title' => 'GPSDestLongitudeRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      22 =>
      array (
        'const' => 'GPS_DEST_LONGITUDE',
        'name' => 'GPSDestLongitude',
        'title' => 'GPSDestLongitude',
        'components' => 3,
        'format' => 'Rational',
      ),
      23 =>
      array (
        'const' => 'GPS_DEST_BEARING_REF',
        'name' => 'GPSDestBearingRef',
        'title' => 'GPSDestBearingRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      24 =>
      array (
        'const' => 'GPS_DEST_BEARING',
        'name' => 'GPSDestBearing',
        'title' => 'GPSDestBearing',
        'components' => 1,
        'format' => 'Rational',
      ),
      25 =>
      array (
        'const' => 'GPS_DEST_DISTANCE_REF',
        'name' => 'GPSDestDistanceRef',
        'title' => 'GPSDestDistanceRef',
        'components' => 2,
        'format' => 'Ascii',
      ),
      26 =>
      array (
        'const' => 'GPS_DEST_DISTANCE',
        'name' => 'GPSDestDistance',
        'title' => 'GPSDestDistance',
        'components' => 1,
        'format' => 'Rational',
      ),
      27 =>
      array (
        'const' => 'GPS_PROCESSING_METHOD',
        'name' => 'GPSProcessingMethod',
        'title' => 'GPSProcessingMethod',
        'components' => 'Any',
        'format' => 'Undefined',
      ),
      28 =>
      array (
        'const' => 'GPS_AREA_INFORMATION',
        'name' => 'GPSAreaInformation',
        'title' => 'GPSAreaInformation',
        'components' => 'Any',
        'format' => 'Undefined',
      ),
      29 =>
      array (
        'const' => 'GPS_DATE_STAMP',
        'name' => 'GPSDateStamp',
        'title' => 'GPSDateStamp',
        'components' => 11,
        'format' => 'Ascii',
      ),
      30 =>
      array (
        'const' => 'GPS_DIFFERENTIAL',
        'name' => 'GPSDifferential',
        'title' => 'GPSDifferential',
        'components' => 1,
        'format' => 'Short',
      ),
    ),
    2 =>
    array (
      41730 =>
      array (
        'const' => 'CFA_PATTERN',
        'name' => 'CFAPattern',
        'title' => 'CFA Pattern',
        'components' => 'Any',
        'format' => 'Undefined',
      ),
      33434 =>
      array (
        'const' => 'EXPOSURE_TIME',
        'name' => 'ExposureTime',
        'title' => 'Exposure Time',
        'components' => 1,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeExposureTime',
        ),
      ),
      33437 =>
      array (
        'const' => 'FNUMBER',
        'name' => 'FNumber',
        'title' => 'FNumber',
        'components' => 1,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeFNumber',
        ),
      ),
      34850 =>
      array (
        'const' => 'EXPOSURE_PROGRAM',
        'name' => 'ExposureProgram',
        'title' => 'Exposure Program',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Not defined',
            1 => 'Manual',
            2 => 'Normal program',
            3 => 'Aperture priority',
            4 => 'Shutter priority',
            5 => 'Creative program (biased toward depth of field)',
            6 => 'Action program (biased toward fast shutter speed)',
            7 => 'Portrait mode (for closeup photos with the background out of focus',
            8 => 'Landscape mode (for landscape photos with the background in focus',
          ),
        ),
      ),
      34852 =>
      array (
        'const' => 'SPECTRAL_SENSITIVITY',
        'name' => 'SpectralSensitivity',
        'title' => 'Spectral Sensitivity',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      34855 =>
      array (
        'const' => 'ISO_SPEED_RATINGS',
        'name' => 'ISOSpeedRatings',
        'title' => 'ISO Speed Ratings',
        'components' => 2,
        'format' => 'Short',
      ),
      34856 =>
      array (
        'const' => 'OECF',
        'name' => 'OECF',
        'title' => 'OECF',
        'components' => 'Any',
        'format' => 'Undefined',
      ),
      36864 =>
      array (
        'const' => 'EXIF_VERSION',
        'name' => 'ExifVersion',
        'title' => 'Exif Version',
        'components' => 4,
        'format' => 'Version',
        'text' =>
        array (
          'decode' => 'PelEntryVersion::decodeExifVersion',
        ),
      ),
      36867 =>
      array (
        'const' => 'DATE_TIME_ORIGINAL',
        'name' => 'DateTimeOriginal',
        'title' => 'Date and Time (original)',
        'components' => 20,
        'format' => 'Time',
      ),
      36868 =>
      array (
        'const' => 'DATE_TIME_DIGITIZED',
        'name' => 'DateTimeDigitized',
        'title' => 'Date and Time (digitized)',
        'components' => 20,
        'format' => 'Time',
      ),
      36880 =>
      array (
        'const' => 'OFFSET_TIME',
        'name' => 'OffsetTime',
        'title' => 'Timezone',
        'components' => 7,
        'format' => 'Ascii',
      ),
      36881 =>
      array (
        'const' => 'OFFSET_TIME_ORIGINAL',
        'name' => 'OffsetTimeOriginal',
        'title' => 'Timezone (original)',
        'components' => 7,
        'format' => 'Ascii',
      ),
      36882 =>
      array (
        'const' => 'OFFSET_TIME_DIGITIZED',
        'name' => 'OffsetTimeDigitized',
        'title' => 'Timezone (digitized)',
        'components' => 7,
        'format' => 'Ascii',
      ),
      37121 =>
      array (
        'const' => 'COMPONENTS_CONFIGURATION',
        'name' => 'ComponentsConfiguration',
        'title' => 'Components Configuration',
        'components' => 4,
        'format' => 'Undefined',
        'text' =>
        array (
          'decode' => 'PelEntryUndefined::decodeComponentsConfiguration',
        ),
      ),
      37122 =>
      array (
        'const' => 'COMPRESSED_BITS_PER_PIXEL',
        'name' => 'CompressedBitsPerPixel',
        'title' => 'Compressed Bits per Pixel',
        'components' => 1,
        'format' => 'Rational',
      ),
      37377 =>
      array (
        'const' => 'SHUTTER_SPEED_VALUE',
        'name' => 'ShutterSpeedValue',
        'title' => 'Shutter speed',
        'components' => 1,
        'format' => 'SRational',
        'text' =>
        array (
          'decode' => 'PelEntrySRational::decodeShutterSpeedValue',
        ),
      ),
      37378 =>
      array (
        'const' => 'APERTURE_VALUE',
        'name' => 'ApertureValue',
        'title' => 'Aperture',
        'components' => 1,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeApertureValue',
        ),
      ),
      37379 =>
      array (
        'const' => 'BRIGHTNESS_VALUE',
        'name' => 'BrightnessValue',
        'title' => 'Brightness',
        'components' => 1,
        'format' => 'SRational',
        'text' =>
        array (
          'decode' => 'PelEntrySRational::decodeBrightnessValue',
        ),
      ),
      37380 =>
      array (
        'const' => 'EXPOSURE_BIAS_VALUE',
        'name' => 'ExposureBiasValue',
        'title' => 'Exposure Bias',
        'components' => 1,
        'format' => 'SRational',
        'text' =>
        array (
          'decode' => 'PelEntrySRational::decodeExposureBiasValue',
        ),
      ),
      37381 =>
      array (
        'const' => 'MAX_APERTURE_VALUE',
        'name' => 'MaxApertureValue',
        'title' => 'Max Aperture Value',
        'components' => 1,
        'format' => 'Rational',
      ),
      37382 =>
      array (
        'const' => 'SUBJECT_DISTANCE',
        'name' => 'SubjectDistance',
        'title' => 'Subject Distance',
        'components' => 1,
        'format' => 'SRational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeSubjectDistance',
        ),
      ),
      37383 =>
      array (
        'const' => 'METERING_MODE',
        'name' => 'MeteringMode',
        'title' => 'Metering Mode',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Unknown',
            1 => 'Average',
            2 => 'Center-Weighted Average',
            3 => 'Spot',
            4 => 'Multi Spot',
            5 => 'Pattern',
            6 => 'Partial',
            255 => 'Other',
          ),
        ),
      ),
      37384 =>
      array (
        'const' => 'LIGHT_SOURCE',
        'name' => 'LightSource',
        'title' => 'Light Source',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Unknown',
            1 => 'Daylight',
            2 => 'Fluorescent',
            3 => 'Tungsten (incandescent light)',
            4 => 'Flash',
            9 => 'Fine weather',
            10 => 'Cloudy weather',
            11 => 'Shade',
            12 => 'Daylight fluorescent',
            13 => 'Day white fluorescent',
            14 => 'Cool white fluorescent',
            15 => 'White fluorescent',
            17 => 'Standard light A',
            18 => 'Standard light B',
            19 => 'Standard light C',
            20 => 'D55',
            21 => 'D65',
            22 => 'D75',
            24 => 'ISO studio tungsten',
            255 => 'Other',
          ),
        ),
      ),
      37385 =>
      array (
        'const' => 'FLASH',
        'name' => 'Flash',
        'title' => 'Flash',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Flash did not fire.',
            1 => 'Flash fired.',
            5 => 'Strobe return light not detected.',
            7 => 'Strobe return light detected.',
            9 => 'Flash fired, compulsory flash mode.',
            13 => 'Flash fired, compulsory flash mode, return light not detected.',
            15 => 'Flash fired, compulsory flash mode, return light detected.',
            16 => 'Flash did not fire, compulsory flash mode.',
            24 => 'Flash did not fire, auto mode.',
            25 => 'Flash fired, auto mode.',
            29 => 'Flash fired, auto mode, return light not detected.',
            31 => 'Flash fired, auto mode, return light detected.',
            32 => 'No flash function.',
            65 => 'Flash fired, red-eye reduction mode.',
            69 => 'Flash fired, red-eye reduction mode, return light not detected.',
            71 => 'Flash fired, red-eye reduction mode, return light detected.',
            73 => 'Flash fired, compulsory flash mode, red-eye reduction mode.',
            77 => 'Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected.',
            79 => 'Flash fired, compulsory flash mode, red-eye reduction mode, return light detected.',
            88 => 'Flash did not fire, auto mode, red-eye reduction mode.',
            89 => 'Flash fired, auto mode, red-eye reduction mode.',
            93 => 'Flash fired, auto mode, return light not detected, red-eye reduction mode.',
            95 => 'Flash fired, auto mode, return light detected, red-eye reduction mode.',
          ),
        ),
      ),
      37386 =>
      array (
        'const' => 'FOCAL_LENGTH',
        'name' => 'FocalLength',
        'title' => 'Focal Length',
        'components' => 1,
        'format' => 'Rational',
        'text' =>
        array (
          'decode' => 'PelEntryRational::decodeFocalLength',
        ),
      ),
      37396 =>
      array (
        'const' => 'SUBJECT_AREA',
        'name' => 'SubjectArea',
        'title' => 'Subject Area',
        'format' => 'Short',
        'text' =>
        array (
          'decode' => 'PelEntryShort::decodeSubjectArea',
        ),
      ),
      37500 =>
      array (
        'const' => 'MAKER_NOTE',
        'name' => 'MakerNote',
        'title' => 'Maker Note',
        'format' => 'MakerNotes',
      ),
      37510 =>
      array (
        'const' => 'USER_COMMENT',
        'name' => 'UserComment',
        'title' => 'User Comment',
        'components' => 'Any',
        'format' => 'UserComment',
      ),
      37520 =>
      array (
        'const' => 'SUB_SEC_TIME',
        'name' => 'SubSecTime',
        'title' => 'SubSec Time',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      37521 =>
      array (
        'const' => 'SUB_SEC_TIME_ORIGINAL',
        'name' => 'SubSecTimeOriginal',
        'title' => 'SubSec Time Original',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      37522 =>
      array (
        'const' => 'SUB_SEC_TIME_DIGITIZED',
        'name' => 'SubSecTimeDigitized',
        'title' => 'SubSec Time Digitized',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      40960 =>
      array (
        'const' => 'FLASH_PIX_VERSION',
        'name' => 'FlashPixVersion',
        'title' => 'FlashPix Version',
        'components' => 4,
        'format' => 'Version',
        'text' =>
        array (
          'decode' => 'PelEntryVersion::decodeFlashPixVersion',
        ),
      ),
      40961 =>
      array (
        'const' => 'COLOR_SPACE',
        'name' => 'ColorSpace',
        'title' => 'Color Space',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'sRGB',
            2 => 'Adobe RGB',
            65535 => 'Uncalibrated',
          ),
        ),
      ),
      40962 =>
      array (
        'const' => 'PIXEL_X_DIMENSION',
        'name' => 'PixelXDimension',
        'title' => 'Pixel x-Dimension',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      40963 =>
      array (
        'const' => 'PIXEL_Y_DIMENSION',
        'name' => 'PixelYDimension',
        'title' => 'Pixel y-Dimension',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      40964 =>
      array (
        'const' => 'RELATED_SOUND_FILE',
        'name' => 'RelatedSoundFile',
        'title' => 'Related Sound File',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      40965 =>
      array (
        'const' => 'INTEROPERABILITY_IFD_POINTER',
        'name' => 'InteroperabilityIFDPointer',
        'title' => 'Interoperability IFD Pointer',
        'ifd' => 4,
      ),
      41483 =>
      array (
        'const' => 'FLASH_ENERGY',
        'name' => 'FlashEnergy',
        'title' => 'Flash Energy',
        'components' => 1,
        'format' => 'Rational',
      ),
      41484 =>
      array (
        'const' => 'SPATIAL_FREQUENCY_RESPONSE',
        'name' => 'SpatialFrequencyResponse',
        'title' => 'Spatial Frequency Response',
        'components' => 'Any',
        'format' => 'Undefined',
      ),
      41486 =>
      array (
        'const' => 'FOCAL_PLANE_X_RESOLUTION',
        'name' => 'FocalPlaneXResolution',
        'title' => 'Focal Plane x-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      41487 =>
      array (
        'const' => 'FOCAL_PLANE_Y_RESOLUTION',
        'name' => 'FocalPlaneYResolution',
        'title' => 'Focal Plane y-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      41488 =>
      array (
        'const' => 'FOCAL_PLANE_RESOLUTION_UNIT',
        'name' => 'FocalPlaneResolutionUnit',
        'title' => 'Focal Plane Resolution Unit',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            2 => 'Inch',
            3 => 'Centimeter',
          ),
        ),
      ),
      41492 =>
      array (
        'const' => 'SUBJECT_LOCATION',
        'name' => 'SubjectLocation',
        'title' => 'Subject Location',
        'components' => 1,
        'format' => 'Short',
      ),
      41493 =>
      array (
        'const' => 'EXPOSURE_INDEX',
        'name' => 'ExposureIndex',
        'title' => 'Exposure index',
        'components' => 1,
        'format' => 'Rational',
      ),
      41495 =>
      array (
        'const' => 'SENSING_METHOD',
        'name' => 'SensingMethod',
        'title' => 'Sensing Method',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Not defined',
            2 => 'One-chip color area sensor',
            3 => 'Two-chip color area sensor',
            4 => 'Three-chip color area sensor',
            5 => 'Color sequential area sensor',
            7 => 'Trilinear sensor',
            8 => 'Color sequential linear sensor',
          ),
        ),
      ),
      41728 =>
      array (
        'const' => 'FILE_SOURCE',
        'name' => 'FileSource',
        'title' => 'File Source',
        'components' => 1,
        'format' => 'Undefined',
        'text' =>
        array (
          'decode' => 'PelEntryUndefined::decodeFileSource',
        ),
      ),
      41729 =>
      array (
        'const' => 'SCENE_TYPE',
        'name' => 'SceneType',
        'title' => 'Scene Type',
        'components' => 1,
        'format' => 'Undefined',
        'text' =>
        array (
          'decode' => 'PelEntryUndefined::decodeSceneType',
        ),
      ),
      41985 =>
      array (
        'const' => 'CUSTOM_RENDERED',
        'name' => 'CustomRendered',
        'title' => 'Custom Rendered',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal process',
            1 => 'Custom process',
          ),
        ),
      ),
      41986 =>
      array (
        'const' => 'EXPOSURE_MODE',
        'name' => 'ExposureMode',
        'title' => 'Exposure Mode',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Auto exposure',
            1 => 'Manual exposure',
            2 => 'Auto bracket',
          ),
        ),
      ),
      41987 =>
      array (
        'const' => 'WHITE_BALANCE',
        'name' => 'WhiteBalance',
        'title' => 'White Balance',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Auto white balance',
            1 => 'Manual white balance',
          ),
        ),
      ),
      41988 =>
      array (
        'const' => 'DIGITAL_ZOOM_RATIO',
        'name' => 'DigitalZoomRatio',
        'title' => 'Digital Zoom Ratio',
        'components' => 1,
        'format' => 'Rational',
      ),
      41989 =>
      array (
        'const' => 'FOCAL_LENGTH_IN_35MM_FILM',
        'name' => 'FocalLengthIn35mmFilm',
        'title' => 'Focal Length In 35mm Film',
        'components' => 1,
        'format' => 'Rational',
      ),
      41990 =>
      array (
        'const' => 'SCENE_CAPTURE_TYPE',
        'name' => 'SceneCaptureType',
        'title' => 'Scene Capture Type',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Standard',
            1 => 'Landscape',
            2 => 'Portrait',
            3 => 'Night scene',
          ),
        ),
      ),
      41991 =>
      array (
        'const' => 'GAIN_CONTROL',
        'name' => 'GainControl',
        'title' => 'Gain Control',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
            1 => 'Low gain up',
            2 => 'High gain up',
            3 => 'Low gain down',
            4 => 'High gain down',
          ),
        ),
      ),
      41992 =>
      array (
        'const' => 'CONTRAST',
        'name' => 'Contrast',
        'title' => 'Contrast',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
            1 => 'Soft',
            2 => 'Hard',
          ),
        ),
      ),
      41993 =>
      array (
        'const' => 'SATURATION',
        'name' => 'Saturation',
        'title' => 'Saturation',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
            1 => 'Low saturation',
            2 => 'High saturation',
          ),
        ),
      ),
      41994 =>
      array (
        'const' => 'SHARPNESS',
        'name' => 'Sharpness',
        'title' => 'Sharpness',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
            1 => 'Soft',
            2 => 'Hard',
          ),
        ),
      ),
      41995 =>
      array (
        'const' => 'DEVICE_SETTING_DESCRIPTION',
        'name' => 'DeviceSettingDescription',
        'title' => 'Device Setting Description',
        'components' => 'Unknown',
        'format' => 'Unknown',
      ),
      41996 =>
      array (
        'const' => 'SUBJECT_DISTANCE_RANGE',
        'name' => 'SubjectDistanceRange',
        'title' => 'Subject Distance Range',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Unknown',
            1 => 'Macro',
            2 => 'Close view',
            3 => 'Distant view',
          ),
        ),
      ),
      42016 =>
      array (
        'const' => 'IMAGE_UNIQUE_ID',
        'name' => 'ImageUniqueID',
        'title' => 'Image Unique ID',
        'components' => 32,
        'format' => 'Ascii',
      ),
      42240 =>
      array (
        'const' => 'GAMMA',
        'name' => 'Gamma',
        'title' => 'Gamma',
        'components' => 1,
        'format' => 'Rational',
      ),
    ),
    5 =>
    array (
      1 =>
      array (
        'const' => 'CANON_CAMERA_SETTINGS',
        'name' => 'CameraSettings',
        'title' => 'Camera Settings',
        'ifd' => 6,
      ),
      2 =>
      array (
        'const' => 'CANON_FOCAL_LENGTH',
        'name' => 'FocalLength',
        'title' => 'Focal Length',
        'format' => 'Short',
      ),
      4 =>
      array (
        'const' => 'CANON_SHOT_INFO',
        'name' => 'ShotInfo',
        'title' => 'Shot Info',
        'ifd' => 7,
      ),
      5 =>
      array (
        'const' => 'CANON_PANORAMA',
        'name' => 'Panorama',
        'title' => 'Panorama',
        'ifd' => 8,
      ),
      6 =>
      array (
        'const' => 'CANON_IMAGE_TYPE',
        'name' => 'ImageType',
        'title' => 'Image Type',
        'format' => 'Ascii',
      ),
      7 =>
      array (
        'const' => 'CANON_FIRMWARE_VERSION',
        'name' => 'FirmwareVersion',
        'title' => 'Firmware Version',
        'format' => 'Ascii',
      ),
      8 =>
      array (
        'const' => 'CANON_FILE_NUMBER',
        'name' => 'FileNumber',
        'title' => 'File Number',
        'format' => 'Long',
      ),
      9 =>
      array (
        'const' => 'CANON_OWNER_NAME',
        'name' => 'OwnerName',
        'title' => 'Owner Name',
        'format' => 'Ascii',
      ),
      12 =>
      array (
        'const' => 'CANON_SERIAL_NUMBER',
        'name' => 'SerialNumber',
        'title' => 'Serial Number',
        'format' => 'Long',
      ),
      13 =>
      array (
        'const' => 'CANON_CAMERA_INFO',
        'name' => 'CameraInfo',
        'title' => 'Camera Info',
        'format' => 'Short',
      ),
      15 =>
      array (
        'const' => 'CANON_CUSTOM_FUNCTIONS',
        'name' => 'CustomFunctions',
        'title' => 'Custom Functions',
        'format' => 'Ifd',
      ),
      16 =>
      array (
        'const' => 'CANON_MODEL_ID',
        'name' => 'ModelID',
        'title' => 'Model ID',
        'format' => 'Long',
      ),
      18 =>
      array (
        'const' => 'CANON_PICTURE_INFO',
        'name' => 'PictureInfo',
        'title' => 'Picture Info',
        'ifd' => 9,
      ),
      19 =>
      array (
        'const' => 'CANON_THUMBNAIL_IMAGE_VALID_AREA',
        'name' => 'ThumbnailImageValidArea',
        'title' => 'Thumbnail Image Valid Area',
        'format' => 'SShort',
      ),
      21 =>
      array (
        'const' => 'CANON_SERIAL_NUMBER_FORMAT',
        'name' => 'Serial Number Format',
        'title' => 'Serial number format',
        'format' => 'Long',
      ),
      26 =>
      array (
        'const' => 'CANON_SUPER_MACRO',
        'name' => 'SuperMacro',
        'title' => 'Super macro',
        'format' => 'SShort',
      ),
      30 =>
      array (
        'const' => 'CANON_FIRMWARE_REVISION',
        'name' => 'FirmwareRevision',
        'title' => 'Firmware Revision',
        'format' => 'Long',
      ),
      38 =>
      array (
        'const' => 'CANON_AF_INFO',
        'name' => 'AFinfo',
        'title' => 'AF info',
        'format' => 'Short',
      ),
      131 =>
      array (
        'const' => 'CANON_ORIGINAL_DECISION_DATA_OFFSET',
        'name' => 'OriginalDecision Data Offset',
        'title' => 'Original decision data offset',
        'format' => 'SLong',
      ),
      164 =>
      array (
        'const' => 'CANON_WHITE_BALANCE_TABLE',
        'name' => 'WhiteBalanceTable',
        'title' => 'White balance table',
        'format' => 'Short',
      ),
      149 =>
      array (
        'const' => 'CANON_LENS_MODEL',
        'name' => 'LensModel',
        'title' => 'Lens model',
        'format' => 'Ascii',
      ),
      150 =>
      array (
        'const' => 'CANON_INTERNAL_SERIAL_NUMBER',
        'name' => 'InternalSerialNumber',
        'title' => 'Internal serial number',
        'format' => 'Ascii',
      ),
      151 =>
      array (
        'const' => 'CANON_DUST_REMOVAL_DATA',
        'name' => 'DustRemovalData',
        'title' => 'Dust removal data',
        'format' => 'Ascii',
      ),
      153 =>
      array (
        'const' => 'CANON_CUSTOM_FUNCTIONS_2',
        'name' => 'CustomFunctions',
        'title' => 'Custom functions',
        'format' => 'Ifd',
      ),
      160 =>
      array (
        'const' => 'CANON_PROCESSING_INFO',
        'name' => 'ProcessingInfo',
        'title' => 'Processing info',
        'format' => 'Short',
      ),
      170 =>
      array (
        'const' => 'CANON_MEASURED_COLOR',
        'name' => 'MeasuredColor',
        'title' => 'Measured color',
        'format' => 'Short',
      ),
      180 =>
      array (
        'const' => 'CANON_COLOR_SPACE',
        'name' => 'ColorSpace',
        'title' => 'Color Space',
        'format' => 'SShort',
      ),
      208 =>
      array (
        'const' => 'CANON_VRD_OFFSET',
        'name' => 'VRDOffset',
        'title' => 'VRD offset',
        'format' => 'Long',
      ),
      224 =>
      array (
        'const' => 'CANON_SENSOR_INFO',
        'name' => 'SensorInfo',
        'title' => 'Sensor info',
        'format' => 'Short',
      ),
      16385 =>
      array (
        'const' => 'CANON_COLOR_DATA',
        'name' => 'ColorData',
        'title' => 'Color data',
        'format' => 'Short',
      ),
    ),
    6 =>
    array (
      1 =>
      array (
        'const' => 'CANON_CS_MACRO',
        'name' => 'MacroMode',
        'title' => 'Macro Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Macro',
            2 => 'Normal',
          ),
        ),
      ),
      2 =>
      array (
        'const' => 'CANON_CS_SELF_TIMER',
        'name' => 'SelfTimer',
        'title' => 'Self Timer',
      ),
      3 =>
      array (
        'const' => 'CANON_CS_QUALITY',
        'name' => 'Quality',
        'title' => 'Quality',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Economy',
            2 => 'Normal',
            3 => 'Fine',
            4 => 'RAW',
            5 => 'Superfine',
            130 => 'Normal Movie',
            131 => 'Movie (2)',
          ),
        ),
      ),
      4 =>
      array (
        'const' => 'CANON_CS_FLASH_MODE',
        'name' => 'FlashMode',
        'title' => 'Flash Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'Auto',
            2 => 'On',
            3 => 'Red-eye reduction',
            4 => 'Slow-sync',
            5 => 'Red-eye reduction (Auto)',
            6 => 'Red-eye reduction (On)',
            16 => 'External flash',
          ),
        ),
      ),
      5 =>
      array (
        'const' => 'CANON_CS_DRIVE_MODE',
        'name' => 'DriveMode',
        'title' => 'Drive Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Single',
            1 => 'Continuous',
            2 => 'Movie',
            3 => 'Continuous, Speed Priority',
            4 => 'Continuous, Low',
            5 => 'Continuous, High',
            6 => 'Silent Single',
            9 => 'Single, Silent',
            10 => 'Continuous, Silent',
          ),
        ),
      ),
      7 =>
      array (
        'const' => 'CANON_CS_FOCUS_MODE',
        'name' => 'FocusMode',
        'title' => 'Focus Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'One-shot AF',
            1 => 'AI Servo AF',
            2 => 'AI Focus AF',
            3 => 'Manual Focus (3)',
            4 => 'Single',
            5 => 'Continuous',
            6 => 'Manual Focus (6)',
            16 => 'Pan Focus',
            256 => 'AF + MF',
            512 => 'Movie Snap Focus',
            519 => 'Movie Servo AF',
          ),
        ),
      ),
      9 =>
      array (
        'const' => 'CANON_CS_RECORD_MODE',
        'name' => 'RecordMode',
        'title' => 'Record Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'JPEG',
            2 => 'CRW+THM',
            3 => 'AVI+THM',
            4 => 'TIF',
            5 => 'TIF+JPEG',
            6 => 'CR2',
            7 => 'CR2+JPEG',
            9 => 'MOV',
            10 => 'MP4',
          ),
        ),
      ),
      10 =>
      array (
        'const' => 'CANON_CS_IMAGE_SIZE',
        'name' => 'ImageSize',
        'title' => 'Image Size',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Large',
            1 => 'Medium',
            2 => 'Small',
            5 => 'Medium 1',
            6 => 'Medium 2',
            7 => 'Medium 3',
            8 => 'Postcard',
            9 => 'Widescreen',
            10 => 'Medium Widescreen',
            14 => 'Small 1',
            15 => 'Small 2',
            16 => 'Small 3',
            128 => '640x480 Movie',
            129 => 'Medium Movie',
            130 => 'Small Movie',
            137 => '1280x720 Movie',
            142 => '1920x1080 Movie',
          ),
        ),
      ),
      11 =>
      array (
        'const' => 'CANON_CS_EASY_MODE',
        'name' => 'EasyShootingMode',
        'title' => 'Easy Shooting Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Full auto',
            1 => 'Manual',
            2 => 'Landscape',
            3 => 'Fast shutter',
            4 => 'Slow shutter',
            5 => 'Night',
            6 => 'Gray Scale',
            7 => 'Sepia',
            8 => 'Portrait',
            9 => 'Sports',
            10 => 'Macro',
            11 => 'Black & White',
            12 => 'Pan focus',
            13 => 'Vivid',
            14 => 'Neutral',
            15 => 'Flash Off',
            16 => 'Long Shutter',
            17 => 'Super Macro',
            18 => 'Foliage',
            19 => 'Indoor',
            20 => 'Fireworks',
            21 => 'Beach',
            22 => 'Underwater',
            23 => 'Snow',
            24 => 'Kids & Pets',
            25 => 'Night Snapshot',
            26 => 'Digital Macro',
            27 => 'My Colors',
            28 => 'Movie Snap',
            29 => 'Super Macro 2',
            30 => 'Color Accent',
            31 => 'Color Swap',
            32 => 'Aquarium',
            33 => 'ISO 3200',
            34 => 'ISO 6400',
            35 => 'Creative Light Effect',
            36 => 'Easy',
            37 => 'Quick Shot',
            38 => 'Creative Auto',
            39 => 'Zoom Blur',
            40 => 'Low Light',
            41 => 'Nostalgic',
            42 => 'Super Vivid',
            43 => 'Poster Effect',
            44 => 'Face Self-timer',
            45 => 'Smile',
            46 => 'Wink Self-timer',
            47 => 'Fisheye Effect',
            48 => 'Miniature Effect',
            49 => 'High-speed Burst',
            50 => 'Best Image Selection',
            51 => 'High Dynamic Range',
            52 => 'Handheld Night Scene',
            53 => 'Movie Digest',
            54 => 'Live View Control',
            55 => 'Discreet',
            56 => 'Blur Reduction',
            57 => 'Monochrome',
            58 => 'Toy Camera Effect',
            59 => 'Scene Intelligent Auto',
            60 => 'High-speed Burst HQ',
            61 => 'Smooth Skin',
            62 => 'Soft Focus',
            257 => 'Spotlight',
            258 => 'Night 2',
            259 => 'Night+',
            260 => 'Super Night',
            261 => 'Sunset',
            263 => 'Night Scene',
            264 => 'Surface',
            265 => 'Low Light 2',
          ),
        ),
      ),
      12 =>
      array (
        'const' => 'CANON_CS_DIGITAL_ZOOM',
        'name' => 'DigitalZoom',
        'title' => 'Digital Zoom',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'None',
            1 => '2x',
            2 => '4x',
            3 => 'Other',
          ),
        ),
      ),
      13 =>
      array (
        'const' => 'CANON_CS_CONTRAST',
        'name' => 'Contrast',
        'title' => 'Contrast',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
          ),
        ),
      ),
      14 =>
      array (
        'const' => 'CANON_CS_SATURATION',
        'name' => 'Saturation',
        'title' => 'Saturation',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
          ),
        ),
      ),
      15 =>
      array (
        'const' => 'CANON_CS_SHARPNESS',
        'name' => 'Sharpness',
        'title' => 'Sharpness',
      ),
      16 =>
      array (
        'const' => 'CANON_CS_ISO_SPEED',
        'name' => 'ISOSpeed',
        'title' => 'ISO Speed',
      ),
      17 =>
      array (
        'const' => 'CANON_CS_METERING_MODE',
        'name' => 'MeteringMode',
        'title' => 'Metering Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Default',
            1 => 'Spot',
            2 => 'Average',
            3 => 'Evaluative',
            4 => 'Partial',
            5 => 'Center-weighted average',
          ),
        ),
      ),
      18 =>
      array (
        'const' => 'CANON_CS_FOCUS_TYPE',
        'name' => 'FocusType',
        'title' => 'Focus Type',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Manual',
            1 => 'Auto',
            2 => 'Not Known',
            3 => 'Macro',
            4 => 'Very Close',
            5 => 'Close',
            6 => 'Middle Range',
            7 => 'Far Range',
            8 => 'Pan Focus',
            9 => 'Super Macro',
            10 => 'Infinity',
          ),
        ),
      ),
      19 =>
      array (
        'const' => 'CANON_CS_AF_POINT',
        'name' => 'AFPointSelected',
        'title' => 'AF Point Selected',
        'text' =>
        array (
          'mapping' =>
          array (
            8197 => 'Manual AF point selection',
            12288 => 'None (MF)',
            12289 => 'Auto AF point selection',
            12290 => 'Right',
            12291 => 'Center',
            12292 => 'Left',
            16385 => 'Auto AF point selection',
            16390 => 'Face Detect',
          ),
        ),
      ),
      20 =>
      array (
        'const' => 'CANON_CS_EXPOSURE_PROGRAM',
        'name' => 'ExposureMode',
        'title' => 'Exposure Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Easy',
            1 => 'Program AE',
            2 => 'Shutter speed priority AE',
            3 => 'Aperture-priority AE',
            4 => 'Manual',
            5 => 'Depth-of-field AE',
            6 => 'M-Dep',
            7 => 'Bulb',
          ),
        ),
      ),
      22 =>
      array (
        'const' => 'CANON_CS_LENS_TYPE',
        'name' => 'LensType',
        'title' => 'Lens Type',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Canon EF 50mm f/1.8',
            2 => 'Canon EF 28mm f/2.8',
            3 => 'Canon EF 135mm f/2.8 Soft',
            4 => 'Canon EF 35-105mm f/3.5-4.5 or Sigma Lens',
            '4.1' => 'Sigma UC Zoom 35-135mm f/4-5.6',
            5 => 'Canon EF 35-70mm f/3.5-4.5',
            6 => 'Canon EF 28-70mm f/3.5-4.5 or Sigma or Tokina Lens',
            '6.1' => 'Sigma 18-50mm f/3.5-5.6 DC',
            '6.2' => 'Sigma 18-125mm f/3.5-5.6 DC IF ASP',
            '6.3' => 'Tokina AF 193-2 19-35mm f/3.5-4.5',
            '6.4' => 'Sigma 28-80mm f/3.5-5.6 II Macro',
            7 => 'Canon EF 100-300mm f/5.6L',
            8 => 'Canon EF 100-300mm f/5.6 or Sigma or Tokina Lens',
            '8.1' => 'Sigma 70-300mm f/4-5.6 [APO] DG Macro',
            '8.2' => 'Tokina AT-X 242 AF 24-200mm f/3.5-5.6',
            9 => 'Canon EF 70-210mm f/4',
            '9.1' => 'Sigma 55-200mm f/4-5.6 DC',
            10 => 'Canon EF 50mm f/2.5 Macro or Sigma Lens',
            '10.1' => 'Sigma 50mm f/2.8 EX',
            '10.2' => 'Sigma 28mm f/1.8',
            '10.3' => 'Sigma 105mm f/2.8 Macro EX',
            '10.4' => 'Sigma 70mm f/2.8 EX DG Macro EF',
            11 => 'Canon EF 35mm f/2',
            13 => 'Canon EF 15mm f/2.8 Fisheye',
            14 => 'Canon EF 50-200mm f/3.5-4.5L',
            15 => 'Canon EF 50-200mm f/3.5-4.5',
            16 => 'Canon EF 35-135mm f/3.5-4.5',
            17 => 'Canon EF 35-70mm f/3.5-4.5A',
            18 => 'Canon EF 28-70mm f/3.5-4.5',
            20 => 'Canon EF 100-200mm f/4.5A',
            21 => 'Canon EF 80-200mm f/2.8L',
            22 => 'Canon EF 20-35mm f/2.8L or Tokina Lens',
            '22.1' => 'Tokina AT-X 280 AF Pro 28-80mm f/2.8 Aspherical',
            23 => 'Canon EF 35-105mm f/3.5-4.5',
            24 => 'Canon EF 35-80mm f/4-5.6 Power Zoom',
            25 => 'Canon EF 35-80mm f/4-5.6 Power Zoom',
            26 => 'Canon EF 100mm f/2.8 Macro or Other Lens',
            '26.1' => 'Cosina 100mm f/3.5 Macro AF',
            '26.2' => 'Tamron SP AF 90mm f/2.8 Di Macro',
            '26.3' => 'Tamron SP AF 180mm f/3.5 Di Macro',
            '26.4' => 'Carl Zeiss Planar T* 50mm f/1.4',
            27 => 'Canon EF 35-80mm f/4-5.6',
            28 => 'Canon EF 80-200mm f/4.5-5.6 or Tamron Lens',
            '28.1' => 'Tamron SP AF 28-105mm f/2.8 LD Aspherical IF',
            '28.2' => 'Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro',
            '28.3' => 'Tamron AF 70-300mm f/4-5.6 Di LD 1:2 Macro',
            '28.4' => 'Tamron AF Aspherical 28-200mm f/3.8-5.6',
            29 => 'Canon EF 50mm f/1.8 II',
            30 => 'Canon EF 35-105mm f/4.5-5.6',
            31 => 'Canon EF 75-300mm f/4-5.6 or Tamron Lens',
            '31.1' => 'Tamron SP AF 300mm f/2.8 LD IF',
            32 => 'Canon EF 24mm f/2.8 or Sigma Lens',
            '32.1' => 'Sigma 15mm f/2.8 EX Fisheye',
            33 => 'Voigtlander or Carl Zeiss Lens',
            '33.1' => 'Voigtlander Ultron 40mm f/2 SLII Aspherical',
            '33.2' => 'Voigtlander Color Skopar 20mm f/3.5 SLII Aspherical',
            '33.3' => 'Voigtlander APO-Lanthar 90mm f/3.5 SLII Close Focus',
            '33.4' => 'Carl Zeiss Distagon T* 15mm f/2.8 ZE',
            '33.5' => 'Carl Zeiss Distagon T* 18mm f/3.5 ZE',
            '33.6' => 'Carl Zeiss Distagon T* 21mm f/2.8 ZE',
            '33.7' => 'Carl Zeiss Distagon T* 25mm f/2 ZE',
            '33.8' => 'Carl Zeiss Distagon T* 28mm f/2 ZE',
            '33.9' => 'Carl Zeiss Distagon T* 35mm f/2 ZE',
            '33.10' => 'Carl Zeiss Distagon T* 35mm f/1.4 ZE',
            '33.11' => 'Carl Zeiss Planar T* 50mm f/1.4 ZE',
            '33.12' => 'Carl Zeiss Makro-Planar T* 50mm f/2 ZE',
            '33.13' => 'Carl Zeiss Makro-Planar T* 100mm f/2 ZE',
            '33.14' => 'Carl Zeiss Apo-Sonnar T* 135mm f/2 ZE',
            35 => 'Canon EF 35-80mm f/4-5.6',
            36 => 'Canon EF 38-76mm f/4.5-5.6',
            37 => 'Canon EF 35-80mm f/4-5.6 or Tamron Lens',
            '37.1' => 'Tamron 70-200mm f/2.8 Di LD IF Macro',
            '37.2' => 'Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20',
            '37.3' => 'Tamron SP AF 17-50mm f/2.8 XR Di II VC LD Aspherical [IF]',
            '37.4' => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC LD Aspherical [IF] Macro',
            38 => 'Canon EF 80-200mm f/4.5-5.6',
            39 => 'Canon EF 75-300mm f/4-5.6',
            40 => 'Canon EF 28-80mm f/3.5-5.6',
            41 => 'Canon EF 28-90mm f/4-5.6',
            42 => 'Canon EF 28-200mm f/3.5-5.6 or Tamron Lens',
            '42.1' => 'Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20',
            43 => 'Canon EF 28-105mm f/4-5.6',
            44 => 'Canon EF 90-300mm f/4.5-5.6',
            45 => 'Canon EF-S 18-55mm f/3.5-5.6 [II]',
            46 => 'Canon EF 28-90mm f/4-5.6',
            47 => 'Zeiss Milvus 35mm f/2 or 50mm f/2',
            '47.1' => 'Zeiss Milvus 50mm f/2 Makro',
            48 => 'Canon EF-S 18-55mm f/3.5-5.6 IS',
            49 => 'Canon EF-S 55-250mm f/4-5.6 IS',
            50 => 'Canon EF-S 18-200mm f/3.5-5.6 IS',
            51 => 'Canon EF-S 18-135mm f/3.5-5.6 IS',
            52 => 'Canon EF-S 18-55mm f/3.5-5.6 IS II',
            53 => 'Canon EF-S 18-55mm f/3.5-5.6 III',
            54 => 'Canon EF-S 55-250mm f/4-5.6 IS II',
            60 => 'Irix 11mm f/4',
            94 => 'Canon TS-E 17mm f/4L',
            95 => 'Canon TS-E 24.0mm f/3.5 L II',
            124 => 'Canon MP-E 65mm f/2.8 1-5x Macro Photo',
            125 => 'Canon TS-E 24mm f/3.5L',
            126 => 'Canon TS-E 45mm f/2.8',
            127 => 'Canon TS-E 90mm f/2.8',
            129 => 'Canon EF 300mm f/2.8L',
            130 => 'Canon EF 50mm f/1.0L',
            131 => 'Canon EF 28-80mm f/2.8-4L or Sigma Lens',
            '131.1' => 'Sigma 8mm f/3.5 EX DG Circular Fisheye',
            '131.2' => 'Sigma 17-35mm f/2.8-4 EX DG Aspherical HSM',
            '131.3' => 'Sigma 17-70mm f/2.8-4.5 DC Macro',
            '131.4' => 'Sigma APO 50-150mm f/2.8 [II] EX DC HSM',
            '131.5' => 'Sigma APO 120-300mm f/2.8 EX DG HSM',
            '131.6' => 'Sigma 4.5mm f/2.8 EX DC HSM Circular Fisheye',
            '131.7' => 'Sigma 70-200mm f/2.8 APO EX HSM',
            132 => 'Canon EF 1200mm f/5.6L',
            134 => 'Canon EF 600mm f/4L IS',
            135 => 'Canon EF 200mm f/1.8L',
            136 => 'Canon EF 300mm f/2.8L',
            137 => 'Canon EF 85mm f/1.2L or Sigma or Tamron Lens',
            '137.1' => 'Sigma 18-50mm f/2.8-4.5 DC OS HSM',
            '137.2' => 'Sigma 50-200mm f/4-5.6 DC OS HSM',
            '137.3' => 'Sigma 18-250mm f/3.5-6.3 DC OS HSM',
            '137.4' => 'Sigma 24-70mm f/2.8 IF EX DG HSM',
            '137.5' => 'Sigma 18-125mm f/3.8-5.6 DC OS HSM',
            '137.6' => 'Sigma 17-70mm f/2.8-4 DC Macro OS HSM | C',
            '137.7' => 'Sigma 17-50mm f/2.8 OS HSM',
            '137.8' => 'Sigma 18-200mm f/3.5-6.3 DC OS HSM [II]',
            '137.9' => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD',
            '137.10' => 'Sigma 8-16mm f/4.5-5.6 DC HSM',
            '137.11' => 'Tamron SP 17-50mm f/2.8 XR Di II VC',
            '137.12' => 'Tamron SP 60mm f/2 Macro Di II',
            '137.13' => 'Sigma 10-20mm f/3.5 EX DC HSM',
            '137.14' => 'Tamron SP 24-70mm f/2.8 Di VC USD',
            '137.15' => 'Sigma 18-35mm f/1.8 DC HSM',
            '137.16' => 'Sigma 12-24mm f/4.5-5.6 DG HSM II',
            138 => 'Canon EF 28-80mm f/2.8-4L',
            139 => 'Canon EF 400mm f/2.8L',
            140 => 'Canon EF 500mm f/4.5L',
            141 => 'Canon EF 500mm f/4.5L',
            142 => 'Canon EF 300mm f/2.8L IS',
            143 => 'Canon EF 500mm f/4L IS or Sigma Lens',
            '143.1' => 'Sigma 17-70mm f/2.8-4 DC Macro OS HSM',
            144 => 'Canon EF 35-135mm f/4-5.6 USM',
            145 => 'Canon EF 100-300mm f/4.5-5.6 USM',
            146 => 'Canon EF 70-210mm f/3.5-4.5 USM',
            147 => 'Canon EF 35-135mm f/4-5.6 USM',
            148 => 'Canon EF 28-80mm f/3.5-5.6 USM',
            149 => 'Canon EF 100mm f/2 USM',
            150 => 'Canon EF 14mm f/2.8L or Sigma Lens',
            '150.1' => 'Sigma 20mm EX f/1.8',
            '150.2' => 'Sigma 30mm f/1.4 DC HSM',
            '150.3' => 'Sigma 24mm f/1.8 DG Macro EX',
            '150.4' => 'Sigma 28mm f/1.8 DG Macro EX',
            151 => 'Canon EF 200mm f/2.8L',
            152 => 'Canon EF 300mm f/4L IS or Sigma Lens',
            '152.1' => 'Sigma 12-24mm f/4.5-5.6 EX DG ASPHERICAL HSM',
            '152.2' => 'Sigma 14mm f/2.8 EX Aspherical HSM',
            '152.3' => 'Sigma 10-20mm f/4-5.6',
            '152.4' => 'Sigma 100-300mm f/4',
            153 => 'Canon EF 35-350mm f/3.5-5.6L or Sigma or Tamron Lens',
            '153.1' => 'Sigma 50-500mm f/4-6.3 APO HSM EX',
            '153.2' => 'Tamron AF 28-300mm f/3.5-6.3 XR LD Aspherical [IF] Macro',
            '153.3' => 'Tamron AF 18-200mm f/3.5-6.3 XR Di II LD Aspherical [IF] Macro Model A14',
            '153.4' => 'Tamron 18-250mm f/3.5-6.3 Di II LD Aspherical [IF] Macro',
            154 => 'Canon EF 20mm f/2.8 USM or Zeiss Lens',
            '154.1' => 'Zeiss Milvus 21mm f/2.8',
            155 => 'Canon EF 85mm f/1.8 USM',
            156 => 'Canon EF 28-105mm f/3.5-4.5 USM or Tamron Lens',
            '156.1' => 'Tamron SP 70-300mm f/4.0-5.6 Di VC USD',
            '156.2' => 'Tamron SP AF 28-105mm f/2.8 LD Aspherical IF',
            160 => 'Canon EF 20-35mm f/3.5-4.5 USM or Tamron or Tokina Lens',
            '160.1' => 'Tamron AF 19-35mm f/3.5-4.5',
            '160.2' => 'Tokina AT-X 124 AF Pro DX 12-24mm f/4',
            '160.3' => 'Tokina AT-X 107 AF DX 10-17mm f/3.5-4.5 Fisheye',
            '160.4' => 'Tokina AT-X 116 AF Pro DX 11-16mm f/2.8',
            '160.5' => 'Tokina AT-X 11-20 F2.8 PRO DX Aspherical 11-20mm f/2.8',
            161 => 'Canon EF 28-70mm f/2.8L or Sigma or Tamron Lens',
            '161.1' => 'Sigma 24-70mm f/2.8 EX',
            '161.2' => 'Sigma 28-70mm f/2.8 EX',
            '161.3' => 'Sigma 24-60mm f/2.8 EX DG',
            '161.4' => 'Tamron AF 17-50mm f/2.8 Di-II LD Aspherical',
            '161.5' => 'Tamron 90mm f/2.8',
            '161.6' => 'Tamron SP AF 17-35mm f/2.8-4 Di LD Aspherical IF',
            '161.7' => 'Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro',
            162 => 'Canon EF 200mm f/2.8L',
            163 => 'Canon EF 300mm f/4L',
            164 => 'Canon EF 400mm f/5.6L',
            165 => 'Canon EF 70-200mm f/2.8 L',
            166 => 'Canon EF 70-200mm f/2.8 L + 1.4x',
            167 => 'Canon EF 70-200mm f/2.8 L + 2x',
            168 => 'Canon EF 28mm f/1.8 USM or Sigma Lens',
            '168.1' => 'Sigma 50-100mm f/1.8 DC HSM | A',
            169 => 'Canon EF 17-35mm f/2.8L or Sigma Lens',
            '169.1' => 'Sigma 18-200mm f/3.5-6.3 DC OS',
            '169.2' => 'Sigma 15-30mm f/3.5-4.5 EX DG Aspherical',
            '169.3' => 'Sigma 18-50mm f/2.8 Macro',
            '169.4' => 'Sigma 50mm f/1.4 EX DG HSM',
            '169.5' => 'Sigma 85mm f/1.4 EX DG HSM',
            '169.6' => 'Sigma 30mm f/1.4 EX DC HSM',
            '169.7' => 'Sigma 35mm f/1.4 DG HSM',
            170 => 'Canon EF 200mm f/2.8L II',
            171 => 'Canon EF 300mm f/4L',
            172 => 'Canon EF 400mm f/5.6L or Sigma Lens',
            '172.1' => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S',
            173 => 'Canon EF 180mm Macro f/3.5L or Sigma Lens',
            '173.1' => 'Sigma 180mm EX HSM Macro f/3.5',
            '173.2' => 'Sigma APO Macro 150mm f/2.8 EX DG HSM',
            174 => 'Canon EF 135mm f/2L or Other Lens',
            '174.1' => 'Sigma 70-200mm f/2.8 EX DG APO OS HSM',
            '174.2' => 'Sigma 50-500mm f/4.5-6.3 APO DG OS HSM',
            '174.3' => 'Sigma 150-500mm f/5-6.3 APO DG OS HSM',
            '174.4' => 'Zeiss Milvus 100mm f/2 Makro',
            175 => 'Canon EF 400mm f/2.8L',
            176 => 'Canon EF 24-85mm f/3.5-4.5 USM',
            177 => 'Canon EF 300mm f/4L IS',
            178 => 'Canon EF 28-135mm f/3.5-5.6 IS',
            179 => 'Canon EF 24mm f/1.4L',
            180 => 'Canon EF 35mm f/1.4L or Other Lens',
            '180.1' => 'Sigma 50mm f/1.4 DG HSM | A',
            '180.2' => 'Sigma 24mm f/1.4 DG HSM | A',
            '180.3' => 'Zeiss Milvus 50mm f/1.4',
            '180.4' => 'Zeiss Milvus 85mm f/1.4',
            '180.5' => 'Zeiss Otus 28mm f/1.4 ZE',
            181 => 'Canon EF 100-400mm f/4.5-5.6L IS + 1.4x or Sigma Lens',
            '181.1' => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S + 1.4x',
            182 => 'Canon EF 100-400mm f/4.5-5.6L IS + 2x or Sigma Lens',
            '182.1' => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S + 2x',
            183 => 'Canon EF 100-400mm f/4.5-5.6L IS or Sigma Lens',
            '183.1' => 'Sigma 150mm f/2.8 EX DG OS HSM APO Macro',
            '183.2' => 'Sigma 105mm f/2.8 EX DG OS HSM Macro',
            '183.3' => 'Sigma 180mm f/2.8 EX DG OS HSM APO Macro',
            '183.4' => 'Sigma 150-600mm f/5-6.3 DG OS HSM | C',
            '183.5' => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S',
            '183.6' => 'Sigma 100-400mm f/5-6.3 DG OS HSM',
            184 => 'Canon EF 400mm f/2.8L + 2x',
            185 => 'Canon EF 600mm f/4L IS',
            186 => 'Canon EF 70-200mm f/4L',
            187 => 'Canon EF 70-200mm f/4L + 1.4x',
            188 => 'Canon EF 70-200mm f/4L + 2x',
            189 => 'Canon EF 70-200mm f/4L + 2.8x',
            190 => 'Canon EF 100mm f/2.8 Macro USM',
            191 => 'Canon EF 400mm f/4 DO IS',
            193 => 'Canon EF 35-80mm f/4-5.6 USM',
            194 => 'Canon EF 80-200mm f/4.5-5.6 USM',
            195 => 'Canon EF 35-105mm f/4.5-5.6 USM',
            196 => 'Canon EF 75-300mm f/4-5.6 USM',
            197 => 'Canon EF 75-300mm f/4-5.6 IS USM or Sigma Lens',
            '197.1' => 'Sigma 18-300mm f/3.5-6.3 DC Macro OS HS',
            198 => 'Canon EF 50mm f/1.4 USM or Zeiss Lens',
            '198.1' => 'Zeiss Otus 55mm f/1.4 ZE',
            '198.2' => 'Zeiss Otus 85mm f/1.4 ZE',
            199 => 'Canon EF 28-80mm f/3.5-5.6 USM',
            200 => 'Canon EF 75-300mm f/4-5.6 USM',
            201 => 'Canon EF 28-80mm f/3.5-5.6 USM',
            202 => 'Canon EF 28-80mm f/3.5-5.6 USM IV',
            208 => 'Canon EF 22-55mm f/4-5.6 USM',
            209 => 'Canon EF 55-200mm f/4.5-5.6',
            210 => 'Canon EF 28-90mm f/4-5.6 USM',
            211 => 'Canon EF 28-200mm f/3.5-5.6 USM',
            212 => 'Canon EF 28-105mm f/4-5.6 USM',
            213 => 'Canon EF 90-300mm f/4.5-5.6 USM or Tamron Lens',
            '213.1' => 'Tamron SP 150-600mm f/5-6.3 Di VC USD',
            '213.2' => 'Tamron 16-300mm f/3.5-6.3 Di II VC PZD Macro',
            '213.3' => 'Tamron SP 35mm f/1.8 Di VC USD',
            '213.4' => 'Tamron SP 45mm f/1.8 Di VC USD',
            214 => 'Canon EF-S 18-55mm f/3.5-5.6 USM',
            215 => 'Canon EF 55-200mm f/4.5-5.6 II USM',
            217 => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD',
            224 => 'Canon EF 70-200mm f/2.8L IS',
            225 => 'Canon EF 70-200mm f/2.8L IS + 1.4x',
            226 => 'Canon EF 70-200mm f/2.8L IS + 2x',
            227 => 'Canon EF 70-200mm f/2.8L IS + 2.8x',
            228 => 'Canon EF 28-105mm f/3.5-4.5 USM',
            229 => 'Canon EF 16-35mm f/2.8L',
            230 => 'Canon EF 24-70mm f/2.8L',
            231 => 'Canon EF 17-40mm f/4L',
            232 => 'Canon EF 70-300mm f/4.5-5.6 DO IS USM',
            233 => 'Canon EF 28-300mm f/3.5-5.6L IS',
            234 => 'Canon EF-S 17-85mm f/4-5.6 IS USM or Tokina Lens',
            '234.1' => 'Tokina AT-X 12-28 PRO DX 12-28mm f/4',
            235 => 'Canon EF-S 10-22mm f/3.5-4.5 USM',
            236 => 'Canon EF-S 60mm f/2.8 Macro USM',
            237 => 'Canon EF 24-105mm f/4L IS',
            238 => 'Canon EF 70-300mm f/4-5.6 IS USM',
            239 => 'Canon EF 85mm f/1.2L II',
            240 => 'Canon EF-S 17-55mm f/2.8 IS USM',
            241 => 'Canon EF 50mm f/1.2L',
            242 => 'Canon EF 70-200mm f/4L IS',
            243 => 'Canon EF 70-200mm f/4L IS + 1.4x',
            244 => 'Canon EF 70-200mm f/4L IS + 2x',
            245 => 'Canon EF 70-200mm f/4L IS + 2.8x',
            246 => 'Canon EF 16-35mm f/2.8L II',
            247 => 'Canon EF 14mm f/2.8L II USM',
            248 => 'Canon EF 200mm f/2L IS or Sigma Lens',
            '248.1' => 'Sigma 24-35mm f/2 DG HSM | A',
            249 => 'Canon EF 800mm f/5.6L IS',
            250 => 'Canon EF 24mm f/1.4L II or Sigma Lens',
            '250.1' => 'Sigma 20mm f/1.4 DG HSM | A',
            251 => 'Canon EF 70-200mm f/2.8L IS II USM',
            252 => 'Canon EF 70-200mm f/2.8L IS II USM + 1.4x',
            253 => 'Canon EF 70-200mm f/2.8L IS II USM + 2x',
            254 => 'Canon EF 100mm f/2.8L Macro IS USM',
            255 => 'Sigma 24-105mm f/4 DG OS HSM | A or Other Sigma Lens',
            '255.1' => 'Sigma 180mm f/2.8 EX DG OS HSM APO Macro',
            488 => 'Canon EF-S 15-85mm f/3.5-5.6 IS USM',
            489 => 'Canon EF 70-300mm f/4-5.6L IS USM',
            490 => 'Canon EF 8-15mm f/4L Fisheye USM',
            491 => 'Canon EF 300mm f/2.8L IS II USM or Tamron Lens',
            '491.1' => 'Tamron SP 70-200mm F/2.8 Di VC USD G2 (A025)',
            '491.2' => 'Tamron 18-400mm F/3.5-6.3 Di II VC HLD (B028)',
            492 => 'Canon EF 400mm f/2.8L IS II USM',
            493 => 'Canon EF 500mm f/4L IS II USM or EF 24-105mm f4L IS USM',
            '493.1' => 'Canon EF 24-105mm f/4L IS USM',
            494 => 'Canon EF 600mm f/4.0L IS II USM',
            495 => 'Canon EF 24-70mm f/2.8L II USM or Sigma Lens',
            '495.1' => 'Sigma 24-70mm F2.8 DG OS HSM | A',
            496 => 'Canon EF 200-400mm f/4L IS USM',
            499 => 'Canon EF 200-400mm f/4L IS USM + 1.4x',
            502 => 'Canon EF 28mm f/2.8 IS USM',
            503 => 'Canon EF 24mm f/2.8 IS USM',
            504 => 'Canon EF 24-70mm f/4L IS USM',
            505 => 'Canon EF 35mm f/2 IS USM',
            506 => 'Canon EF 400mm f/4 DO IS II USM',
            507 => 'Canon EF 16-35mm f/4L IS USM',
            508 => 'Canon EF 11-24mm f/4L USM or Tamron Lens',
            '508.1' => 'Tamron 10-24mm f/3.5-4.5 Di II VC HLD',
            747 => 'Canon EF 100-400mm f/4.5-5.6L IS II USM or Tamron Lens',
            '747.1' => 'Tamron SP 150-600mm F5-6.3 Di VC USD G2',
            748 => 'Canon EF 100-400mm f/4.5-5.6L IS II USM + 1.4x',
            750 => 'Canon EF 35mm f/1.4L II USM',
            751 => 'Canon EF 16-35mm f/2.8L III USM',
            752 => 'Canon EF 24-105mm f/4L IS II USM',
            4142 => 'Canon EF-S 18-135mm f/3.5-5.6 IS STM',
            4143 => 'Canon EF-M 18-55mm f/3.5-5.6 IS STM or Tamron Lens',
            '4143.1' => 'Tamron 18-200mm F/3.5-6.3 Di III VC',
            4144 => 'Canon EF 40mm f/2.8 STM',
            4145 => 'Canon EF-M 22mm f/2 STM',
            4146 => 'Canon EF-S 18-55mm f/3.5-5.6 IS STM',
            4147 => 'Canon EF-M 11-22mm f/4-5.6 IS STM',
            4148 => 'Canon EF-S 55-250mm f/4-5.6 IS STM',
            4149 => 'Canon EF-M 55-200mm f/4.5-6.3 IS STM',
            4150 => 'Canon EF-S 10-18mm f/4.5-5.6 IS STM',
            4152 => 'Canon EF 24-105mm f/3.5-5.6 IS STM',
            4153 => 'Canon EF-M 15-45mm f/3.5-6.3 IS STM',
            4154 => 'Canon EF-S 24mm f/2.8 STM',
            4155 => 'Canon EF-M 28mm f/3.5 Macro IS STM',
            4156 => 'Canon EF 50mm f/1.8 STM',
            4157 => 'Canon EF-M 18-150mm 1:3.5-6.3 IS STM',
            4158 => 'Canon EF-S 18-55mm f/4-5.6 IS STM',
            4160 => 'Canon EF-S 35mm f/2.8 Macro IS STM',
            36910 => 'Canon EF 70-300mm f/4-5.6 IS II USM',
            36912 => 'Canon EF-S 18-135mm f/3.5-5.6 IS USM',
            61494 => 'Canon CN-E 85mm T1.3 L F',
          ),
        ),
      ),
      23 =>
      array (
        'const' => 'CANON_CS_LENS',
        'name' => 'LongFocalLength',
        'title' => 'Long Focal Length',
      ),
      24 =>
      array (
        'const' => 'CANON_CS_SHORT_FOCAL',
        'name' => 'ShortFocalLength',
        'title' => 'Short Focal Length',
      ),
      25 =>
      array (
        'const' => 'CANON_CS_FOCAL_UNITS',
        'name' => 'FocalUnits',
        'title' => 'Focal Units',
      ),
      26 =>
      array (
        'const' => 'CANON_CS_MAX_APERTURE',
        'name' => 'MaxAperture',
        'title' => 'Max Aperture',
      ),
      27 =>
      array (
        'const' => 'CANON_CS_MIN_APERTURE',
        'name' => 'MinAperture',
        'title' => 'Min Aperture',
      ),
      28 =>
      array (
        'const' => 'CANON_CS_FLASH_ACTIVITY',
        'name' => 'FlashActivity',
        'title' => 'Flash Activity',
      ),
      29 =>
      array (
        'const' => 'CANON_CS_FLASH_DETAILS',
        'name' => 'FlashDetails',
        'title' => 'Flash Details',
      ),
      32 =>
      array (
        'const' => 'CANON_CS_FOCUS_CONTINUOUS',
        'name' => 'FocusContinuous',
        'title' => 'Focus Continuous',
      ),
      33 =>
      array (
        'const' => 'CANON_CS_AE_SETTING',
        'name' => 'AESetting',
        'title' => 'AE Setting',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal AE',
            1 => 'Exposure Compensation',
            2 => 'AE Lock',
            3 => 'AE Lock + Exposure Comp.',
            4 => 'No AE',
          ),
        ),
      ),
      34 =>
      array (
        'const' => 'CANON_CS_IMAGE_STABILIZATION',
        'name' => 'ImageStabilization',
        'title' => 'Image Stabilization',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On',
            2 => 'Shoot Only',
            3 => 'Panning',
            4 => 'Dynamic',
            256 => 'Off (2)',
            257 => 'On (2)',
            258 => 'Shoot Only (2)',
            259 => 'Panning (2)',
            260 => 'Dynamic (2)',
          ),
        ),
      ),
      35 =>
      array (
        'const' => 'CANON_CS_DISPLAY_APERTURE',
        'name' => 'DisplayAperture',
        'title' => 'Display Aperture',
      ),
      36 =>
      array (
        'const' => 'CANON_CS_ZOOM_SOURCE_WIDTH',
        'name' => 'ZoomSourceWidth',
        'title' => 'Zoom Source Width',
      ),
      37 =>
      array (
        'const' => 'CANON_CS_ZOOM_TARGET_WIDTH',
        'name' => 'ZoomTargetWidth',
        'title' => 'Zoom Target Width',
      ),
      39 =>
      array (
        'const' => 'CANON_CS_SPOT_METERING_MODE',
        'name' => 'SpotMeteringMode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Center',
            1 => 'AF Point',
          ),
        ),
      ),
      40 =>
      array (
        'const' => 'CANON_CS_PHOTO_EFFECT',
        'name' => 'PhotoEffect',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'Vivid',
            2 => 'Neutral',
            3 => 'Smooth',
            4 => 'Sepia',
            5 => 'B&W',
            6 => 'Custom',
            100 => 'My Color Data',
          ),
        ),
      ),
      41 =>
      array (
        'const' => 'CANON_CS_MANUAL_FLASH_OUTPUT',
        'name' => 'ManualFlashOutput',
        'title' => 'Manual Flash Output',
        'text' =>
        array (
          'mapping' =>
          array (
            1280 => 'Full',
            1282 => 'Medium',
            1284 => 'Low',
          ),
        ),
      ),
      42 =>
      array (
        'const' => 'CANON_CS_COLOR_TONE',
        'name' => 'ColorTone',
        'title' => 'Color Tone',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Normal',
          ),
        ),
      ),
      46 =>
      array (
        'const' => 'CANON_CS_SRAW_QUALITY',
        'name' => 'SRAWQuality',
        'title' => 'SRAW Quality',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'sRAW1 (mRAW)',
            2 => 'sRAW2 (sRAW)',
          ),
        ),
      ),
    ),
    10 =>
    array (
      1 =>
      array (
        'const' => 'CANON_FI_FILE_NUMBER',
        'name' => 'FileNumber',
        'title' => 'File Number',
      ),
      3 =>
      array (
        'const' => 'CANON_FI_BRACKET_MODE',
        'name' => 'BracketMode',
        'title' => 'Bracket Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'AEB',
            2 => 'FEB',
            3 => 'ISO',
            4 => 'WB',
          ),
        ),
      ),
      4 =>
      array (
        'const' => 'CANON_FI_BRACKET_VALUE',
        'name' => 'BracketValue',
        'title' => 'Bracket Value',
      ),
      5 =>
      array (
        'const' => 'CANON_FI_BRACKET_SHOT_NUMBER',
        'name' => 'BracketShotNumber',
        'title' => 'Bracket Shot Number',
      ),
      6 =>
      array (
        'const' => 'CANON_FI_RAW_JPG_QUALITY',
        'name' => 'RawJpgQuality',
        'title' => 'Raw Jpg Quality',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Economy',
            2 => 'Normal',
            3 => 'Fine',
            4 => 'RAW',
            5 => 'Superfine',
            130 => 'Normal Movie',
            131 => 'Movie (2)',
          ),
        ),
      ),
      7 =>
      array (
        'const' => 'CANON_FI_RAW_JPG_SIZE',
        'name' => 'RawJpgSize',
        'title' => 'Raw Jpg Size',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Large',
            1 => 'Medium',
            2 => 'Small',
            5 => 'Medium 1',
            6 => 'Medium 2',
            7 => 'Medium 3',
            8 => 'Postcard',
            9 => 'Widescreen',
            10 => 'Medium Widescreen',
            14 => 'Small 1',
            15 => 'Small 2',
            16 => 'Small 3',
            128 => '640x480 Movie',
            129 => 'Medium Movie',
            130 => 'Small Movie',
            137 => '1280x720 Movie',
            142 => '1920x1080 Movie',
          ),
        ),
      ),
      8 =>
      array (
        'const' => 'CANON_FI_NOISE_REDUCTION',
        'name' => 'NoiseReduction',
        'title' => 'Noise Reduction',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On (1D)',
            3 => 'On',
            4 => 'Auto',
          ),
        ),
      ),
      9 =>
      array (
        'const' => 'CANON_FI_WB_BRACKET_MODE',
        'name' => 'WBBracketMode',
        'title' => 'WB Bracket Mode',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On (shift AB)',
            2 => 'On (shift GM)',
          ),
        ),
      ),
      12 =>
      array (
        'const' => 'CANON_FI_WB_BRACKET_VALUE_AB',
        'name' => 'WBBracketValueAB',
        'title' => 'WB Bracket Value AB',
      ),
      13 =>
      array (
        'const' => 'CANON_FI_WB_BRACKET_VALUE_GM',
        'name' => 'WBBracketValueGM',
        'title' => 'WB Bracket Value GM',
      ),
      14 =>
      array (
        'const' => 'CANON_FI_FILTER_EFFECT',
        'name' => 'FilterEffect',
        'title' => 'Filter Effect',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'None',
            1 => 'Yellow',
            2 => 'Orange',
            3 => 'Red',
            4 => 'Green',
          ),
        ),
      ),
      15 =>
      array (
        'const' => 'CANON_FI_TONING_EFFECT',
        'name' => 'ToningEffect',
        'title' => 'Toning Effect',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'None',
            1 => 'Sepia',
            2 => 'Blue',
            3 => 'Purple',
            4 => 'Green',
          ),
        ),
      ),
      16 =>
      array (
        'const' => 'CANON_FI_MACRO_MAGNIFICATION',
        'name' => 'MacroMagnification',
        'title' => 'Macro Magnification',
      ),
      19 =>
      array (
        'const' => 'CANON_FI_LIVE_VIEW_SHOOTING',
        'name' => 'LiveViewShooting',
        'title' => 'Live View Shooting',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On',
          ),
        ),
      ),
      20 =>
      array (
        'const' => 'CANON_FI_FOCUS_DISTANCE_UPPER',
        'name' => 'FocusDistanceUpper',
        'title' => 'Focus Distance Upper',
      ),
      21 =>
      array (
        'const' => 'CANON_FI_FOCUS_DISTANCE_LOWER',
        'name' => 'FocusDistanceLower',
        'title' => 'Focus Distance Lower',
      ),
      25 =>
      array (
        'const' => 'CANON_FI_FLASH_EXPOSURE_LOCK',
        'name' => 'FlashExposureLock',
        'title' => 'Flash Exposure Lock',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On',
          ),
        ),
      ),
    ),
    7 =>
    array (
      2 =>
      array (
        'const' => 'CANON_SI_ISO_SPEED',
        'name' => 'ISOSpeedUsed',
        'title' => 'ISO Speed Used',
      ),
      3 =>
      array (
        'const' => 'CANON_SI_MEASURED_EV',
        'name' => 'MeasuredEV',
        'title' => 'Measured EV',
      ),
      4 =>
      array (
        'const' => 'CANON_SI_TARGET_APERTURE',
        'name' => 'TargetAperture',
        'title' => 'Target Aperture',
      ),
      5 =>
      array (
        'const' => 'CANON_SI_TARGET_SHUTTER_SPEED',
        'name' => 'TargetShutterSpeed',
        'title' => 'Target Shutter Speed',
      ),
      7 =>
      array (
        'const' => 'CANON_SI_WHITE_BALANCE',
        'name' => 'WhiteBalanceSetting',
        'title' => 'White Balance Setting',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Auto',
            1 => 'Daylight',
            2 => 'Cloudy',
            3 => 'Tungsten',
            4 => 'Fluorescent',
            5 => 'Flash',
            6 => 'Custom',
            7 => 'Black & White',
            8 => 'Shade',
            9 => 'Manual Temperature (Kelvin)',
            10 => 'PC Set1',
            11 => 'PC Set2',
            12 => 'PC Set3',
            14 => 'Daylight Fluorescent',
            15 => 'Custom 1',
            16 => 'Custom 2',
            17 => 'Underwater',
            18 => 'Custom 3',
            19 => 'Custom 4',
            20 => 'PC Set4',
            21 => 'PC Set5',
            23 => 'Auto (ambience priority)',
          ),
        ),
      ),
      8 =>
      array (
        'const' => 'CANON_SI_SLOW_SHUTTER',
        'name' => 'SlowShutter',
        'title' => 'Slow Shutter',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'Night Scene',
            2 => 'On',
            3 => 'None',
          ),
        ),
      ),
      9 =>
      array (
        'const' => 'CANON_SI_SEQUENCE',
        'name' => 'SequenceNumber',
        'title' => 'Sequence Number',
      ),
      14 =>
      array (
        'const' => 'CANON_SI_AF_POINT_USED',
        'name' => 'AFPointUsed',
        'title' => 'AF Point Used',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            12288 => 'None (MF)',
            12289 => 'Right',
            12290 => 'Center',
            12291 => 'Center+Right',
            12292 => 'Left',
            12293 => 'Left+Right',
            12294 => 'Left+Center',
            12295 => 'All',
          ),
        ),
      ),
      15 =>
      array (
        'const' => 'CANON_SI_FLASH_BIAS',
        'name' => 'FlashBias',
        'title' => 'Flash Bias',
      ),
      16 =>
      array (
        'const' => 'CANON_SI_AUTO_EXPOSURE_BRACKETING',
        'name' => 'AutoExposureBracketing',
        'title' => 'Auto Exposure Bracketing',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            -1 => 'On',
            0 => 'Off',
            1 => 'On (shot 1)',
            2 => 'On (shot 2)',
            3 => 'On (shot 3)',
          ),
        ),
      ),
      19 =>
      array (
        'const' => 'CANON_SI_SUBJECT_DISTANCE',
        'name' => 'SubjectDistance',
        'title' => 'Subject Distance',
      ),
      21 =>
      array (
        'const' => 'CANON_SI_APERTURE_VALUE',
        'name' => 'Aperture',
        'title' => 'Aperture',
      ),
      22 =>
      array (
        'const' => 'CANON_SI_SHUTTER_SPEED_VALUE',
        'name' => 'ShutterSpeed',
        'title' => 'Shutter Speed',
      ),
      23 =>
      array (
        'const' => 'CANON_SI_MEASURED_EV2',
        'name' => 'MeasuredEV2',
        'title' => 'Measured EV 2',
      ),
      26 =>
      array (
        'const' => 'CANON_SI_CAMERA_TYPE',
        'name' => 'CameraType',
        'title' => 'Camera Type',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            248 => 'EOS High-end',
            250 => 'Compact',
            252 => 'EOS Mid-range',
            255 => 'DV Camera',
          ),
        ),
      ),
      27 =>
      array (
        'const' => 'CANON_SI_AUTO_ROTATE',
        'name' => 'AutoRotate',
        'title' => 'Auto Rotate',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'None',
            1 => 'Rotate 90 CW',
            2 => 'Rotate 180',
            3 => 'Rotate 270 CW',
          ),
        ),
      ),
      28 =>
      array (
        'const' => 'CANON_SI_ND_FILTER',
        'name' => 'NDFilter',
        'title' => 'ND Filter',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Off',
            1 => 'On',
          ),
        ),
      ),
    ),
    8 =>
    array (
      2 =>
      array (
        'const' => 'CANON_PA_PANORAMA_FRAME',
        'name' => 'PanoramaFrame',
        'title' => 'Panorama Frame',
      ),
      5 =>
      array (
        'const' => 'CANON_PA_PANORAMA_DIRECTION',
        'name' => 'PanoramaDirection',
        'title' => 'Panorama Direction',
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            0 => 'Left to Right',
            1 => 'Right to Left',
            2 => 'Bottom to Top',
            3 => 'Top to Bottom',
            4 => '2x2 Matrix (Clockwise)',
          ),
        ),
      ),
    ),
    0 =>
    array (
      256 =>
      array (
        'const' => 'IMAGE_WIDTH',
        'name' => 'ImageWidth',
        'title' => 'Image Width',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      257 =>
      array (
        'const' => 'IMAGE_LENGTH',
        'name' => 'ImageLength',
        'title' => 'Image Length',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      258 =>
      array (
        'const' => 'BITS_PER_SAMPLE',
        'name' => 'BitsPerSample',
        'title' => 'Bits per Sample',
        'components' => 3,
        'format' => 'Short',
      ),
      259 =>
      array (
        'const' => 'COMPRESSION',
        'name' => 'Compression',
        'title' => 'Compression',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Uncompressed',
            6 => 'JPEG compression',
          ),
        ),
      ),
      262 =>
      array (
        'const' => 'PHOTOMETRIC_INTERPRETATION',
        'name' => 'PhotometricInterpretation',
        'title' => 'Photometric Interpretation',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            2 => 'RGB',
            6 => 'YCbCr',
          ),
        ),
      ),
      269 =>
      array (
        'const' => 'DOCUMENT_NAME',
        'name' => 'DocumentName',
        'title' => 'Document Name',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      270 =>
      array (
        'const' => 'IMAGE_DESCRIPTION',
        'name' => 'ImageDescription',
        'title' => 'Image Description',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      271 =>
      array (
        'const' => 'MAKE',
        'name' => 'Make',
        'title' => 'Manufacturer',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      272 =>
      array (
        'const' => 'MODEL',
        'name' => 'Model',
        'title' => 'Model',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      273 =>
      array (
        'const' => 'STRIP_OFFSETS',
        'name' => 'StripOffsets',
        'title' => 'Strip Offsets',
        'components' => 'Any',
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      274 =>
      array (
        'const' => 'ORIENTATION',
        'name' => 'Orientation',
        'title' => 'Orientation',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'top - left',
            2 => 'top - right',
            3 => 'bottom - right',
            4 => 'bottom - left',
            5 => 'left - top',
            6 => 'right - top',
            7 => 'right - bottom',
            8 => 'left - bottom',
          ),
        ),
      ),
      277 =>
      array (
        'const' => 'SAMPLES_PER_PIXEL',
        'name' => 'SamplesPerPixel',
        'title' => 'Samples per Pixel',
        'components' => 1,
        'format' => 'Short',
      ),
      278 =>
      array (
        'const' => 'ROWS_PER_STRIP',
        'name' => 'RowsPerStrip',
        'title' => 'Rows per Strip',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      279 =>
      array (
        'const' => 'STRIP_BYTE_COUNTS',
        'name' => 'StripByteCounts',
        'title' => 'Strip Byte Count',
        'components' => 'Any',
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      282 =>
      array (
        'const' => 'X_RESOLUTION',
        'name' => 'XResolution',
        'title' => 'x-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      283 =>
      array (
        'const' => 'Y_RESOLUTION',
        'name' => 'YResolution',
        'title' => 'y-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      284 =>
      array (
        'const' => 'PLANAR_CONFIGURATION',
        'name' => 'PlanarConfiguration',
        'title' => 'Planar Configuration',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'chunky format',
            2 => 'planar format',
          ),
        ),
      ),
      296 =>
      array (
        'const' => 'RESOLUTION_UNIT',
        'name' => 'ResolutionUnit',
        'title' => 'Resolution Unit',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            2 => 'Inch',
            3 => 'Centimeter',
          ),
        ),
      ),
      301 =>
      array (
        'const' => 'TRANSFER_FUNCTION',
        'name' => 'TransferFunction',
        'title' => 'Transfer Function',
        'components' => 3,
        'format' => 'Short',
      ),
      305 =>
      array (
        'const' => 'SOFTWARE',
        'name' => 'Software',
        'title' => 'Software',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      306 =>
      array (
        'const' => 'DATE_TIME',
        'name' => 'DateTime',
        'title' => 'Date and Time',
        'components' => 20,
        'format' => 'Time',
      ),
      315 =>
      array (
        'const' => 'ARTIST',
        'name' => 'Artist',
        'title' => 'Artist',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      318 =>
      array (
        'const' => 'WHITE_POINT',
        'name' => 'WhitePoint',
        'title' => 'White Point',
        'components' => 2,
        'format' => 'Rational',
      ),
      319 =>
      array (
        'const' => 'PRIMARY_CHROMATICITIES',
        'name' => 'PrimaryChromaticities',
        'title' => 'Primary Chromaticities',
        'components' => 6,
        'format' => 'Rational',
      ),
      513 =>
      array (
        'const' => 'JPEG_INTERCHANGE_FORMAT',
        'name' => 'JPEGInterchangeFormat',
        'title' => 'JPEG Interchange Format',
        'components' => 1,
        'format' => 'Long',
      ),
      514 =>
      array (
        'const' => 'JPEG_INTERCHANGE_FORMAT_LENGTH',
        'name' => 'JPEGInterchangeFormatLength',
        'title' => 'JPEG Interchange Format Length',
        'components' => 1,
        'format' => 'Long',
      ),
      529 =>
      array (
        'const' => 'YCBCR_COEFFICIENTS',
        'name' => 'YCbCrCoefficients',
        'title' => 'YCbCr Coefficients',
        'components' => 3,
        'format' => 'Rational',
      ),
      530 =>
      array (
        'const' => 'YCBCR_SUB_SAMPLING',
        'name' => 'YCbCrSubSampling',
        'title' => 'YCbCr Sub-Sampling',
        'components' => 2,
        'format' => 'Short',
        'text' =>
        array (
          'decode' => 'PelEntryShort::decodeYCbCrSubSampling',
        ),
      ),
      531 =>
      array (
        'const' => 'YCBCR_POSITIONING',
        'name' => 'YCbCrPositioning',
        'title' => 'YCbCr Positioning',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'centered',
            2 => 'co-sited',
          ),
        ),
      ),
      532 =>
      array (
        'const' => 'REFERENCE_BLACK_WHITE',
        'name' => 'ReferenceBlackWhite',
        'title' => 'Reference Black/White',
        'components' => 6,
        'format' => 'Rational',
      ),
      18246 =>
      array (
        'const' => 'RATING',
        'name' => 'Rating',
        'title' => 'Star Rating',
        'components' => 1,
        'format' => 'Short',
      ),
      18249 =>
      array (
        'const' => 'RATING_PERCENT',
        'name' => 'RatingPercent',
        'title' => 'Percent Rating',
        'components' => 1,
        'format' => 'Short',
      ),
      33432 =>
      array (
        'const' => 'COPYRIGHT',
        'name' => 'Copyright',
        'title' => 'Copyright',
        'components' => 'Any',
        'format' => 'Copyright',
      ),
      34665 =>
      array (
        'const' => 'EXIF_IFD_POINTER',
        'name' => 'ExifIFDPointer',
        'title' => 'Exif IFD Pointer',
        'ifd' => 2,
      ),
      34853 =>
      array (
        'const' => 'GPS_INFO_IFD_POINTER',
        'name' => 'GPSInfoIFDPointer',
        'title' => 'GPS Info IFD Pointer',
        'ifd' => 3,
      ),
      40091 =>
      array (
        'const' => 'WINDOWS_XP_TITLE',
        'name' => 'WindowsXPTitle',
        'title' => 'Windows XP Title',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40092 =>
      array (
        'const' => 'WINDOWS_XP_COMMENT',
        'name' => 'WindowsXPComment',
        'title' => 'Windows XP Comment',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40093 =>
      array (
        'const' => 'WINDOWS_XP_AUTHOR',
        'name' => 'WindowsXPAuthor',
        'title' => 'Windows XP Author',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40094 =>
      array (
        'const' => 'WINDOWS_XP_KEYWORDS',
        'name' => 'WindowsXPKeywords',
        'title' => 'Windows XP Keywords',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40095 =>
      array (
        'const' => 'WINDOWS_XP_SUBJECT',
        'name' => 'WindowsXPSubject',
        'title' => 'Windows XP Subject',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      50341 =>
      array (
        'const' => 'PRINT_IM',
        'name' => 'PrintIM',
        'title' => 'Print IM',
        'components' => 'Unknown',
        'format' => 'Undefined',
      ),
    ),
    1 =>
    array (
      256 =>
      array (
        'const' => 'IMAGE_WIDTH',
        'name' => 'ImageWidth',
        'title' => 'Image Width',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      257 =>
      array (
        'const' => 'IMAGE_LENGTH',
        'name' => 'ImageLength',
        'title' => 'Image Length',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      258 =>
      array (
        'const' => 'BITS_PER_SAMPLE',
        'name' => 'BitsPerSample',
        'title' => 'Bits per Sample',
        'components' => 3,
        'format' => 'Short',
      ),
      259 =>
      array (
        'const' => 'COMPRESSION',
        'name' => 'Compression',
        'title' => 'Compression',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'Uncompressed',
            6 => 'JPEG compression',
          ),
        ),
      ),
      262 =>
      array (
        'const' => 'PHOTOMETRIC_INTERPRETATION',
        'name' => 'PhotometricInterpretation',
        'title' => 'Photometric Interpretation',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            2 => 'RGB',
            6 => 'YCbCr',
          ),
        ),
      ),
      269 =>
      array (
        'const' => 'DOCUMENT_NAME',
        'name' => 'DocumentName',
        'title' => 'Document Name',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      270 =>
      array (
        'const' => 'IMAGE_DESCRIPTION',
        'name' => 'ImageDescription',
        'title' => 'Image Description',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      271 =>
      array (
        'const' => 'MAKE',
        'name' => 'Make',
        'title' => 'Manufacturer',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      272 =>
      array (
        'const' => 'MODEL',
        'name' => 'Model',
        'title' => 'Model',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      273 =>
      array (
        'const' => 'STRIP_OFFSETS',
        'name' => 'StripOffsets',
        'title' => 'Strip Offsets',
        'components' => 'Any',
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      274 =>
      array (
        'const' => 'ORIENTATION',
        'name' => 'Orientation',
        'title' => 'Orientation',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'top - left',
            2 => 'top - right',
            3 => 'bottom - right',
            4 => 'bottom - left',
            5 => 'left - top',
            6 => 'right - top',
            7 => 'right - bottom',
            8 => 'left - bottom',
          ),
        ),
      ),
      277 =>
      array (
        'const' => 'SAMPLES_PER_PIXEL',
        'name' => 'SamplesPerPixel',
        'title' => 'Samples per Pixel',
        'components' => 1,
        'format' => 'Short',
      ),
      278 =>
      array (
        'const' => 'ROWS_PER_STRIP',
        'name' => 'RowsPerStrip',
        'title' => 'Rows per Strip',
        'components' => 1,
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      279 =>
      array (
        'const' => 'STRIP_BYTE_COUNTS',
        'name' => 'StripByteCounts',
        'title' => 'Strip Byte Count',
        'components' => 'Any',
        'format' =>
        array (
          0 => 'Short',
          1 => 'Long',
        ),
      ),
      282 =>
      array (
        'const' => 'X_RESOLUTION',
        'name' => 'XResolution',
        'title' => 'x-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      283 =>
      array (
        'const' => 'Y_RESOLUTION',
        'name' => 'YResolution',
        'title' => 'y-Resolution',
        'components' => 1,
        'format' => 'Rational',
      ),
      284 =>
      array (
        'const' => 'PLANAR_CONFIGURATION',
        'name' => 'PlanarConfiguration',
        'title' => 'Planar Configuration',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'chunky format',
            2 => 'planar format',
          ),
        ),
      ),
      296 =>
      array (
        'const' => 'RESOLUTION_UNIT',
        'name' => 'ResolutionUnit',
        'title' => 'Resolution Unit',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            2 => 'Inch',
            3 => 'Centimeter',
          ),
        ),
      ),
      301 =>
      array (
        'const' => 'TRANSFER_FUNCTION',
        'name' => 'TransferFunction',
        'title' => 'Transfer Function',
        'components' => 3,
        'format' => 'Short',
      ),
      305 =>
      array (
        'const' => 'SOFTWARE',
        'name' => 'Software',
        'title' => 'Software',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      306 =>
      array (
        'const' => 'DATE_TIME',
        'name' => 'DateTime',
        'title' => 'Date and Time',
        'components' => 20,
        'format' => 'Time',
      ),
      315 =>
      array (
        'const' => 'ARTIST',
        'name' => 'Artist',
        'title' => 'Artist',
        'components' => 'Any',
        'format' => 'Ascii',
      ),
      318 =>
      array (
        'const' => 'WHITE_POINT',
        'name' => 'WhitePoint',
        'title' => 'White Point',
        'components' => 2,
        'format' => 'Rational',
      ),
      319 =>
      array (
        'const' => 'PRIMARY_CHROMATICITIES',
        'name' => 'PrimaryChromaticities',
        'title' => 'Primary Chromaticities',
        'components' => 6,
        'format' => 'Rational',
      ),
      513 =>
      array (
        'const' => 'JPEG_INTERCHANGE_FORMAT',
        'name' => 'JPEGInterchangeFormat',
        'title' => 'JPEG Interchange Format',
        'components' => 1,
        'format' => 'Long',
      ),
      514 =>
      array (
        'const' => 'JPEG_INTERCHANGE_FORMAT_LENGTH',
        'name' => 'JPEGInterchangeFormatLength',
        'title' => 'JPEG Interchange Format Length',
        'components' => 1,
        'format' => 'Long',
      ),
      529 =>
      array (
        'const' => 'YCBCR_COEFFICIENTS',
        'name' => 'YCbCrCoefficients',
        'title' => 'YCbCr Coefficients',
        'components' => 3,
        'format' => 'Rational',
      ),
      530 =>
      array (
        'const' => 'YCBCR_SUB_SAMPLING',
        'name' => 'YCbCrSubSampling',
        'title' => 'YCbCr Sub-Sampling',
        'components' => 2,
        'format' => 'Short',
        'text' =>
        array (
          'decode' => 'PelEntryShort::decodeYCbCrSubSampling',
        ),
      ),
      531 =>
      array (
        'const' => 'YCBCR_POSITIONING',
        'name' => 'YCbCrPositioning',
        'title' => 'YCbCr Positioning',
        'components' => 1,
        'format' => 'Short',
        'text' =>
        array (
          'mapping' =>
          array (
            1 => 'centered',
            2 => 'co-sited',
          ),
        ),
      ),
      532 =>
      array (
        'const' => 'REFERENCE_BLACK_WHITE',
        'name' => 'ReferenceBlackWhite',
        'title' => 'Reference Black/White',
        'components' => 6,
        'format' => 'Rational',
      ),
      18246 =>
      array (
        'const' => 'RATING',
        'name' => 'Rating',
        'title' => 'Star Rating',
        'components' => 1,
        'format' => 'Short',
      ),
      18249 =>
      array (
        'const' => 'RATING_PERCENT',
        'name' => 'RatingPercent',
        'title' => 'Percent Rating',
        'components' => 1,
        'format' => 'Short',
      ),
      33432 =>
      array (
        'const' => 'COPYRIGHT',
        'name' => 'Copyright',
        'title' => 'Copyright',
        'components' => 'Any',
        'format' => 'Copyright',
      ),
      34665 =>
      array (
        'const' => 'EXIF_IFD_POINTER',
        'name' => 'ExifIFDPointer',
        'title' => 'Exif IFD Pointer',
        'ifd' => 2,
      ),
      34853 =>
      array (
        'const' => 'GPS_INFO_IFD_POINTER',
        'name' => 'GPSInfoIFDPointer',
        'title' => 'GPS Info IFD Pointer',
        'ifd' => 3,
      ),
      40091 =>
      array (
        'const' => 'WINDOWS_XP_TITLE',
        'name' => 'WindowsXPTitle',
        'title' => 'Windows XP Title',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40092 =>
      array (
        'const' => 'WINDOWS_XP_COMMENT',
        'name' => 'WindowsXPComment',
        'title' => 'Windows XP Comment',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40093 =>
      array (
        'const' => 'WINDOWS_XP_AUTHOR',
        'name' => 'WindowsXPAuthor',
        'title' => 'Windows XP Author',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40094 =>
      array (
        'const' => 'WINDOWS_XP_KEYWORDS',
        'name' => 'WindowsXPKeywords',
        'title' => 'Windows XP Keywords',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      40095 =>
      array (
        'const' => 'WINDOWS_XP_SUBJECT',
        'name' => 'WindowsXPSubject',
        'title' => 'Windows XP Subject',
        'components' => 'Any',
        'format' => 'WindowsString',
      ),
      50341 =>
      array (
        'const' => 'PRINT_IM',
        'name' => 'PrintIM',
        'title' => 'Print IM',
        'components' => 'Unknown',
        'format' => 'Undefined',
      ),
    ),
  ),
  'tagsByName' =>
  array (
    9 =>
    array (
      'ImageWidth' => 2,
      'ImageHeight' => 3,
      'ImageWidthAsShot' => 4,
      'ImageHeightAsShot' => 5,
      'AFPointsUsed' => 22,
      'AFPointsUsed(20D)' => 26,
    ),
    4 =>
    array (
      'InteroperabilityIndex' => 1,
      'InteroperabilityVersion' => 2,
      'RelatedImageFileFormat' => 4096,
      'RelatedImageWidth' => 4097,
      'RelatedImageLength' => 4098,
    ),
    3 =>
    array (
      'GPSVersionID' => 0,
      'GPSLatitudeRef' => 1,
      'GPSLatitude' => 2,
      'GPSLongitudeRef' => 3,
      'GPSLongitude' => 4,
      'GPSAltitudeRef' => 5,
      'GPSAltitude' => 6,
      'GPSTimeStamp' => 7,
      'GPSSatellites' => 8,
      'GPSStatus' => 9,
      'GPSMeasureMode' => 10,
      'GPSDOP' => 11,
      'GPSSpeedRef' => 12,
      'GPSSpeed' => 13,
      'GPSTrackRef' => 14,
      'GPSTrack' => 15,
      'GPSImgDirectionRef' => 16,
      'GPSImgDirection' => 17,
      'GPSMapDatum' => 18,
      'GPSDestLatitudeRef' => 19,
      'GPSDestLatitude' => 20,
      'GPSDestLongitudeRef' => 21,
      'GPSDestLongitude' => 22,
      'GPSDestBearingRef' => 23,
      'GPSDestBearing' => 24,
      'GPSDestDistanceRef' => 25,
      'GPSDestDistance' => 26,
      'GPSProcessingMethod' => 27,
      'GPSAreaInformation' => 28,
      'GPSDateStamp' => 29,
      'GPSDifferential' => 30,
    ),
    2 =>
    array (
      'CFAPattern' => 41730,
      'ExposureTime' => 33434,
      'FNumber' => 33437,
      'ExposureProgram' => 34850,
      'SpectralSensitivity' => 34852,
      'ISOSpeedRatings' => 34855,
      'OECF' => 34856,
      'ExifVersion' => 36864,
      'DateTimeOriginal' => 36867,
      'DateTimeDigitized' => 36868,
      'OffsetTime' => 36880,
      'OffsetTimeOriginal' => 36881,
      'OffsetTimeDigitized' => 36882,
      'ComponentsConfiguration' => 37121,
      'CompressedBitsPerPixel' => 37122,
      'ShutterSpeedValue' => 37377,
      'ApertureValue' => 37378,
      'BrightnessValue' => 37379,
      'ExposureBiasValue' => 37380,
      'MaxApertureValue' => 37381,
      'SubjectDistance' => 37382,
      'MeteringMode' => 37383,
      'LightSource' => 37384,
      'Flash' => 37385,
      'FocalLength' => 37386,
      'SubjectArea' => 37396,
      'MakerNote' => 37500,
      'UserComment' => 37510,
      'SubSecTime' => 37520,
      'SubSecTimeOriginal' => 37521,
      'SubSecTimeDigitized' => 37522,
      'FlashPixVersion' => 40960,
      'ColorSpace' => 40961,
      'PixelXDimension' => 40962,
      'PixelYDimension' => 40963,
      'RelatedSoundFile' => 40964,
      'InteroperabilityIFDPointer' => 40965,
      'FlashEnergy' => 41483,
      'SpatialFrequencyResponse' => 41484,
      'FocalPlaneXResolution' => 41486,
      'FocalPlaneYResolution' => 41487,
      'FocalPlaneResolutionUnit' => 41488,
      'SubjectLocation' => 41492,
      'ExposureIndex' => 41493,
      'SensingMethod' => 41495,
      'FileSource' => 41728,
      'SceneType' => 41729,
      'CustomRendered' => 41985,
      'ExposureMode' => 41986,
      'WhiteBalance' => 41987,
      'DigitalZoomRatio' => 41988,
      'FocalLengthIn35mmFilm' => 41989,
      'SceneCaptureType' => 41990,
      'GainControl' => 41991,
      'Contrast' => 41992,
      'Saturation' => 41993,
      'Sharpness' => 41994,
      'DeviceSettingDescription' => 41995,
      'SubjectDistanceRange' => 41996,
      'ImageUniqueID' => 42016,
      'Gamma' => 42240,
    ),
    5 =>
    array (
      'CameraSettings' => 1,
      'FocalLength' => 2,
      'ShotInfo' => 4,
      'Panorama' => 5,
      'ImageType' => 6,
      'FirmwareVersion' => 7,
      'FileNumber' => 8,
      'OwnerName' => 9,
      'SerialNumber' => 12,
      'CameraInfo' => 13,
      'CustomFunctions' => 153,
      'ModelID' => 16,
      'PictureInfo' => 18,
      'ThumbnailImageValidArea' => 19,
      'Serial Number Format' => 21,
      'SuperMacro' => 26,
      'FirmwareRevision' => 30,
      'AFinfo' => 38,
      'OriginalDecision Data Offset' => 131,
      'WhiteBalanceTable' => 164,
      'LensModel' => 149,
      'InternalSerialNumber' => 150,
      'DustRemovalData' => 151,
      'ProcessingInfo' => 160,
      'MeasuredColor' => 170,
      'ColorSpace' => 180,
      'VRDOffset' => 208,
      'SensorInfo' => 224,
      'ColorData' => 16385,
    ),
    6 =>
    array (
      'MacroMode' => 1,
      'SelfTimer' => 2,
      'Quality' => 3,
      'FlashMode' => 4,
      'DriveMode' => 5,
      'FocusMode' => 7,
      'RecordMode' => 9,
      'ImageSize' => 10,
      'EasyShootingMode' => 11,
      'DigitalZoom' => 12,
      'Contrast' => 13,
      'Saturation' => 14,
      'Sharpness' => 15,
      'ISOSpeed' => 16,
      'MeteringMode' => 17,
      'FocusType' => 18,
      'AFPointSelected' => 19,
      'ExposureMode' => 20,
      'LensType' => 22,
      'LongFocalLength' => 23,
      'ShortFocalLength' => 24,
      'FocalUnits' => 25,
      'MaxAperture' => 26,
      'MinAperture' => 27,
      'FlashActivity' => 28,
      'FlashDetails' => 29,
      'FocusContinuous' => 32,
      'AESetting' => 33,
      'ImageStabilization' => 34,
      'DisplayAperture' => 35,
      'ZoomSourceWidth' => 36,
      'ZoomTargetWidth' => 37,
      'SpotMeteringMode' => 39,
      'PhotoEffect' => 40,
      'ManualFlashOutput' => 41,
      'ColorTone' => 42,
      'SRAWQuality' => 46,
    ),
    10 =>
    array (
      'FileNumber' => 1,
      'BracketMode' => 3,
      'BracketValue' => 4,
      'BracketShotNumber' => 5,
      'RawJpgQuality' => 6,
      'RawJpgSize' => 7,
      'NoiseReduction' => 8,
      'WBBracketMode' => 9,
      'WBBracketValueAB' => 12,
      'WBBracketValueGM' => 13,
      'FilterEffect' => 14,
      'ToningEffect' => 15,
      'MacroMagnification' => 16,
      'LiveViewShooting' => 19,
      'FocusDistanceUpper' => 20,
      'FocusDistanceLower' => 21,
      'FlashExposureLock' => 25,
    ),
    7 =>
    array (
      'ISOSpeedUsed' => 2,
      'MeasuredEV' => 3,
      'TargetAperture' => 4,
      'TargetShutterSpeed' => 5,
      'WhiteBalanceSetting' => 7,
      'SlowShutter' => 8,
      'SequenceNumber' => 9,
      'AFPointUsed' => 14,
      'FlashBias' => 15,
      'AutoExposureBracketing' => 16,
      'SubjectDistance' => 19,
      'Aperture' => 21,
      'ShutterSpeed' => 22,
      'MeasuredEV2' => 23,
      'CameraType' => 26,
      'AutoRotate' => 27,
      'NDFilter' => 28,
    ),
    8 =>
    array (
      'PanoramaFrame' => 2,
      'PanoramaDirection' => 5,
    ),
    0 =>
    array (
      'ImageWidth' => 256,
      'ImageLength' => 257,
      'BitsPerSample' => 258,
      'Compression' => 259,
      'PhotometricInterpretation' => 262,
      'DocumentName' => 269,
      'ImageDescription' => 270,
      'Make' => 271,
      'Model' => 272,
      'StripOffsets' => 273,
      'Orientation' => 274,
      'SamplesPerPixel' => 277,
      'RowsPerStrip' => 278,
      'StripByteCounts' => 279,
      'XResolution' => 282,
      'YResolution' => 283,
      'PlanarConfiguration' => 284,
      'ResolutionUnit' => 296,
      'TransferFunction' => 301,
      'Software' => 305,
      'DateTime' => 306,
      'Artist' => 315,
      'WhitePoint' => 318,
      'PrimaryChromaticities' => 319,
      'JPEGInterchangeFormat' => 513,
      'JPEGInterchangeFormatLength' => 514,
      'YCbCrCoefficients' => 529,
      'YCbCrSubSampling' => 530,
      'YCbCrPositioning' => 531,
      'ReferenceBlackWhite' => 532,
      'Rating' => 18246,
      'RatingPercent' => 18249,
      'Copyright' => 33432,
      'ExifIFDPointer' => 34665,
      'GPSInfoIFDPointer' => 34853,
      'WindowsXPTitle' => 40091,
      'WindowsXPComment' => 40092,
      'WindowsXPAuthor' => 40093,
      'WindowsXPKeywords' => 40094,
      'WindowsXPSubject' => 40095,
      'PrintIM' => 50341,
    ),
    1 =>
    array (
      'ImageWidth' => 256,
      'ImageLength' => 257,
      'BitsPerSample' => 258,
      'Compression' => 259,
      'PhotometricInterpretation' => 262,
      'DocumentName' => 269,
      'ImageDescription' => 270,
      'Make' => 271,
      'Model' => 272,
      'StripOffsets' => 273,
      'Orientation' => 274,
      'SamplesPerPixel' => 277,
      'RowsPerStrip' => 278,
      'StripByteCounts' => 279,
      'XResolution' => 282,
      'YResolution' => 283,
      'PlanarConfiguration' => 284,
      'ResolutionUnit' => 296,
      'TransferFunction' => 301,
      'Software' => 305,
      'DateTime' => 306,
      'Artist' => 315,
      'WhitePoint' => 318,
      'PrimaryChromaticities' => 319,
      'JPEGInterchangeFormat' => 513,
      'JPEGInterchangeFormatLength' => 514,
      'YCbCrCoefficients' => 529,
      'YCbCrSubSampling' => 530,
      'YCbCrPositioning' => 531,
      'ReferenceBlackWhite' => 532,
      'Rating' => 18246,
      'RatingPercent' => 18249,
      'Copyright' => 33432,
      'ExifIFDPointer' => 34665,
      'GPSInfoIFDPointer' => 34853,
      'WindowsXPTitle' => 40091,
      'WindowsXPComment' => 40092,
      'WindowsXPAuthor' => 40093,
      'WindowsXPKeywords' => 40094,
      'WindowsXPSubject' => 40095,
      'PrintIM' => 50341,
    ),
  ),
  'makerNotes' =>
  array (
    'Canon' => 5,
  ),
);