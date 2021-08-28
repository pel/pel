<?php
/*
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005 Martin Geisler.
 * Copyright (C) 2017 Johannes Weberhofer.
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

/**
 * Namespace for functions operating on Exif formats.
 *
 * This class defines the constants that are to be used whenever one
 * has to refer to the format of an Exif tag. They will be
 * collectively denoted by the pseudo-type PelFormat throughout the
 * documentation.
 *
 * All the methods defined here are static, and they all operate on a
 * single argument which should be one of the class constants.
 *
 * @author Vinzenz Rosenkranz <vinzenz.rosenkranz@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package
 *
 */
namespace lsolesen\pel;

abstract class PelMakerNotes
{

    protected $type;

    protected $parent;

    protected $data;

    protected $components;

    protected $offset;

    public static function createMakerNotesFromManufacturer($man, $parent, $data, $size, $offset)
    {
        switch ($man) {
            case 'Canon':
                return new PelCanonMakerNotes($parent, $data, $size, $offset);
            default:
                return null;
        }
    }

    public function __construct($parent, $data, $size, $offset)
    {
        $this->parent = $parent;
        $this->data = $data;
        $this->size = $size;
        $this->offset = $offset;
        $this->components = 0;
        Pel::debug('Creating MakerNotes with %d bytes at offset %d.', $size, $offset);
    }

    abstract public function load();
}
