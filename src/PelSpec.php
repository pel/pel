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
namespace lsolesen\pel;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class to retrieve IFD and TAG information from YAML specs.
 */
class PelSpec
{
    protected static $compiled = false;
    protected static $ifds = [];
    protected static $tags = [];

    protected static function compile()
    {
        if (!static::$compiled) {
            $finder = new Finder();
            $finder->files()->in(dirname(__FILE__) . '/../spec')->name('ifd*.yaml');
            foreach ($finder as $file) {
                $yaml = Yaml::parse($file->getContents());
                static::$ifds[$yaml['id']] = $yaml['type'];
                static::$tags[$yaml['id']] = $yaml['tags'];
            }
            static::$compiled = true;
        }
    }

    public static function getIfdTypes()
    {
        static::compile();
        return static::$ifds;
    }

    public static function getIfdSupportedTagIds($ifd)
    {
        static::compile();
        return array_keys(static::$tags[$ifd]);
    }

    public static function getIfdTags($ifd)
    {
        static::compile();
        return static::$tags[$ifd];
    }
}
