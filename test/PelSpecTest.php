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
    }
}
