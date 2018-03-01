<?php

namespace Pel\Test;

use lsolesen\pel\PelEntry;
use lsolesen\pel\PelFormat;
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
        $this->assertEquals([PelFormat::UNDEFINED], PelSpec::getTagFormat(2, 0x9286));
        $this->assertEquals([PelFormat::SHORT, PelFormat::LONG], PelSpec::getTagFormat(2, 0xA002));
        $this->assertNull(PelSpec::getTagFormat(7, 0x0003));

        // Check getTagTitle.
        $this->assertEquals('Exif IFD Pointer', PelSpec::getTagTitle(0, 0x8769));
        $this->assertEquals('Exposure Time', PelSpec::getTagTitle(2, 0x829A));
        $this->assertEquals('Compression', PelSpec::getTagTitle(0, 0x0103));
    }

    /**
     * Tests the PelSpec::getTagClass method.
     */
    public function testGetTagClass()
    {
        $this->assertEquals('lsolesen\pel\PelEntryUserComment', PelSpec::getTagClass(2, 0x9286));
        $this->assertEquals('lsolesen\pel\PelEntryTime', PelSpec::getTagClass(2, 0x9003));
        //@todo drop the else part once PHP < 5.6 (hence PHPUnit 4.8.36) support is removed.
        //@todo change below to PelException::class once PHP 5.4 support is removed.
        if (method_exists($this, 'expectException')) {
            $this->expectException('lsolesen\pel\PelException');
            $this->expectExceptionMessage("No format can be derived for tag: 'MeasuredEV' in ifd: 'Canon Shot Information'");
        } else {
            $this->setExpectedException('lsolesen\pel\PelException', "No format can be derived for tag: 'MeasuredEV' in ifd: 'Canon Shot Information'");
        }
        $this->assertNull(PelSpec::getTagClass(7, 0x0003));
    }

    /**
     * Tests getting decoded TAG text from TAG values.
     *
     * @dataProvider getTagTextProvider
     */
    public function testGetTagText($expected_text, $expected_class, $ifd, $tag, array $args, $brief = false)
    {
        $ifd_id = PelSpec::getIfdIdByType($ifd);
        $tag_id = PelSpec::getTagIdByName($ifd_id, $tag);
        $entry = PelEntry::createNew($ifd_id, $tag_id, $args);
        $this->assertInstanceOf($expected_class, $entry);
        $this->assertEquals($expected_text, PelSpec::getTagText($entry, $brief));
    }

    /**
     * Data provider for testGetTagText.
     */
    public function getTagTextProvider()
    {
        return [
          'IFD0/PlanarConfiguration - value 1' => [
              'chunky format', 'lsolesen\pel\PelEntryShort', 'IFD0', 'PlanarConfiguration', [1],
          ],
          'IFD0/PlanarConfiguration - missing mapping' => [
              null, 'lsolesen\pel\PelEntryShort', 'IFD0', 'PlanarConfiguration', [6.1],
          ],
          'Canon Panorama Information/PanoramaDirection - value 4' => [
              '2x2 Matrix (Clockwise)', 'lsolesen\pel\PelEntryShort', 'Canon Panorama Information', 'PanoramaDirection', [4],
          ],
          'Canon Camera Settings/LensType - value 493' => [
              'Canon EF 500mm f/4L IS II USM or EF 24-105mm f4L IS USM', 'lsolesen\pel\PelEntryShort', 'Canon Camera Settings', 'LensType', [493],
          ],
          'Canon Camera Settings/LensType - value 493.1' => [
              'Canon EF 24-105mm f/4L IS USM', 'lsolesen\pel\PelEntryShort', 'Canon Camera Settings', 'LensType', [493.1],
          ],
          'IFD0/YCbCrSubSampling - value 2, 1' => [
              'YCbCr4:2:2', 'lsolesen\pel\PelEntryShort', 'IFD0', 'YCbCrSubSampling', [2, 1],
          ],
          'IFD0/YCbCrSubSampling - value 2, 2' => [
              'YCbCr4:2:0', 'lsolesen\pel\PelEntryShort', 'IFD0', 'YCbCrSubSampling', [2, 2],
          ],
          'IFD0/YCbCrSubSampling - value 6, 7' => [
              '6, 7', 'lsolesen\pel\PelEntryShort', 'IFD0', 'YCbCrSubSampling', [6, 7],
          ],
          'Exif/SubjectArea - value 6, 7' => [
              '(x,y) = (6,7)', 'lsolesen\pel\PelEntryShort', 'Exif', 'SubjectArea', [6, 7],
          ],
          'Exif/SubjectArea - value 5, 6, 7' => [
              'Within distance 5 of (x,y) = (6,7)', 'lsolesen\pel\PelEntryShort', 'Exif', 'SubjectArea', [5, 6, 7],
          ],
          'Exif/SubjectArea - value 4, 5, 6, 7' => [
              'Within rectangle (width 4, height 5) around (x,y) = (6,7)', 'lsolesen\pel\PelEntryShort', 'Exif', 'SubjectArea', [4, 5, 6, 7],
          ],
          'Exif/SubjectArea - wrong components' => [
              'Unexpected number of components (1, expected 2, 3, or 4).', 'lsolesen\pel\PelEntryShort', 'Exif', 'SubjectArea', [6],
          ],
          'Exif/FNumber - value 60, 10' => [
              'f/6.0', 'lsolesen\pel\PelEntryRational', 'Exif', 'FNumber', [[60, 10]],
          ],
          'Exif/FNumber - value 26, 10' => [
              'f/2.6', 'lsolesen\pel\PelEntryRational', 'Exif', 'FNumber', [[26, 10]],
          ],
          'Exif/ApertureValue - value 60, 10' => [
              'f/8.0', 'lsolesen\pel\PelEntryRational', 'Exif', 'ApertureValue', [[60, 10]],
          ],
          'Exif/ApertureValue - value 26, 10' => [
              'f/2.5', 'lsolesen\pel\PelEntryRational', 'Exif', 'ApertureValue', [[26, 10]],
          ],
          'Exif/FocalLength - value 60, 10' => [
              '6.0 mm', 'lsolesen\pel\PelEntryRational', 'Exif', 'FocalLength', [[60, 10]],
          ],
          'Exif/FocalLength - value 26, 10' => [
              '2.6 mm', 'lsolesen\pel\PelEntryRational', 'Exif', 'FocalLength', [[26, 10]],
          ],
          'Exif/SubjectDistance - value 60, 10' => [
              '6.0 m', 'lsolesen\pel\PelEntrySRational', 'Exif', 'SubjectDistance', [[60, 10]],
          ],
          'Exif/SubjectDistance - value 26, 10' => [
              '2.6 m', 'lsolesen\pel\PelEntrySRational', 'Exif', 'SubjectDistance', [[26, 10]],
          ],
          'Exif/ExposureTime - value 60, 10' => [
              '6 sec.', 'lsolesen\pel\PelEntryRational', 'Exif', 'ExposureTime', [[60, 10]],
          ],
          'Exif/ExposureTime - value 5, 10' => [
              '1/2 sec.', 'lsolesen\pel\PelEntryRational', 'Exif', 'ExposureTime', [[5, 10]],
          ],
          'GPS/GPSLongitude' => [
              '30° 45\' 28" (30.76°)', 'lsolesen\pel\PelEntryRational', 'GPS', 'GPSLongitude', [[30, 1], [45, 1], [28, 1]],
          ],
          'GPS/GPSLatitude' => [
              '50° 33\' 12" (50.55°)', 'lsolesen\pel\PelEntryRational', 'GPS', 'GPSLatitude', [[50, 1], [33, 1], [12, 1]],
          ],
          'Exif/ShutterSpeedValue - value 5, 10' => [
              '5/10 sec. (APEX: 1)', 'lsolesen\pel\PelEntrySRational', 'Exif', 'ShutterSpeedValue', [[5, 10]],
          ],
          'Exif/BrightnessValue - value 5, 10' => [
              '5/10', 'lsolesen\pel\PelEntrySRational', 'Exif', 'BrightnessValue', [[5, 10]],
          ],
          'Exif/ExposureBiasValue - value 5, 10' => [
              '+0.5', 'lsolesen\pel\PelEntrySRational', 'Exif', 'ExposureBiasValue', [[5, 10]],
          ],
          'Exif/ExposureBiasValue - value -5, 10' => [
              '-0.5', 'lsolesen\pel\PelEntrySRational', 'Exif', 'ExposureBiasValue', [[-5, 10]],
          ],
          'Exif/ExifVersion - short' => [
              'Exif 2.2', 'lsolesen\pel\PelEntryVersion', 'Exif', 'ExifVersion', [2.2], true,
          ],
          'Exif/ExifVersion - long' => [
              'Exif Version 2.2', 'lsolesen\pel\PelEntryVersion', 'Exif', 'ExifVersion', [2.2],
          ],
          'Exif/FlashPixVersion - short' => [
              'FlashPix 2.5', 'lsolesen\pel\PelEntryVersion', 'Exif', 'FlashPixVersion', [2.5], true,
          ],
          'Exif/FlashPixVersion - long' => [
              'FlashPix Version 2.5', 'lsolesen\pel\PelEntryVersion', 'Exif', 'FlashPixVersion', [2.5],
          ],
          'Interoperability/InteroperabilityVersion - short' => [
              'Interoperability 1.0', 'lsolesen\pel\PelEntryVersion', 'Interoperability', 'InteroperabilityVersion', [1], true,
          ],
          'Interoperability/InteroperabilityVersion - long' => [
              'Interoperability Version 1.0', 'lsolesen\pel\PelEntryVersion', 'Interoperability', 'InteroperabilityVersion', [1],
          ],
          'Exif/ComponentsConfiguration' => [
              'Y Cb Cr -', 'lsolesen\pel\PelEntryUndefined', 'Exif', 'ComponentsConfiguration', ["\x01\x02\x03\0"],
          ],
          'Exif/FileSource' => [
              'DSC', 'lsolesen\pel\PelEntryUndefined', 'Exif', 'FileSource', ["\x03"],
          ],
          'Exif/SceneType' => [
              'Directly photographed', 'lsolesen\pel\PelEntryUndefined', 'Exif', 'SceneType', ["\x01"],
          ],
        ];
    }
}
