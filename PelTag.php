<?php

/*  PEL: PHP EXIF Library.  A library with support for reading and
 *  writing all EXIF headers of JPEG images using PHP.
 *
 *  Copyright (C) 2004  Martin Geisler <gimpster@users.sourceforge.net>
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
 *  Free Software Foundation, Inc., 59 Temple Place, Suite 330,
 *  Boston, MA 02111-1307 USA
 */

/* $Id$ */


/**
 * Namespace for functions operating on EXIF tags.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @version $Revision$
 * @date $Date$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 * License (GPL)
 * @package PEL
 */


/**
 * Class with static methods for EXIF tags.
 *
 * This class defines the constants that represents the EXIF tags
 * known to PEL.  They are supposed to be used whenever one needs to
 * specify an EXIF tag, and they will be denoted by the pseudo type
 * {@link PelTag} throughout the documentation.
 *
 * All the methods in this class are static and should be called with
 * the EXIF tag on which they should operate.
 *
 * @author Martin Geisler <gimpster@users.sourceforge.net>
 * @package PEL
 */
class PelTag {

  const INTEROPERABILITY_INDEX         = 0x0001;
  const INTEROPERABILITY_VERSION       = 0x0002;
  const IMAGE_WIDTH                    = 0x0100;
  const IMAGE_LENGTH                   = 0x0101;
  const BITS_PER_SAMPLE                = 0x0102;
  const COMPRESSION                    = 0x0103;
  const PHOTOMETRIC_INTERPRETATION     = 0x0106;
  const FILL_ORDER                     = 0x010A;
  const DOCUMENT_NAME                  = 0x010D;
  const IMAGE_DESCRIPTION              = 0x010E;
  const MAKE                           = 0x010F;
  const MODEL                          = 0x0110;
  const STRIP_OFFSETS                  = 0x0111;
  const ORIENTATION                    = 0x0112;
  const SAMPLES_PER_PIXEL              = 0x0115;
  const ROWS_PER_STRIP                 = 0x0116;
  const STRIP_BYTE_COUNTS              = 0x0117;
  const X_RESOLUTION                   = 0x011A;
  const Y_RESOLUTION                   = 0x011B;
  const PLANAR_CONFIGURATION           = 0x011C;
  const RESOLUTION_UNIT                = 0x0128;
  const TRANSFER_FUNCTION              = 0x012D;
  const SOFTWARE                       = 0x0131;
  const DATE_TIME                      = 0x0132;
  const ARTIST                         = 0x013B;
  const WHITE_POINT                    = 0x013E;
  const PRIMARY_CHROMATICITIES         = 0x013F;
  const TRANSFER_RANGE                 = 0x0156;
  const JPEG_PROC                      = 0x0200;
  const JPEG_INTERCHANGE_FORMAT        = 0x0201;
  const JPEG_INTERCHANGE_FORMAT_LENGTH = 0x0202;
  const YCBCR_COEFFICIENTS             = 0x0211;
  const YCBCR_SUB_SAMPLING             = 0x0212;
  const YCBCR_POSITIONING              = 0x0213;
  const REFERENCE_BLACK_WHITE          = 0x0214;
  const RELATED_IMAGE_FILE_FORMAT      = 0x1000;
  const RELATED_IMAGE_WIDTH            = 0x1001;
  const RELATED_IMAGE_LENGTH           = 0x1002;
  const CFA_REPEAT_PATTERN_DIM         = 0x828D;
  const CFA_PATTERN                    = 0x828E;
  const BATTERY_LEVEL                  = 0x828F;
  const COPYRIGHT                      = 0x8298;
  const EXPOSURE_TIME                  = 0x829A;
  const FNUMBER                        = 0x829D;
  const IPTC_NAA                       = 0x83BB;
  const EXIF_IFD_POINTER               = 0x8769;
  const INTER_COLOR_PROFILE            = 0x8773;
  const EXPOSURE_PROGRAM               = 0x8822;
  const SPECTRAL_SENSITIVITY           = 0x8824;
  const GPS_INFO_IFD_POINTER           = 0x8825;
  const ISO_SPEED_RATINGS              = 0x8827;
  const OECF                           = 0x8828;
  const EXIF_VERSION                   = 0x9000;
  const DATE_TIME_ORIGINAL             = 0x9003;
  const DATE_TIME_DIGITIZED            = 0x9004;
  const COMPONENTS_CONFIGURATION       = 0x9101;
  const COMPRESSED_BITS_PER_PIXEL      = 0x9102;
  const SHUTTER_SPEED_VALUE            = 0x9201;
  const APERTURE_VALUE                 = 0x9202;
  const BRIGHTNESS_VALUE               = 0x9203;
  const EXPOSURE_BIAS_VALUE            = 0x9204;
  const MAX_APERTURE_VALUE             = 0x9205;
  const SUBJECT_DISTANCE               = 0x9206;
  const METERING_MODE                  = 0x9207;
  const LIGHT_SOURCE                   = 0x9208;
  const FLASH                          = 0x9209;
  const FOCAL_LENGTH                   = 0x920A;
  const SUBJECT_AREA                   = 0x9214;
  const MAKER_NOTE                     = 0x927C;
  const USER_COMMENT                   = 0x9286;
  const SUB_SEC_TIME                   = 0x9290;
  const SUB_SEC_TIME_ORIGINAL          = 0x9291;
  const SUB_SEC_TIME_DIGITIZED         = 0x9292;
  const FLASH_PIX_VERSION              = 0xA000;
  const COLOR_SPACE                    = 0xA001;
  const PIXEL_X_DIMENSION              = 0xA002;
  const PIXEL_Y_DIMENSION              = 0xA003;
  const RELATED_SOUND_FILE             = 0xA004;
  const INTEROPERABILITY_IFD_POINTER   = 0xA005;
  const FLASH_ENERGY                   = 0xA20B;
  const SPATIAL_FREQUENCY_RESPONSE     = 0xA20C;
  const FOCAL_PLANE_X_RESOLUTION       = 0xA20E;
  const FOCAL_PLANE_Y_RESOLUTION       = 0xA20F;
  const FOCAL_PLANE_RESOLUTION_UNIT    = 0xA210;
  const SUBJECT_LOCATION               = 0xA214;
  const EXPOSURE_INDEX                 = 0xA215;
  const SENSING_METHOD                 = 0xA217;
  const FILE_SOURCE                    = 0xA300;
  const SCENE_TYPE                     = 0xA301;
  const NEW_CFA_PATTERN                = 0xA302;
  const CUSTOM_RENDERED                = 0xA401;
  const EXPOSURE_MODE                  = 0xA402;
  const WHITE_BALANCE                  = 0xA403;
  const DIGITAL_ZOOM_RATIO             = 0xA404;
  const FOCAL_LENGTH_IN_35MM_FILM      = 0xA405;
  const SCENE_CAPTURE_TYPE             = 0xA406;
  const GAIN_CONTROL                   = 0xA407;
  const CONTRAST                       = 0xA408;
  const SATURATION                     = 0xA409;
  const SHARPNESS                      = 0xA40A;
  const DEVICE_SETTING_DESCRIPTION     = 0xA40B;
  const SUBJECT_DISTANCE_RANGE         = 0xA40C;
  const IMAGE_UNIQUE_ID	               = 0xA420;

  /**
   * Check a short value to see if it's a valid EXIF tag.
   *
   * @param PelTag the tag.
   *
   * @return boolean true if the tag is known, false otherwise.
   */
  static function isKnownTag($tag) {
    return ($tag >= self::INTEROPERABILITY_INDEX &&
            $tag <= self::IMAGE_UNIQUE_ID);
  }

  /**
   * Returns a short name for an EXIF tag.
   *
   * @param PelTag the tag.
   *
   * @return string the short name of the tag, e.g., 'ImageWidth' for
   * the {@link IMAGE_WIDTH} tag.  If the tag isn't known, the string
   * 'Unknown:0xTT' will be returned where 'TT' is the hexadecimal
   * representation of the tag.
   */
  static function getName($tag) {
    switch ($tag) {
    case self::INTEROPERABILITY_INDEX:
      return Pel::tra('InteroperabilityIndex');
    case self::INTEROPERABILITY_VERSION:
      return Pel::tra('InteroperabilityVersion');
    case self::IMAGE_WIDTH:
      return Pel::tra('ImageWidth');
    case self::IMAGE_LENGTH:
      return Pel::tra('ImageLength');
    case self::BITS_PER_SAMPLE:
      return Pel::tra('BitsPerSample');
    case self::COMPRESSION:
      return Pel::tra('Compression');
    case self::PHOTOMETRIC_INTERPRETATION:
      return Pel::tra('PhotometricInterpretation');
    case self::FILL_ORDER:
      return Pel::tra('FillOrder');
    case self::DOCUMENT_NAME:
      return Pel::tra('DocumentName');
    case self::IMAGE_DESCRIPTION:
      return Pel::tra('ImageDescription');
    case self::MAKE:
      return Pel::tra('Make');
    case self::MODEL:
      return Pel::tra('Model');
    case self::STRIP_OFFSETS:
      return Pel::tra('StripOffsets');
    case self::ORIENTATION:
      return Pel::tra('Orientation');
    case self::SAMPLES_PER_PIXEL:
      return Pel::tra('SamplesPerPixel');
    case self::ROWS_PER_STRIP:
      return Pel::tra('RowsPerStrip');
    case self::STRIP_BYTE_COUNTS:
      return Pel::tra('StripByteCounts');
    case self::X_RESOLUTION:
      return Pel::tra('XResolution');
    case self::Y_RESOLUTION:
      return Pel::tra('YResolution');
    case self::PLANAR_CONFIGURATION:
      return Pel::tra('PlanarConfiguration');
    case self::RESOLUTION_UNIT:
      return Pel::tra('ResolutionUnit');
    case self::TRANSFER_FUNCTION:
      return Pel::tra('TransferFunction');
    case self::SOFTWARE:
      return Pel::tra('Software');
    case self::DATE_TIME:
      return Pel::tra('DateTime');
    case self::ARTIST:
      return Pel::tra('Artist');
    case self::WHITE_POINT:
      return Pel::tra('WhitePoint');
    case self::PRIMARY_CHROMATICITIES:
      return Pel::tra('PrimaryChromaticities');
    case self::TRANSFER_RANGE:
      return Pel::tra('TransferRange');
    case self::JPEG_PROC:
      return Pel::tra('JPEGProc');
    case self::JPEG_INTERCHANGE_FORMAT:
      return Pel::tra('JPEGInterchangeFormat');
    case self::JPEG_INTERCHANGE_FORMAT_LENGTH:
      return Pel::tra('JPEGInterchangeFormatLength');
    case self::YCBCR_COEFFICIENTS:
      return Pel::tra('YCbCrCoefficients');
    case self::YCBCR_SUB_SAMPLING:
      return Pel::tra('YCbCrSubSampling');
    case self::YCBCR_POSITIONING:
      return Pel::tra('YCbCrPositioning');
    case self::REFERENCE_BLACK_WHITE:
      return Pel::tra('ReferenceBlackWhite');
    case self::RELATED_IMAGE_FILE_FORMAT:
      return Pel::tra('RelatedImageFileFormat');
    case self::RELATED_IMAGE_WIDTH:
      return Pel::tra('RelatedImageWidth');
    case self::RELATED_IMAGE_LENGTH:
      return Pel::tra('RelatedImageLength');
    case self::CFA_REPEAT_PATTERN_DIM:
      return Pel::tra('CFARepeatPatternDim');
    case self::CFA_PATTERN:
      return Pel::tra('CFAPattern');
    case self::BATTERY_LEVEL:
      return Pel::tra('BatteryLevel');
    case self::COPYRIGHT:
      return Pel::tra('Copyright');
    case self::EXPOSURE_TIME:
      return Pel::tra('ExposureTime');
    case self::FNUMBER:
      return Pel::tra('FNumber');
    case self::IPTC_NAA:
      return Pel::tra('IPTC/NAA');
    case self::EXIF_IFD_POINTER:
      return Pel::tra('ExifIFDPointer');
    case self::INTER_COLOR_PROFILE:
      return Pel::tra('InterColorProfile');
    case self::EXPOSURE_PROGRAM:
      return Pel::tra('ExposureProgram');
    case self::SPECTRAL_SENSITIVITY:
      return Pel::tra('SpectralSensitivity');
    case self::GPS_INFO_IFD_POINTER:
      return Pel::tra('GPSInfoIFDPointer');
//    case self::GPS_VERSION_ID:
//      return Pel::tra('GPSVersionID');
//    case self::GPS_LATITUDE_REF:
//      return Pel::tra('GPSLatitudeRef');
//    case self::GPS_LATITUDE:
//      return Pel::tra('GPSLatitude');
//    case self::GPS_LONGITUDE_REF:
//      return Pel::tra('GPSLongitudeRef');
//    case self::GPS_LONGITUDE:
//      return Pel::tra('GPSLongitude'); 
    case self::ISO_SPEED_RATINGS:
      return Pel::tra('ISOSpeedRatings');
    case self::OECF:
      return Pel::tra('OECF');
    case self::EXIF_VERSION:
      return Pel::tra('ExifVersion');
    case self::DATE_TIME_ORIGINAL:
      return Pel::tra('DateTimeOriginal');
    case self::DATE_TIME_DIGITIZED:
      return Pel::tra('DateTimeDigitized');
    case self::COMPONENTS_CONFIGURATION:
      return Pel::tra('ComponentsConfiguration');
    case self::COMPRESSED_BITS_PER_PIXEL:
      return Pel::tra('CompressedBitsPerPixel');
    case self::SHUTTER_SPEED_VALUE:
      return Pel::tra('ShutterSpeedValue');
    case self::APERTURE_VALUE:
      return Pel::tra('ApertureValue');
    case self::BRIGHTNESS_VALUE:
      return Pel::tra('BrightnessValue');
    case self::EXPOSURE_BIAS_VALUE:
      return Pel::tra('ExposureBiasValue');
    case self::MAX_APERTURE_VALUE:
      return Pel::tra('MaxApertureValue');
    case self::SUBJECT_DISTANCE:
      return Pel::tra('SubjectDistance');
    case self::METERING_MODE:
      return Pel::tra('MeteringMode');
    case self::LIGHT_SOURCE:
      return Pel::tra('LightSource');
    case self::FLASH:
      return Pel::tra('Flash');
    case self::FOCAL_LENGTH:
      return Pel::tra('FocalLength');
    case self::MAKER_NOTE:
      return Pel::tra('MakerNote');
    case self::USER_COMMENT:
      return Pel::tra('UserComment');
    case self::SUB_SEC_TIME:
      return Pel::tra('SubsecTime');
    case self::SUB_SEC_TIME_ORIGINAL:
      return Pel::tra('SubSecTimeOriginal');
    case self::SUB_SEC_TIME_DIGITIZED:
      return Pel::tra('SubSecTimeDigitized');
    case self::FLASH_PIX_VERSION:
      return Pel::tra('FlashPixVersion');
    case self::COLOR_SPACE:
      return Pel::tra('ColorSpace');
    case self::PIXEL_X_DIMENSION:
      return Pel::tra('PixelXDimension');
    case self::PIXEL_Y_DIMENSION:
      return Pel::tra('PixelYDimension');
    case self::RELATED_SOUND_FILE:
      return Pel::tra('RelatedSoundFile');
    case self::INTEROPERABILITY_IFD_POINTER:
      return Pel::tra('InteroperabilityIFDPointer');
    case self::FLASH_ENERGY:
      return Pel::tra('FlashEnergy');
    case self::SPATIAL_FREQUENCY_RESPONSE:
      return Pel::tra('SpatialFrequencyResponse');
    case self::FOCAL_PLANE_X_RESOLUTION:
      return Pel::tra('FocalPlaneXResolution');
    case self::FOCAL_PLANE_Y_RESOLUTION:
      return Pel::tra('FocalPlaneYResolution');
    case self::FOCAL_PLANE_RESOLUTION_UNIT:
      return Pel::tra('FocalPlaneResolutionUnit');
    case self::SUBJECT_LOCATION:
      return Pel::tra('SubjectLocation');
    case self::EXPOSURE_INDEX:
      return Pel::tra('ExposureIndex');
    case self::SENSING_METHOD:
      return Pel::tra('SensingMethod');
    case self::FILE_SOURCE:
      return Pel::tra('FileSource');
    case self::SCENE_TYPE:
      return Pel::tra('SceneType');
    case self::NEW_CFA_PATTERN:
      return Pel::tra('CFAPattern');
    case self::SUBJECT_AREA:
      return Pel::tra('SubjectArea');
    case self::CUSTOM_RENDERED:
      return Pel::tra('CustomRendered');
    case self::EXPOSURE_MODE:
      return Pel::tra('ExposureMode');
    case self::WHITE_BALANCE:
      return Pel::tra('WhiteBalance');
    case self::DIGITAL_ZOOM_RATIO:
      return Pel::tra('DigitalZoomRatio');
    case self::FOCAL_LENGTH_IN_35MM_FILM:
      return Pel::tra('FocalLengthIn35mmFilm');
    case self::SCENE_CAPTURE_TYPE:
      return Pel::tra('SceneCaptureType');
    case self::GAIN_CONTROL:
      return Pel::tra('GainControl');
    case self::CONTRAST:
      return Pel::tra('Contrast');
    case self::SATURATION:
      return Pel::tra('Saturation');
    case self::SHARPNESS:
      return Pel::tra('Sharpness');
    case self::DEVICE_SETTING_DESCRIPTION:
      return Pel::tra('DeviceSettingDescription');
    case self::SUBJECT_DISTANCE_RANGE:
      return Pel::tra('SubjectDistanceRange');
    case self::IMAGE_UNIQUE_ID:
      return Pel::tra('ImageUniqueID');
    default:
      return Pel::fmt('Unknown: 0x%02X', $tag);
    }
  }


  /**
   * Returns a title for an EXIF tag.
   *
   * @param PelTag the tag.
   *
   * @return string the title of the tag, e.g., 'Image Width' for the
   * {@link IMAGE_WIDTH} tag.  If the tag isn't known, the string
   * 'Unknown Tag: 0xTT' will be returned where 'TT' is the
   * hexadecimal representation of the tag.
   */
  function getTitle($tag) {
    switch ($tag) {
    case self::INTEROPERABILITY_INDEX:
      return Pel::tra('InteroperabilityIndex');
    case self::INTEROPERABILITY_VERSION:
      return Pel::tra('InteroperabilityVersion');
    case self::IMAGE_WIDTH:
      return Pel::tra('Image Width');
    case self::IMAGE_LENGTH:
      return Pel::tra('Image Length');
    case self::BITS_PER_SAMPLE:
      return Pel::tra('Bits per Sample');
    case self::COMPRESSION:
      return Pel::tra('Compression');
    case self::PHOTOMETRIC_INTERPRETATION:
      return Pel::tra('Photometric Interpretation');
    case self::FILL_ORDER:
      return Pel::tra('Fill Order');
    case self::DOCUMENT_NAME:
      return Pel::tra('Document Name');
    case self::IMAGE_DESCRIPTION:
      return Pel::tra('Image Description');
    case self::MAKE:
      return Pel::tra('Manufacturer');
    case self::MODEL:
      return Pel::tra('Model');
    case self::STRIP_OFFSETS:
      return Pel::tra('Strip Offsets');
    case self::ORIENTATION:
      return Pel::tra('Orientation');
    case self::SAMPLES_PER_PIXEL:
      return Pel::tra('Samples per Pixel');
    case self::ROWS_PER_STRIP:
      return Pel::tra('Rows per Strip');
    case self::STRIP_BYTE_COUNTS:
      return Pel::tra('Strip Byte Count');
    case self::X_RESOLUTION:
      return Pel::tra('x-Resolution');
    case self::Y_RESOLUTION:
      return Pel::tra('y-Resolution');
    case self::PLANAR_CONFIGURATION:
      return Pel::tra('Planar Configuration');
    case self::RESOLUTION_UNIT:
      return Pel::tra('Resolution Unit');
    case self::TRANSFER_FUNCTION:
      return Pel::tra('Transfer Function');
    case self::SOFTWARE:
      return Pel::tra('Software');
    case self::DATE_TIME:
      return Pel::tra('Date and Time');
    case self::ARTIST:
      return Pel::tra('Artist');
    case self::WHITE_POINT:
      return Pel::tra('White Point');
    case self::PRIMARY_CHROMATICITIES:
      return Pel::tra('Primary Chromaticities');
    case self::TRANSFER_RANGE:
      return Pel::tra('Transfer Range');
    case self::JPEG_PROC:
      return Pel::tra('JPEGProc');
    case self::JPEG_INTERCHANGE_FORMAT:
      return Pel::tra('JPEG Interchange Format');
    case self::JPEG_INTERCHANGE_FORMAT_LENGTH:
      return Pel::tra('JPEG Interchange Format Length');
    case self::YCBCR_COEFFICIENTS:
      return Pel::tra('YCbCr Coefficients');
    case self::YCBCR_SUB_SAMPLING:
      return Pel::tra('YCbCr Sub-Sampling');
    case self::YCBCR_POSITIONING:
      return Pel::tra('YCbCr Positioning');
    case self::REFERENCE_BLACK_WHITE:
      return Pel::tra('Reference Black/White');
    case self::RELATED_IMAGE_FILE_FORMAT:
      return Pel::tra('RelatedImageFileFormat');
    case self::RELATED_IMAGE_WIDTH:
      return Pel::tra('RelatedImageWidth');
    case self::RELATED_IMAGE_LENGTH:
      return Pel::tra('RelatedImageLength');
    case self::CFA_REPEAT_PATTERN_DIM:
      return Pel::tra('CFARepeatPatternDim');
    case self::CFA_PATTERN:
      return Pel::tra('CFA Pattern');
    case self::BATTERY_LEVEL:
      return Pel::tra('Battery Level');
    case self::COPYRIGHT:
      return Pel::tra('Copyright');
    case self::EXPOSURE_TIME:
      return Pel::tra('Exposure Time');
    case self::FNUMBER:
      return Pel::tra('FNumber');
    case self::IPTC_NAA:
      return Pel::tra('IPTC/NAA');
    case self::EXIF_IFD_POINTER:
      return Pel::tra('ExifIFDPointer');
    case self::INTER_COLOR_PROFILE:
      return Pel::tra('InterColorProfile');
    case self::EXPOSURE_PROGRAM:
      return Pel::tra('ExposureProgram');
    case self::SPECTRAL_SENSITIVITY:
      return Pel::tra('Spectral Sensitivity');
    case self::GPS_INFO_IFD_POINTER:
      return Pel::tra('GPSInfoIFDPointer');
    case self::GPS_VERSION_ID:
      return Pel::tra('GPSVersionId');
    case self::GPS_LATITUDE_REF:
      return Pel::tra('GPSLatitudeRef');
    case self::GPS_LATITUDE:
      return Pel::tra('GPSLatitude');
    case self::GPS_LONGITUDE_REF:
      return Pel::tra('GPSLongitudeRef');
    case self::GPS_LONGITUDE:
      return Pel::tra('GPSLongitude');
    case self::ISO_SPEED_RATINGS:
      return Pel::tra('ISO Speed Ratings');
    case self::OECF:
      return Pel::tra('OECF');
    case self::EXIF_VERSION:
      return Pel::tra('Exif Version');
    case self::DATE_TIME_ORIGINAL:
      return Pel::tra('Date and Time (original)');
    case self::DATE_TIME_DIGITIZED:
      return Pel::tra('Date and Time (digitized)');
    case self::COMPONENTS_CONFIGURATION:
      return Pel::tra('ComponentsConfiguration');
    case self::COMPRESSED_BITS_PER_PIXEL:
      return Pel::tra('Compressed Bits per Pixel');
    case self::SHUTTER_SPEED_VALUE:
      return Pel::tra('Shutter speed');
    case self::APERTURE_VALUE:
      return Pel::tra('Aperture');
    case self::BRIGHTNESS_VALUE:
      return Pel::tra('Brightness');
    case self::EXPOSURE_BIAS_VALUE:
      return Pel::tra('Exposure Bias');
    case self::MAX_APERTURE_VALUE:
      return Pel::tra('MaxApertureValue');
    case self::SUBJECT_DISTANCE:
      return Pel::tra('Subject Distance');
    case self::METERING_MODE:
      return Pel::tra('Metering Mode');
    case self::LIGHT_SOURCE:
      return Pel::tra('Light Source');
    case self::FLASH:
      return Pel::tra('Flash');
    case self::FOCAL_LENGTH:
      return Pel::tra('Focal Length');
    case self::MAKER_NOTE:
      return Pel::tra('Maker Note');
    case self::USER_COMMENT:
      return Pel::tra('User Comment');
    case self::SUB_SEC_TIME:
      return Pel::tra('SubsecTime');
    case self::SUB_SEC_TIME_ORIGINAL:
      return Pel::tra('SubSecTimeOriginal');
    case self::SUB_SEC_TIME_DIGITIZED:
      return Pel::tra('SubSecTimeDigitized');
    case self::FLASH_PIX_VERSION:
      return Pel::tra('FlashPixVersion');
    case self::COLOR_SPACE:
      return Pel::tra('Color Space');
    case self::PIXEL_X_DIMENSION:
      return Pel::tra('PixelXDimension');
    case self::PIXEL_Y_DIMENSION:
      return Pel::tra('PixelYDimension');
    case self::RELATED_SOUND_FILE:
      return Pel::tra('RelatedSoundFile');
    case self::INTEROPERABILITY_IFD_POINTER:
      return Pel::tra('InteroperabilityIFDPointer');
    case self::FLASH_ENERGY:
      return Pel::tra('Flash Energy');
    case self::SPATIAL_FREQUENCY_RESPONSE:
      return Pel::tra('Spatial Frequency Response');
    case self::FOCAL_PLANE_X_RESOLUTION:
      return Pel::tra('Focal Plane x-Resolution');
    case self::FOCAL_PLANE_Y_RESOLUTION:
      return Pel::tra('Focal Plane y-Resolution');
    case self::FOCAL_PLANE_RESOLUTION_UNIT:
      return Pel::tra('Focal Plane Resolution Unit');
    case self::SUBJECT_LOCATION:
      return Pel::tra('Subject Location');
    case self::EXPOSURE_INDEX:
      return Pel::tra('Exposure index');
    case self::SENSING_METHOD:
      return Pel::tra('Sensing Method');
    case self::FILE_SOURCE:
      return Pel::tra('File Source');
    case self::SCENE_TYPE:
      return Pel::tra('Scene Type');
    case self::NEW_CFA_PATTERN:
      return Pel::tra('CFA Pattern');
    case self::SUBJECT_AREA:
      return Pel::tra('Subject Area');
    case self::CUSTOM_RENDERED:
      return Pel::tra('Custom Rendered');
    case self::EXPOSURE_MODE:
      return Pel::tra('Exposure Mode');
    case self::WHITE_BALANCE:
      return Pel::tra('White Balance');
    case self::DIGITAL_ZOOM_RATIO:
      return Pel::tra('Digital Zoom Ratio');
    case self::FOCAL_LENGTH_IN_35MM_FILM:
      return Pel::tra('Focal Length In 35mm Film');
    case self::SCENE_CAPTURE_TYPE:
      return Pel::tra('Scene Capture Type');
    case self::GAIN_CONTROL:
      return Pel::tra('Gain Control');
    case self::CONTRAST:
      return Pel::tra('Contrast');
    case self::SATURATION:
      return Pel::tra('Saturation');
    case self::SHARPNESS:
      return Pel::tra('Sharpness');
    case self::DEVICE_SETTING_DESCRIPTION:
      return Pel::tra('Device Setting Description');
    case self::SUBJECT_DISTANCE_RANGE:
      return Pel::tra('Subject Distance Range');
    case self::IMAGE_UNIQUE_ID:
      return Pel::tra('Image Unique ID');
    default:
      return Pel::fmt('Unknown Tag: 0x%04X', $tag);
    }
  }


  /**
   * Returns a description of an EXIF tag.
   *
   * @param PelTag the tag.
   *
   * @return string the description of the tag which generally
   * explains how the tag is supposed to be used or interpreted.  If
   * the tag isn't known, the string 'Unknown Tag :0xTT' will be
   * returned where 'TT' is the hexadecimal representation of the tag.
   */
  function getDescription($tag) {
    switch ($tag) {
    case self::INTEROPERABILITY_INDEX:
      return('Indicates the identification of the Interoperability rule. ' .
             'Use "R98" for stating ExifR98 Rules. Four bytes used ' .
             'including the termination code (NULL). see the separate ' .
             'volume of Recommended Exif Interoperability Rules (ExifR98) ' .
             'for other tags used for ExifR98.');
    case self::INTEROPERABILITY_VERSION:
      return('');
    case self::IMAGE_WIDTH:
      return('The number of columns of image data, equal to the number of ' .
             'pixels per row. In JPEG compressed data a JPEG marker is ' .
             'used instead of this tag.');
    case self::IMAGE_LENGTH:
      return('The number of rows of image data. In JPEG compressed data a ' .
             'JPEG marker is used instead of this tag.');
    case self::BITS_PER_SAMPLE:
      return('The number of bits per image component. In this standard each ' .
             'component of the image is 8 bits, so the value for this ' .
             'tag is 9. See also <SamplesPerPixel>. In JPEG compressed data ' .
             'a JPEG marker is used instead of this tag.');
    case self::COMPRESSION:
      return('The compression scheme used for the image data. When a ' .
             'primary image is JPEG compressed, this designation is ' .
             'not necessary and is omitted. When thumbnails use JPEG ' .
             'compression, this tag value is set to 6.');
    case self::PHOTOMETRIC_INTERPRETATION:
      return('The pixel composition. In JPEG compressed data a JPEG ' .
             'marker is used instead of this tag.');
    case self::FILL_ORDER:
      return('');
    case self::DOCUMENT_NAME:
      return('');
    case self::IMAGE_DESCRIPTION:
      return('A character string giving the title of the image. It may be ' .
             'a comment such as "1988 company picnic" or ' .
             'the like. Two-bytes character codes cannot be used. ' .
             'When a 2-bytes code is necessary, the Exif Private tag ' .
             '<UserComment> is to be used.');
    case self::MAKE:
      return('The manufacturer of the recording ' .
             'equipment. This is the manufacturer of the DSC, scanner, ' .
             'video digitizer or other equipment that generated the ' .
             'image. When the field is left blank, it is treated as ' .
             'unknown.');
    case self::MODEL:
      return('The model name or model number of the equipment. This is the ' .
             'model name or number of the DSC, scanner, video digitizer ' .
             'or other equipment that generated the image. When the field ' .
             'is left blank, it is treated as unknown.');
    case self::STRIP_OFFSETS:
      return('For each strip, the byte offset of that strip. It is ' .
             'recommended that this be selected so the number of strip ' .
             'bytes does not exceed 64 Kbytes. With JPEG compressed ' .
             'data this designation is not needed and is omitted. See also ' .
             '<RowsPerStrip> and <StripByteCounts>.');
    case self::ORIENTATION:
      return('The image orientation viewed in terms of rows and columns.');
    case self::SAMPLES_PER_PIXEL:
      return('The number of components per pixel. Since this standard ' .
             'applies to RGB and YCbCr images, the value set for this ' .
             'tag is 3. In JPEG compressed data a JPEG marker is used ' .
             'instead of this tag.');
    case self::ROWS_PER_STRIP:
      return('The number of rows per strip. This is the number of rows ' .
             'in the image of one strip when an image is divided into ' .
             'strips. With JPEG compressed data this designation is not ' .
             'needed and is omitted. See also <RowsPerStrip> and ' .
             '<StripByteCounts>.');
    case self::STRIP_BYTE_COUNTS:
      return('The total number of bytes in each strip. With JPEG compressed ' .
             'data this designation is not needed and is omitted.');
    case self::X_RESOLUTION:
      return('The number of pixels per <ResolutionUnit> in the <ImageWidth> ' .
             'direction. When the image resolution is unknown, 72 [dpi] ' .
             'is designated.');
    case self::Y_RESOLUTION:
      return('The number of pixels per <ResolutionUnit> in the ' .
             '<ImageLength> direction. The same value as <XResolution> is ' .
             'designated.');
    case self::PLANAR_CONFIGURATION:
      return('Indicates whether pixel components are recorded in a chunky ' .
             'or planar format. In JPEG compressed files a JPEG marker ' .
             'is used instead of this tag. If this field does not exist, ' .
             'the TIFF default of 1 (chunky) is assumed.');
    case self::RESOLUTION_UNIT:
      return('The unit for measuring <XResolution> and <YResolution>. The ' .
             'same unit is used for both <XResolution> and <YResolution>. ' .
             'If the image resolution is unknown, 2 (inches) is designated.');
    case self::TRANSFER_FUNCTION:
      return('A transfer function for the image, described in tabular ' .
             'style. Normally this tag is not necessary, since color space ' .
             'is specified in the color space information tag ' .
             '(<ColorSpace>).');
    case self::SOFTWARE:
      return('This tag records the name and version of the software or ' .
             'firmware of the camera or image input device used to ' .
             'generate the image. The detailed format is not specified, but ' .
             'it is recommended that the example shown below be ' .
             'followed. When the field is left blank, it is treated as ' .
             'unknown.');
    case self::DATE_TIME:
      return('The date and time of image creation. In this standard ' .
             '(EXIF-2.1) it is the date and time the file was changed.');
    case self::ARTIST:
      return('This tag records the name of the camera owner, photographer ' .
             'or image creator. The detailed format is not specified, but ' .
             'it is recommended that the information be written as in the ' .
             'example below for ease of Interoperability. When the field is ' .
             'left blank, it is treated as unknown.');
    case self::WHITE_POINT:
      return('The chromaticity of the white point of the image. Normally ' .
             'this tag is not necessary, since color space is specified ' .
             'in the colorspace information tag (<ColorSpace>).');
    case self::PRIMARY_CHROMATICITIES:
      return('The chromaticity of the three primary colors of the image. ' .
             'Normally this tag is not necessary, since colorspace is ' .
             'specified in the colorspace information tag (<ColorSpace>).');
    case self::TRANSFER_RANGE:
      return('');
    case self::JPEG_PROC:
      return('');
    case self::JPEG_INTERCHANGE_FORMAT:
      return('The offset to the start byte (SOI) of JPEG compressed ' .
             'thumbnail data. This is not used for primary image ' .
             'JPEG data.');
    case self::JPEG_INTERCHANGE_FORMAT_LENGTH:
      return('The number of bytes of JPEG compressed thumbnail data. This ' .
             'is not used for primary image JPEG data. JPEG thumbnails ' .
             'are not divided but are recorded as a continuous JPEG ' .
             'bitstream from SOI to EOI. Appn and COM markers should ' .
             'not be recorded. Compressed thumbnails must be recorded in no ' .
             'more than 64 Kbytes, including all other data to be ' .
             'recorded in APP1.');
    case self::YCBCR_COEFFICIENTS:
      return('The matrix coefficients for transformation from RGB to YCbCr ' .
             'image data. No default is given in TIFF; but here the ' .
             'value given in Appendix E, "Color Space Guidelines", is used ' .
             'as the default. The color space is declared in a ' .
             'color space information tag, with the default being the value ' .
             'that gives the optimal image characteristics ' .
             'Interoperability this condition.');
    case self::YCBCR_SUB_SAMPLING:
      return('The sampling ratio of chrominance components in relation to ' .
             'the luminance component. In JPEG compressed data a JPEG ' .
             'marker is used instead of this tag.');
    case self::YCBCR_POSITIONING:
      return('The position of chrominance components in relation to the ' .
             'luminance component. This field is designated only for ' .
             'JPEG compressed data or uncompressed YCbCr data. The TIFF ' .
             'default is 1 (centered); but when Y:Cb:Cr = 4:2:2 it is ' .
             'recommended in this standard that 2 (co-sited) be used to ' .
             'record data, in order to improve the image quality when ' .
             'viewed on TV systems. When this field does not exist, the ' .
             'reader shall assume the TIFF default. In the case of ' .
             'Y:Cb:Cr = 4:2:0, the TIFF default (centered) is recommended. ' .
             'If the reader does not have the capability of supporting both ' .
             'kinds of <YCbCrPositioning>, it shall follow the TIFF default ' .
             'regardless of the value in this field. It is preferable that ' .
             'readers be able to support both centered and co-sited ' .
             'positioning.');
    case self::REFERENCE_BLACK_WHITE:
      return('The reference black point value and reference white point ' .
             'value. No defaults are given in TIFF, but the values ' .
             'below are given as defaults here. The color space is declared ' .
             'in a color space information tag, with the default ' .
             'being the value that gives the optimal image characteristics ' .
             'Interoperability these conditions.');
    case self::RELATED_IMAGE_FILE_FORMAT:
      return('');
    case self::RELATED_IMAGE_WIDTH:
      return('');
    case self::RELATED_IMAGE_LENGTH:
      return('');
    case self::CFA_REPEAT_PATTERN_DIM:
      return('');
    case self::CFA_PATTERN:
      return('Indicates the color filter array (CFA) geometric pattern of ' .
             'the image sensor when a one-chip color area sensor is used. ' .
             'It does not apply to all sensing methods.');
    case self::BATTERY_LEVEL:
      return('');
    case self::COPYRIGHT:
      return('Copyright information. In this standard the tag is used to ' .
             'indicate both the photographer and editor copyrights. It is ' .
             'the copyright notice of the person or organization claiming ' .
             'rights to the image. The Interoperability copyright ' .
             'statement including date and rights should be written in this ' .
             'field; e.g., "Copyright, John Smith, 19xx. All rights ' .
             'reserved.". In this standard the field records both the ' .
             'photographer and editor copyrights, with each recorded in a ' .
             'separate part of the statement. When there is a clear ' .
             'distinction between the photographer and editor copyrights, ' .
             'these are to be written in the order of photographer followed ' .
             'by editor copyright, separated by NULL (in this case, ' .
             'since the statement also ends with a NULL, there are two NULL ' .
             'codes) (see example 1). When only the photographer is given, ' .
             'it is terminated by one NULL code (see example 2). When only ' .
             'the editor copyright is given, ' .
             'the photographer copyright part consists of one space ' .
             'followed by a terminating NULL code, then the editor ' .
             'copyright is given (see example 3). When the field is left ' .
             'blank, it is treated as unknown.');
    case self::EXPOSURE_TIME:
      return('Exposure time, given in seconds (sec).');
    case self::FNUMBER:
      return('The F number.');
    case self::IPTC_NAA:
      return('');
    case self::EXIF_IFD_POINTER:
      return('A pointer to the Exif IFD. Interoperability, Exif IFD has the ' .
             'same structure as that of the IFD specified in TIFF. ' .
             'ordinarily, however, it does not contain image data as in ' .
             'the case of TIFF.');
    case self::INTER_COLOR_PROFILE:
      return('');
    case self::EXPOSURE_PROGRAM:
      return('The class of the program used by the camera to set exposure ' .
             'when the picture is taken.');
    case self::SPECTRAL_SENSITIVITY:
      return('Indicates the spectral sensitivity of each channel of the ' .
             'camera used. The tag value is an ASCII string compatible ' .
             'with the standard developed by the ASTM Technical committee.');
    case self::GPS_INFO_IFD_POINTER:
      return('A pointer to the GPS Info IFD. The ' .
             'Interoperability structure of the GPS Info IFD, like that of ' .
             'Exif IFD, has no image data.');
    case self::GPS_VERSION_ID:
      return('Indicates the version of <GPSInfoIFD>. The version is given ' .
             'as 2.0.0.0. This tag is mandatory when <GPSInfo> tag is ' .
             'present. (Note: The <GPSVersionID tag is given in bytes, ' .
             'unlike the <ExifVersion> tag. When the version is ' .
             '2.0.0.0, the tag value is 02000000.H).');
    case self::GPS_LATITUDE_REF:
      return ('Indicates whether the latitude is north or south latitude. ' .
              'The ASCII value \'N\' indicates north latitude, and \'S\' ' .
              'is south latitude.');
    case self::GPS_LATITUDE:
      return ('Indicates the latitude. The latitude is expressed as three ' .
              'RATIONAL values giving the degrees, minutes, and seconds, ' .
              'respectively. When degrees, minutes and seconds are ' .
              'expressed, the format is dd/1,mm/1,ss/1. When degrees and ' .
              'minutes are used and, for example, fractions of minutes ' .
              'are given up to two decimal places, the format is ' .
              'dd/1,mmmm/100,0/1.');
    case self::GPS_LONGITUDE_REF:
      return ("Indicates whether the longitude is east or west longitude. ".
              'ASCII \'E\' indicates east longitude, and \'W\' is west ' .
              'longitude.');
    case self::GPS_LONGITUDE:
      return ('Indicates the longitude. The longitude is expressed as three ' .
              'RATIONAL values giving the degrees, minutes, and seconds, ' .
              'respectively. When degrees, minutes and seconds are ' .
              'expressed, the format is ddd/1,mm/1,ss/1. When degrees and ' .
              'minutes are used and, for example, fractions of minutes are ' .
              'given up to two decimal places, the format is ' .
              'ddd/1,mmmm/100,0/1.');
    case self::ISO_SPEED_RATINGS:
      return('Indicates the ISO Speed and ISO Latitude of the camera or ' .
             'input device as specified in ISO 12232.');
    case self::OECF:
      return('Indicates the Opto-Electoric Conversion Function (OECF) ' .
             'specified in ISO 14524. <OECF> is the relationship between ' .
             'the camera optical input and the image values.');
    case self::EXIF_VERSION:
      return('The version of this standard supported. Nonexistence of this ' .
             'field is taken to mean non-conformance to the standard.');
    case self::DATE_TIME_ORIGINAL:
      return('The date and time when the original image data was generated. ' .
             'For a digital still camera ' .
             'the date and time the picture was taken are recorded.');
    case self::DATE_TIME_DIGITIZED:
      return('The date and time when the image was stored as digital data. ');
    case self::COMPONENTS_CONFIGURATION:
      return('Information specific to compressed data. The channels of ' .
             'each component are arranged in order from the 1st ' .
             'component to the 4th. For uncompressed data the data ' .
             'arrangement is given in the <PhotometricInterpretation> tag. ' .
             'However, since <PhotometricInterpretation> can only ' .
             'express the order of Y, Cb and Cr, this tag is provided ' .
             'for cases when compressed data uses components other than ' .
             'Y, Cb, and Cr and to enable support of other sequences.');
    case self::COMPRESSED_BITS_PER_PIXEL:
      return('Information specific to compressed data. The compression mode ' .
             'used for a compressed image is indicated in unit bits ' .
             'per pixel.');
    case self::SHUTTER_SPEED_VALUE:
      return('Shutter speed. The unit is the APEX (Additive System of ' .
             'Photographic Exposure) setting (see Appendix C).');
    case self::APERTURE_VALUE:
      return('The lens aperture. The unit is the APEX value.');
    case self::BRIGHTNESS_VALUE:
      return('The value of brightness. The unit is the APEX value. ' .
             'Ordinarily it is given in the range of -99.99 to 99.99.');
    case self::EXPOSURE_BIAS_VALUE:
      return('The exposure bias. The units is the APEX value. Ordinarily ' .
             'it is given in the range of -99.99 to 99.99.');
    case self::MAX_APERTURE_VALUE:
      return('The smallest F number of the lens. The unit is the APEX ' .
             'value. Ordinarily it is given in the range of 00.00 to 99.99, ' .
             'but it is not limited to this range.');
    case self::SUBJECT_DISTANCE:
      return('The distance to the subject, given in meters.');
    case self::METERING_MODE:
      return('The metering mode.');
    case self::LIGHT_SOURCE:
      return('The kind of light source.');
    case self::FLASH:
      return('This tag is recorded when an image is taken using a strobe ' .
             'light (flash).');
    case self::FOCAL_LENGTH:
      return('The actual focal length of the lens, in mm. Conversion is not ' .
             'made to the focal length of a 35 mm film camera.');
    case self::MAKER_NOTE:
      return('A tag for manufacturers of Exif writers to record any desired ' .
             'information. The contents are up to the manufacturer.');
    case self::USER_COMMENT:
      return('A tag for Exif users to write keywords or comments on the ' .
             'image besides those in <ImageDescription>, and without the ' .
             'character code limitations of the <ImageDescription> tag. The ' .
             'character code used in the <UserComment> tag is identified ' .
             'based on an ID code in a fixed 8-byte area at the start of ' .
             'the tag data area. The unused portion of the area is padded ' .
             'with NULL ("00.h"). ID codes are assigned by means of ' .
             'registration. The designation method and references for each ' .
             'character code are given in Table 6. The value of CountN ' .
             'is determined based on the 8 bytes in the character code ' .
             'area and the number of bytes in the user comment part. Since ' .
             'the TYPE is not ASCII, NULL termination is not necessary ' .
             '(see Fig. 9). ' .
             'The ID code for the <UserComment> area may be a Defined code ' .
             'such as JIS or ASCII, or may be Undefined. The Undefined name ' .
             'is UndefinedText, and the ID code is filled with 8 bytes of ' .
             'all "NULL" ("00.H"). An Exif reader that reads the ' .
             '<UserComment> tag must have a function for determining the ' .
             'ID code. This function is not required in Exif readers that ' .
             'do not use the <UserComment> tag (see Table 7). ' .
             'When a <UserComment> area is set aside, it is recommended ' .
             'that the ID code be ASCII and that the following user comment ' .
             'part be filled with blank characters [20.H].');
    case self::SUB_SEC_TIME:
      return('A tag used to record fractions of seconds for the ' .
             '<DateTime> tag.');
    case self::SUB_SEC_TIME_ORIGINAL:
      return('A tag used to record fractions of seconds for the ' .
             '<DateTimeOriginal> tag.');
    case self::SUB_SEC_TIME_DIGITIZED:
      return('A tag used to record fractions of seconds for the ' .
             '<DateTimeDigitized> tag.');
    case self::FLASH_PIX_VERSION:
      return('The FlashPix format version supported by a FPXR file.');
    case self::COLOR_SPACE:
      return('The color space information tag is always ' .
             'recorded as the color space specifier. Normally sRGB (=1) ' .
             'is used to define the color space based on the PC monitor ' .
             'conditions and environment. If a color space other than ' .
             'sRGB is used, Uncalibrated (=FFFF.H) is set. Image data ' .
             'recorded as Uncalibrated can be treated as sRGB when it is ' .
             'converted to FlashPix. On sRGB see Appendix E.');
    case self::PIXEL_X_DIMENSION:
      return('Information specific to compressed data. When a ' .
             'compressed file is recorded, the valid width of the ' .
             'meaningful image must be recorded in this tag, whether or ' .
             'not there is padding data or a restart marker. This tag ' .
             'should not exist in an uncompressed file. For details see ' .
             'section 2.8.1 and Appendix F.');
    case self::PIXEL_Y_DIMENSION:
      return('Information specific to compressed data. When a compressed ' .
             'file is recorded, the valid height of the meaningful image ' .
             'must be recorded in this tag, whether or not there is padding ' .
             'data or a restart marker. This tag should not exist in an ' .
             'uncompressed file. For details see section 2.8.1 and Appendix ' .
             'F. Since data padding is unnecessary in the vertical ' .
             'direction, the number of lines recorded in this valid image ' .
             'height tag will in fact be the same as that recorded in the ' .
             'SOF.');
    case self::RELATED_SOUND_FILE:
      return('This tag is used to record the name of an audio file related ' .
             'to the image data. The only relational information ' .
             'recorded here is the Exif audio file name and extension (an ' .
             'ASCII string consisting of 8 characters + \'.\' + 3 ' .
             'characters). The path is not recorded. Stipulations on audio ' .
             'are given in  section 3.6.3. File naming conventions are ' .
             'given in section 3.7.1. ' .
             'When using this tag, audio files must be recorded in ' .
             'conformance to the Exif audio format. Writers are also ' .
             'allowed to store the data such as Audio within APP2 as ' .
             'FlashPix extension stream data. ' .
             'Audio files must be recorded in conformance to the Exif audio ' .
             'format. The mapping of Exif image files and audio files is ' .
             'done in any of the three ways shown in Table 8. If multiple ' .
             'files are mapped to one file as in [2] or [3] of this table, ' .
             'the above format is used to record just one audio file name. ' .
             'If there are multiple audio files, the first recorded file is ' .
             'given. In the case of [3] in Table 8, for example, for the ' .
             'Exif image file "DSC00001.JPG" only  "SND00001.WAV" is ' .
             'given as the related Exif audio file. When there are three ' .
             'Exif audio files "SND00001.WAV", "SND00002.WAV" and ' .
             '"SND00003.WAV", the Exif image file name for each of them, ' .
             '"DSC00001.JPG", is indicated. By combining multiple ' .
             'relational information, a variety of playback possibilities ' .
             'can be supported. The method of using relational information ' .
             'is left to the implementation on the playback side. Since ' .
             'this information is an ASCII character string, it is ' .
             'terminated by NULL. When this tag is used to map audio files, ' .
             'the relation of the audio file to image data must also be ' .
             'indicated on the audio file end.');
    case self::INTEROPERABILITY_IFD_POINTER:
      return('Interoperability IFD is composed of tags which stores the ' .
             'information to ensure the Interoperability and pointed ' .
             'by the following tag located in Exif IFD. ' .
             'The Interoperability structure of Interoperability IFD is ' .
             'the same as TIFF defined IFD structure ' .
             'but does not contain the ' .
             'image data characteristically compared with normal TIFF ' .
             'IFD.');
    case self::FLASH_ENERGY:
      return('Indicates the strobe energy at the time the image is ' .
             'captured, as measured in Beam Candle Power Seconds (BCPS).');
    case self::SPATIAL_FREQUENCY_RESPONSE:
      return('This tag records the camera or input device spatial frequency ' .
             'table and SFR values in the direction of image width, ' .
             'image height, and diagonal direction, as specified in ISO ' .
             '12233.');
    case self::FOCAL_PLANE_X_RESOLUTION:
      return('Indicates the number of pixels in the image width (X) ' .
             'direction per <FocalPlaneResolutionUnit> on the camera focal ' .
             'plane.');
    case self::FOCAL_PLANE_Y_RESOLUTION:
      return('Indicates the number of pixels in the image height (V) ' .
             'direction per <FocalPlaneResolutionUnit> on the camera focal ' .
             'plane.');
    case self::FOCAL_PLANE_RESOLUTION_UNIT:
      return('Indicates the unit for measuring <FocalPlaneXResolution> and ' .
             '<FocalPlaneYResolution>. This value is the same as the ' .
             '<ResolutionUnit>.');
    case self::SUBJECT_LOCATION:
      return('Indicates the location of the main subject in the scene. The ' .
             'value of this tag represents the pixel at the center of the ' .
             'main subject relative to the left edge, prior to rotation ' .
             'processing as per the <Rotation> tag. The first value ' .
             'indicates the X column number and second indicates ' .
             'the Y row number.');
    case self::EXPOSURE_INDEX:
      return('Indicates the exposure index selected on the camera or ' .
             'input device at the time the image is captured.');
    case self::SENSING_METHOD:
      return('Indicates the image sensor type on the camera or input ' .
             'device.');
    case self::FILE_SOURCE:
      return('Indicates the image source. If a DSC recorded the image, ' .
             'this tag value of this tag always be set to 3, indicating ' .
             'that the image was recorded on a DSC.');
    case self::SCENE_TYPE:
      return('Indicates the type of scene. If a DSC recorded the image, ' .
             'this tag value must always be set to 1, indicating that the ' .
             'image was directly photographed.');
    case self::NEW_CFA_PATTERN:
      return('Indicates the color filter array (CFA) geometric pattern of ' .
             'the image sensor when a one-chip color area sensor is used. ' .
             'It does not apply to all sensing methods.');
    case self::SUBJECT_AREA:
      return('This tag indicates the location and area of the main subject ' .
             'in the overall scene.');
    case self::CUSTOM_RENDERED:
      return('This tag indicates the use of special processing on image ' .
             'data, such as rendering geared to output. When special ' .
             'processing is performed, the reader is expected to disable ' .
             'or minimize any further processing.');
    case self::EXPOSURE_MODE:
      return('This tag indicates the exposure mode set when the image was ' .
             'shot. In auto-bracketing mode, the camera shoots a series of ' .
             'frames of the same scene at different exposure settings.');
    case self::WHITE_BALANCE:
      return('This tag indicates the white balance mode set when the image ' .
             'was shot.');
    case self::DIGITAL_ZOOM_RATIO:
      return('This tag indicates the digital zoom ratio when the image was ' .
             'shot. If the numerator of the recorded value is 0, this ' .
             'indicates that digital zoom was not used.');
    case self::FOCAL_LENGTH_IN_35MM_FILM:
      return('This tag indicates the equivalent focal length assuming a ' .
             '35mm film camera, in mm. A value of 0 means the focal ' .
             'length is unknown. Note that this tag differs from the ' .
             'FocalLength tag.');
    case self::SCENE_CAPTURE_TYPE:
      return('This tag indicates the type of scene that was shot. It can ' .
             'also be used to record the mode in which the image was ' .
             'shot. Note that this differs from the scene type ' .
             '(SceneType) tag.');
    case self::GAIN_CONTROL:
      return('This tag indicates the degree of overall image gain ' .
             'adjustment.');
    case self::CONTRAST:
      return('This tag indicates the direction of contrast processing ' .
             'applied by the camera when the image was shot.');
    case self::SATURATION:
      return('This tag indicates the direction of saturation processing ' .
             'applied by the camera when the image was shot.');
    case self::SHARPNESS:
      return('This tag indicates the direction of sharpness processing ' .
             'applied by the camera when the image was shot.');
    case self::DEVICE_SETTING_DESCRIPTION:
      return('This tag indicates information on the picture-taking ' .
             'conditions of a particular camera model. The tag is used ' .
             'only to indicate the picture-taking conditions in the ' .
             'reader.');
    case self::SUBJECT_DISTANCE_RANGE:
      return('This tag indicates the distance to the subject.');
    case self::IMAGE_UNIQUE_ID:
      return('This tag indicates an identifier assigned uniquely to ' .
             'each image. It is recorded as an ASCII string equivalent ' .
             'to hexadecimal notation and 128-bit fixed length.');
    default:
      return Pel::fmt('Unknown Tag: 0x%04X', $tag);
    }
  }
}
?>