<?php

use lsolesen\pel\Util\SpecCompiler;
use lsolesen\pel\PelSpec;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test compilation of a set of PEL specification YAML files.
 */
class SpecCompilerTest extends TestCase
{
    /** @var Filesystem */
    private $fs;

    /** @var string */
    private $testResourceDirectory;

    /**
     * {@inheritdoc}
     */
    public function setUp() {
        parent::setUp();
        $this->testResourceDirectory = __DIR__ . '/../test_resources';
        $this->fs = new Filesystem();
        $this->fs->mkdir($this->testResourceDirectory);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown() {
        $this->fs->remove($this->testResourceDirectory);
        parent::tearDown();
    }

    /**
     * Tests that compiling an invalid YAML file raises exception.
     */
    public function testInvalidYaml()
    {
        //@todo change below to ParseException::class once PHP 5.4 support is removed.
        $this->expectException('Symfony\Component\Yaml\Exception\ParseException');
        $compiler = new SpecCompiler();
        $compiler->compile(__DIR__ . '/fixtures/spec/invalid_yaml', $this->testResourceDirectory);
    }

    /**
     * Tests that compiling a YAML file with invalid IFD keys raises exception.
     */
    public function testInvalidIfdKeys()
    {
        //@todo change below to SpecCompilerException::class once PHP 5.4 support is removed.
        $this->expectException('lsolesen\pel\Util\SpecCompilerException');
        $this->expectExceptionMessage('ifd_ifd0.yaml: invalid IFD key(s) found - bork');
        $compiler = new SpecCompiler();
        $compiler->compile(__DIR__ . '/fixtures/spec/invalid_ifd_keys', $this->testResourceDirectory);
    }

    /**
     * Tests that compiling a YAML file with invalid TAG keys raises exception.
     */
    public function testInvalidTagKeys()
    {
        //@todo change below to SpecCompilerException::class once PHP 5.4 support is removed.
        $this->expectException('lsolesen\pel\Util\SpecCompilerException');
        $this->expectExceptionMessage("ifd_ifd0.yaml: invalid key(s) found for TAG 'ImageWidth' - bork");
        $compiler = new SpecCompiler();
        $compiler->compile(__DIR__ . '/fixtures/spec/invalid_tag_keys', $this->testResourceDirectory);
    }

    /**
     * Tests that compiling a YAML file with invalid sub IFD raises exception.
     */
    public function testInvalidSubIfd()
    {
        //@todo change below to SpecCompilerException::class once PHP 5.4 support is removed.
        $this->expectException('lsolesen\pel\Util\SpecCompilerException');
        $this->expectExceptionMessage("Invalid sub IFD(s) found for TAG 'ExifIFDPointer': *** EXPECTED FAILURE ***");
        $compiler = new SpecCompiler();
        $compiler->compile(__DIR__ . '/fixtures/spec/invalid_subifd', $this->testResourceDirectory);
    }

    /**
     * Tests compiling a valid specifications stub set.
     */
    public function testValidStubSpec()
    {
        $compiler = new SpecCompiler();
        $compiler->compile(__DIR__ . '/fixtures/spec/valid_stub', $this->testResourceDirectory);
        PelSpec::setMap($this->testResourceDirectory . '/spec.php');
        $this->assertEquals([2 => 'Exif', 0 => '0'], PelSpec::getIfdTypes());

        $this->assertEquals(0x0100, PelSpec::getTagIdByName(0, 'ImageWidth'));
        $this->assertEquals(0x8769, PelSpec::getTagIdByName(0, 'ExifIFDPointer'));
        $this->assertEquals(0x829A, PelSpec::getTagIdByName(2, 'ExposureTime'));

        // Compression is missing from the stub specs.
        $this->assertNull(PelSpec::getTagIdByName(0, 'Compression'));
    }
}
