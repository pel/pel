<?php

namespace lsolesen\pel\Util;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Compiles a set of PEL specification YAML files.
 */
class SpecCompiler
{
    /**
     * Map of expected IFD level array keys.
     */
    private $ifdKeys = ['const', 'type', 'alias', 'tags', 'makerNotes'];

    /**
     * Map of expected TAG level array keys.
     */
    private $tagKeys = ['const', 'name', 'title', 'components', 'format', 'ifd', 'text'];

    /** @var Filesystem */
    private $fs;

    /** @var Finder */
    private $finder;

    /**
     * The compiled PEL specification map.
     *
     * @var array
     */
    private $map = [];

    /**
     * Constructs a SpecCompiler object.
     *
     * @param Finder $finder
     * @param Filesystem $fs
     */
    public function __construct(Finder $finder = null, Filesystem $fs = null)
    {
        $this->finder = $finder ? $finder : new Finder();
        $this->fs = $fs ? $fs : new Filesystem();
    }

    /**
     * Compiles a set of PEL specification YAML files.
     *
     * @param string $yamlDirectory
     *            the directory containing a set of .yaml specification files.
     * @param string $resourcesDirectory
     *            the directory where the compiled PHP specification file will
     *            be stored.
     */
    public function compile($yamlDirectory, $resourcesDirectory)
    {
        $files = $this->finder->files()->in($yamlDirectory)->name('ifd*.yaml');

        // Process the files. Each file corresponds to an IFD specification.
        foreach ($files as $file) {
            $ifd = Yaml::parse($file->getContents());
            $this->mapIfd($ifd, $file);
        }

        // Re-process the IFDs and TAGs for any task needing the entire
        // specification set to be available.
        foreach ($this->map['ifds'] as $ifd_id => $ifd_type) {
            foreach ($this->map['tags'][$ifd_id] as $tag_id => &$tag) {
                // For sub-ifds, check the corresponding IFD exists and map it
                // to the IFD id instead of the literal.
                if (isset($tag['ifd'])) {
                    if (!isset($this->map['ifdsByType'][$tag['ifd']])) {
                        throw new SpecCompilerException("Invalid sub IFD(s) found for TAG '" . $tag['name'] . "': " . $tag['ifd']);
                    } else {
                        $tag['ifd'] = $this->map['ifdsByType'][$tag['ifd']];
                    }
                }
            }
        }

        // Dump the data to the spec.php file.
        $data = <<<DATA
<?php
/**
 * This file is generated automatically by executing the 'pel compile' command.
 *
 * DO NOT CHANGE MANUALLY.
 */
return
DATA;
        $data .= ' ';
        $data .= preg_replace('/\s+$/m', '', var_export($this->map, true)) . ';';
        $this->fs->dumpFile($resourcesDirectory . '/spec.php', $data);
    }

    /**
     * Processes an IFD into the compiled map.
     *
     * @param array $ifd
     *            an IFD array from the specification file.
     * @param SplFileInfo $file
     *            the YAML specification file being processed.
     */
    protected function mapIfd(array $ifd, SplFileInfo $file)
    {
        // Check validity of IFD keys.
        $diff = array_diff(array_keys($ifd), $this->ifdKeys);
        if (!empty($diff)) {
            throw new SpecCompilerException($file->getFileName() . ": invalid IFD key(s) found - " . implode(", ", $diff));
        }

        // Add some defaults.
        $ifd = array_merge([
            'const' => null,
            'type' => null,
            'tags' => [],
        ], $ifd);

        // 'ifds' entry.
        $this->map['ifds'][$ifd['const']] = $ifd['type'];

        // 'ifdsByType' (reverse lookup) entry.
        $this->map['ifdsByType'][$ifd['type']] = $ifd['const'];
        if (!empty($ifd['alias'])) {
            foreach ($ifd['alias'] as $alias) {
                $this->map['ifdsByType'][$alias] = $ifd['const'];
            }
        }

        // 'makerNotes' entry.
        if (!empty($ifd['makerNotes'])) {
            foreach ($ifd['makerNotes'] as $maker) {
                $this->map['makerNotes'][$maker] = $ifd['const'];
            }
        }

        // Map the IFD's tags.
        foreach ($ifd['tags'] as $tag_id => $tag) {
            $this->mapTag($ifd['const'], $tag_id, $tag, $file);
        }
    }

    /**
     * Processes a TAG into the compiled map.
     *
     * @param int $ifd_id
     *            the IFD id of the TAG.
     * @param int $tag_id
     *            the TAG id.
     * @param array $tag
     *            the TAG array from the specification file.
     * @param SplFileInfo $file
     *            the YAML specification file being processed.
     */
    protected function mapTag($ifd_id, $tag_id, array $tag, SplFileInfo $file)
    {
        // Add some defaults.
        $tag = array_merge([
            'const' => null,
            'name' => $tag_id,
        ], $tag);

        // Check validity of TAG keys.
        $diff = array_diff(array_keys($tag), $this->tagKeys);
        if (!empty($diff)) {
            throw new SpecCompilerException($file->getFileName() . ": invalid key(s) found for TAG '" . $tag['name'] . "' - " . implode(", ", $diff));
        }

        // 'tags' entry.
        $this->map['tags'][$ifd_id][$tag_id] = $tag;

        // 'tagsByName' (reverse lookup) entry.
        $this->map['tagsByName'][$ifd_id][$tag['name']] = $tag_id;
    }
}
