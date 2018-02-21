<?php

namespace Pel\Test;

use lsolesen\pel\PelSpec;
use PHPUnit\Framework\TestCase;

/**
 * Test the PelSpec class.
 */
class PelSpecTest extends TestCase
{
    /**
     * Tests the pre-compiled default specifications set.
     */
    public function testDefaultSpec()
    {
        // Test retrieving IFD type.
        $this->assertEquals('0', PelSpec::getIfdType(0));
        $this->assertEquals('Exif', PelSpec::getIfdType(2));
        $this->assertEquals('Canon Maker Notes', PelSpec::getIfdType(5));

        // Test retrieving IFD id by type.
        $this->assertEquals(0, PelSpec::getIfdIdByType('0'));
        $this->assertEquals(0, PelSpec::getIfdIdByType('IFD0'));
        $this->assertEquals(0, PelSpec::getIfdIdByType('Main'));
        $this->assertEquals(2, PelSpec::getIfdIdByType('Exif'));
        $this->assertEquals(5, PelSpec::getIfdIdByType('Canon Maker Notes'));

        // Test retrieving TAG name.
        $this->assertEquals('ExifIFDPointer', PelSpec::getTagName(0, 0x8769));
        $this->assertEquals('ExposureTime', PelSpec::getTagName(2, 0x829A));
        $this->assertEquals('Compression', PelSpec::getTagName(0, 0x0103));

        // Test retrieving TAG id by name.
        $this->assertEquals(0x8769, PelSpec::getTagIdByName(0, 'ExifIFDPointer'));
        $this->assertEquals(0x829A, PelSpec::getTagIdByName(2, 'ExposureTime'));
        $this->assertEquals(0x0103, PelSpec::getTagIdByName(0, 'Compression'));

        // Check methods identifying an IFD pointer TAG.
        $this->assertTrue(PelSpec::isTagAnIfdPointer(0, 0x8769));
        $this->assertEquals(2, PelSpec::getIfdIdFromTag(0, 0x8769));
        $this->assertFalse(PelSpec::isTagAnIfdPointer(2, 0x829A));
        $this->assertNull(PelSpec::getIfdIdFromTag(0, 0x829A));

        // Check methods identifying a MakerNotes pointer TAG.
        $this->assertTrue(PelSpec::isTagAMakerNotesPointer(2, 0x927C));
        $this->assertFalse(PelSpec::isTagAMakerNotesPointer(0, 0x8769));

        // Check getTagFormat.
        $this->assertEquals('UserComment', PelSpec::getTagFormat(2, 0x9286));
        $this->assertEquals('Short', PelSpec::getTagFormat(2, 0xA002));
        $this->assertNull(PelSpec::getTagFormat(7, 0x0002));

        // Check getTagTitle.
        $this->assertEquals('Exif IFD Pointer', PelSpec::getTagTitle(0, 0x8769));
        $this->assertEquals('Exposure Time', PelSpec::getTagTitle(2, 0x829A));
        $this->assertEquals('Compression', PelSpec::getTagTitle(0, 0x0103));
    }

    /**
     * Tests getting decoded TAG text from TAG values.
     *
     * @dataProvider getTagTextProvider
     */
    public function testGetTagText($expected, $ifd_type, $tag_name, $components, $value, $brief)
    {
        $ifd_id = PelSpec::getIfdIdByType($ifd_type);
        $tag_id = PelSpec::getTagIdByName($ifd_id, $tag_name);
        $this->assertEquals($expected, PelSpec::getTagText($ifd_id, $tag_id, $components, $value, $brief));
    }

    /**
     * Data provider for testGetTagText.
     */
    public function getTagTextProvider()
    {
        return [
          'IFD0/PlanarConfiguration - value 1' => [
              'chunky format', 'IFD0', 'PlanarConfiguration', 1, [1], false,
          ],
          'IFD0/PlanarConfiguration - missing mapping' => [
              null, 'IFD0', 'PlanarConfiguration', 1, [6.1], false,
          ],
          'Canon Panorama Information/PanoramaDirection - value 4' => [
              '2x2 Matrix (Clockwise)', 'Canon Panorama Information', 'PanoramaDirection', 1, [4], false,
          ],
          'Canon Camera Settings/LensType - value 493' => [
              'Canon EF 500mm f/4L IS II USM or EF 24-105mm f4L IS USM', 'Canon Camera Settings', 'LensType', 1, [493], false,
          ],
          'Canon Camera Settings/LensType - value 493.1' => [
              'Canon EF 24-105mm f/4L IS USM', 'Canon Camera Settings', 'LensType', 1, [493.1], false,
          ],
          'IFD0/YCbCrSubSampling - value 2, 1' => [
              'YCbCr4:2:2', 'IFD0', 'YCbCrSubSampling', 2, [2, 1], false,
          ],
          'IFD0/YCbCrSubSampling - value 2, 2' => [
              'YCbCr4:2:0', 'IFD0', 'YCbCrSubSampling', 2, [2, 2], false,
          ],
          'IFD0/YCbCrSubSampling - value 6, 7' => [
              '6, 7', 'IFD0', 'YCbCrSubSampling', 2, [6, 7], false,
          ],
          'Exif/SubjectArea - value 6, 7' => [
              '(x,y) = (6,7)', 'Exif', 'SubjectArea', 2, [6, 7], false,
          ],
          'Exif/SubjectArea - value 5, 6, 7' => [
              'Within distance 5 of (x,y) = (6,7)', 'Exif', 'SubjectArea', 3, [5, 6, 7], false,
          ],
          'Exif/SubjectArea - value 4, 5, 6, 7' => [
              'Within rectangle (width 4, height 5) around (x,y) = (6,7)', 'Exif', 'SubjectArea', 4, [4, 5, 6, 7], false,
          ],
          'Exif/SubjectArea - wrong components' => [
              'Unexpected number of components (1, expected 2, 3, or 4).', 'Exif', 'SubjectArea', 1, [6], false,
          ],
          'Exif/FNumber - value 60, 10' => [
              'f/6.0', 'Exif', 'FNumber', 1, [[60, 10]], false,
          ],
          'Exif/FNumber - value 26, 10' => [
              'f/2.6', 'Exif', 'FNumber', 1, [[26, 10]], false,
          ],
          'Exif/ApertureValue - value 60, 10' => [
              'f/8.0', 'Exif', 'ApertureValue', 1, [[60, 10]], false,
          ],
          'Exif/ApertureValue - value 26, 10' => [
              'f/2.5', 'Exif', 'ApertureValue', 1, [[26, 10]], false,
          ],
          'Exif/FocalLength - value 60, 10' => [
              '6.0 mm', 'Exif', 'FocalLength', 1, [[60, 10]], false,
          ],
          'Exif/FocalLength - value 26, 10' => [
              '2.6 mm', 'Exif', 'FocalLength', 1, [[26, 10]], false,
          ],
          'Exif/SubjectDistance - value 60, 10' => [
              '6.0 m', 'Exif', 'SubjectDistance', 1, [[60, 10]], false,
          ],
          'Exif/SubjectDistance - value 26, 10' => [
              '2.6 m', 'Exif', 'SubjectDistance', 1, [[26, 10]], false,
          ],
          'Exif/ExposureTime - value 60, 10' => [
              '6 sec.', 'Exif', 'ExposureTime', 1, [[60, 10]], false,
          ],
          'Exif/ExposureTime - value 5, 10' => [
              '1/2 sec.', 'Exif', 'ExposureTime', 1, [[5, 10]], false,
          ],
          'GPS/GPSLongitude' => [
              '30° 45\' 28" (30.76°)', 'GPS', 'GPSLongitude', 3, [[30, 1], [45, 1], [28, 1]], false,
          ],
          'GPS/GPSLatitude' => [
              '50° 33\' 12" (50.55°)', 'GPS', 'GPSLatitude', 3, [[50, 1], [33, 1], [12, 1]], false,
          ],
          'Exif/ShutterSpeedValue - value 5, 10' => [
              '5/10 sec. (APEX: 1)', 'Exif', 'ShutterSpeedValue', 1, [[5, 10]], false,
          ],
          'Exif/BrightnessValue - value 5, 10' => [
              '5/10', 'Exif', 'BrightnessValue', 1, [[5, 10]], false,
          ],
          'Exif/ExposureBiasValue - value 5, 10' => [
              '+0.5', 'Exif', 'ExposureBiasValue', 1, [[5, 10]], false,
          ],
          'Exif/ExposureBiasValue - value -5, 10' => [
              '-0.5', 'Exif', 'ExposureBiasValue', 1, [[-5, 10]], false,
          ],
          'Exif/ExifVersion - short' => [
              'Exif 2.2', 'Exif', 'ExifVersion', 4, [2.2], true,
          ],
          'Exif/ExifVersion - long' => [
              'Exif Version 2.2', 'Exif', 'ExifVersion', 4, [2.2], false,
          ],
          'Exif/FlashPixVersion - short' => [
              'FlashPix 2.5', 'Exif', 'FlashPixVersion', 4, [2.5], true,
          ],
          'Exif/FlashPixVersion - long' => [
              'FlashPix Version 2.5', 'Exif', 'FlashPixVersion', 4, [2.5], false,
          ],
          'Interoperability/InteroperabilityVersion - short' => [
              'Interoperability 1.0', 'Interoperability', 'InteroperabilityVersion', 4, [1], true,
          ],
          'Interoperability/InteroperabilityVersion - long' => [
              'Interoperability Version 1.0', 'Interoperability', 'InteroperabilityVersion', 4, [1], false,
          ],
          'Exif/ComponentsConfiguration' => [
              'Y Cb Cr -', 'Exif', 'ComponentsConfiguration', 4, ["\x01\x02\x03\0"], false,
          ],
          'Exif/FileSource' => [
              'DSC', 'Exif', 'FileSource', 1, ["\x03"], false,
          ],
          'Exif/SceneType' => [
              'Directly photographed', 'Exif', 'SceneType', 1, ["\x01"], false,
          ],
        ];
    }
}
