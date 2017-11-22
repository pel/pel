<?php
/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006, 2007 Martin Geisler.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the file COPYING; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA 02110-1301 USA
 */

namespace lsolesen\pel\Util;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class SpecCompiler
{
    /** @var Filesystem */
    private $fs;

    /** @var Finder */
    private $finder;

    /**
     * @param Finder $finder
     * @param Filesystem $fs
     */
    public function __construct(Finder $finder = null, Filesystem $fs = null)
    {
        $this->finder = $finder ? $finder : new Finder();
        $this->fs = $fs ? $fs : new Filesystem();
    }

    /**
     * @param string $yamlDirectory
     */
    public function compile($yamlDirectory)
    {
        $map = [];
        $files = $this->finder->files()->in($yamlDirectory)->name('ifd*.yaml');
        foreach ($files as $file) {
            $yaml = Yaml::parse($file->getContents());
            $map['ifds'][$yaml['id']] = $yaml['type'];
            $map['tags'][$yaml['id']] = $yaml['tags'];
        }
        $data = <<<DATA
<?php

namespace lsolesen\pel;

class PelSpecCompiled {
  public static \$map =
DATA;
        $data .= ' ';
        $data .= preg_replace('/\s+$/m', '', var_export($map, true)) . ';}';
        $this->fs->dumpFile(dirname(__FILE__) . '/../PelSpecCompiled.php', $data);
    }

}
