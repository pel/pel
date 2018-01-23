<?php
/**
 * This file is generated automatically by executing the 'pel compile' command.
 *
 * DO NOT CHANGE MANUALLY.
 */
return array (
  'ifds' =>
  array (
    2 => 'Exif',
    3 => 'GPS',
    0 => '0',
    1 => '1',
    4 => 'Interoperability',
    5 => 'Canon Maker Notes',
    6 => 'Canon Camera Settings',
    10 => 'Canon File Information',
    8 => 'Canon Panorama Information',
    9 => 'Canon Picture Information',
    7 => 'Canon Shot Information',
  ),
  'ifdsByType' =>
  array (
    'Exif' => 2,
    'GPS' => 3,
    '0' => 0,
    'IFD0' => 0,
    'Main' => 0,
    '1' => 1,
    'IFD1' => 1,
    'Thumbnail' => 1,
    'Interoperability' => 4,
    'Interop' => 4,
    'Canon Maker Notes' => 5,
    'Canon Camera Settings' => 6,
    'Canon File Information' => 10,
    'Canon Panorama Information' => 8,
    'Canon Picture Information' => 9,
    'Canon Shot Information' => 7,
  ),
  'tags' =>
  array (
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
      ),
      33437 =>
      array (
        'const' => 'FNUMBER',
        'name' => 'FNumber',
        'title' => 'FNumber',
        'components' => 1,
        'format' => 'Rational',
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
          'decode' =>
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
      ),
      37378 =>
      array (
        'const' => 'APERTURE_VALUE',
        'name' => 'ApertureValue',
        'title' => 'Aperture',
        'components' => 1,
        'format' => 'Rational',
      ),
      37379 =>
      array (
        'const' => 'BRIGHTNESS_VALUE',
        'name' => 'BrightnessValue',
        'title' => 'Brightness',
        'components' => 1,
        'format' => 'SRational',
      ),
      37380 =>
      array (
        'const' => 'EXPOSURE_BIAS_VALUE',
        'name' => 'ExposureBiasValue',
        'title' => 'Exposure Bias',
        'components' => 1,
        'format' => 'SRational',
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
      ),
      41729 =>
      array (
        'const' => 'SCENE_TYPE',
        'name' => 'SceneType',
        'title' => 'Scene Type',
        'components' => 1,
        'format' => 'Undefined',
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
        'format' => 'Undefined',
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
      ),
      4 =>
      array (
        'const' => 'CANON_CS_FLASH_MODE',
        'name' => 'FlashMode',
        'title' => 'Flash Mode',
      ),
      5 =>
      array (
        'const' => 'CANON_CS_DRIVE_MODE',
        'name' => 'DriveMode',
        'title' => 'Drive Mode',
      ),
      7 =>
      array (
        'const' => 'CANON_CS_FOCUS_MODE',
        'name' => 'FocusMode',
        'title' => 'Focus Mode',
      ),
      9 =>
      array (
        'const' => 'CANON_CS_RECORD_MODE',
        'name' => 'RecordMode',
        'title' => 'Record Mode',
      ),
      10 =>
      array (
        'const' => 'CANON_CS_IMAGE_SIZE',
        'name' => 'ImageSize',
        'title' => 'Image Size',
      ),
      11 =>
      array (
        'const' => 'CANON_CS_EASY_MODE',
        'name' => 'EasyShootingMode',
        'title' => 'Easy Shooting Mode',
      ),
      12 =>
      array (
        'const' => 'CANON_CS_DIGITAL_ZOOM',
        'name' => 'DigitalZoom',
        'title' => 'Digital Zoom',
      ),
      13 =>
      array (
        'const' => 'CANON_CS_CONTRAST',
        'name' => 'Contrast',
        'title' => 'Contrast',
      ),
      14 =>
      array (
        'const' => 'CANON_CS_SATURATION',
        'name' => 'Saturation',
        'title' => 'Saturation',
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
      ),
      18 =>
      array (
        'const' => 'CANON_CS_FOCUS_TYPE',
        'name' => 'FocusType',
        'title' => 'Focus Type',
      ),
      19 =>
      array (
        'const' => 'CANON_CS_AF_POINT',
        'name' => 'AFPointSelected',
        'title' => 'AF Point Selected',
      ),
      20 =>
      array (
        'const' => 'CANON_CS_EXPOSURE_PROGRAM',
        'name' => 'ExposureMode',
        'title' => 'Exposure Mode',
      ),
      22 =>
      array (
        'const' => 'CANON_CS_LENS_TYPE',
        'name' => 'LensType',
        'title' => 'Lens Type',
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
      ),
      34 =>
      array (
        'const' => 'CANON_CS_IMAGE_STABILIZATION',
        'name' => 'ImageStabilization',
        'title' => 'Image Stabilization',
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
        'title' => 'Spot Metering Mode',
      ),
      40 =>
      array (
        'const' => 'CANON_CS_PHOTO_EFFECT',
        'name' => 'PhotoEffect',
        'title' => 'Photo Effect',
      ),
      41 =>
      array (
        'const' => 'CANON_CS_MANUAL_FLASH_OUTPUT',
        'name' => 'ManualFlashOutput',
        'title' => 'Manual Flash Output',
      ),
      42 =>
      array (
        'const' => 'CANON_CS_COLOR_TONE',
        'name' => 'ColorTone',
        'title' => 'Color Tone',
      ),
      46 =>
      array (
        'const' => 'CANON_CS_SRAW_QUALITY',
        'name' => 'SRAWQuality',
        'title' => 'SRAW Quality',
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
      ),
      7 =>
      array (
        'const' => 'CANON_FI_RAW_JPG_SIZE',
        'name' => 'RawJpgSize',
        'title' => 'Raw Jpg Size',
      ),
      8 =>
      array (
        'const' => 'CANON_FI_NOISE_REDUCTION',
        'name' => 'NoiseReduction',
        'title' => 'Noise Reduction',
      ),
      9 =>
      array (
        'const' => 'CANON_FI_WB_BRACKET_MODE',
        'name' => 'WBBracketMode',
        'title' => 'WB Bracket Mode',
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
      ),
      15 =>
      array (
        'const' => 'CANON_FI_TONING_EFFECT',
        'name' => 'ToningEffect',
        'title' => 'Toning Effect',
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
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
          'decode' =>
          array (
            0 => 'Off',
            1 => 'On',
          ),
        ),
      ),
    ),
  ),
  'tagsByName' =>
  array (
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
    4 =>
    array (
      'InteroperabilityIndex' => 1,
      'InteroperabilityVersion' => 2,
      'RelatedImageFileFormat' => 4096,
      'RelatedImageWidth' => 4097,
      'RelatedImageLength' => 4098,
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
    8 =>
    array (
      'PanoramaFrame' => 2,
      'PanoramaDirection' => 5,
    ),
    9 =>
    array (
      'ImageWidth' => 2,
      'ImageHeight' => 3,
      'ImageWidthAsShot' => 4,
      'ImageHeightAsShot' => 5,
      'AFPointsUsed' => 22,
      'AFPointsUsed(20D)' => 26,
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
  ),
  'makerNotes' =>
  array (
    'Canon' => 5,
  ),
);