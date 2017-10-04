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
namespace lsolesen\pel;

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
class PelCanonMakerNotes extends PelMakerNotes
{
    public function __construct($parent, $data, $size, $offset)
    {
        parent::__construct($parent, $data, $size, $offset);
        $this->type = PelIfd::CANON_MAKER_NOTES;
    }

    public function load()
    {
        $this->components = $this->data->getShort($this->offset);
        $this->offset += 2;
        Pel::debug('Loading %d components in maker notes.', $this->components);
        $mkNotesIfd = new PelIfd(PelIfd::CANON_MAKER_NOTES);

        for ($i = 0; $i < $this->components; $i++) {
            $tag = $this->data->getShort($this->offset + 12 * $i);
            $type = $this->data->getShort($this->offset + 12 * $i + 2);
            $components = $this->data->getLong($this->offset + 12 * $i + 4);
            $data = $this->data->getLong($this->offset + 12 * $i + 8);
            switch ($tag) {
                case PelTag::CANON_CAMERA_SETTINGS:
                    $this->parseCameraSettings($mkNotesIfd, $this->data, $data, $components);
                    break;
                case PelTag::CANON_SHOT_INFO:
                    $this->parseShotInfo($mkNotesIfd, $this->data, $data, $components);
                    break;
                case PelTag::CANON_PANORAMA:
                    $this->parsePanorama($mkNotesIfd, $this->data, $data, $components);
                    break;
                case PelTag::CANON_PICTURE_INFO:
                    $this->parsePictureInfo($mkNotesIfd, $this->data, $data, $components);
                    break;
                case PelTag::CANON_FILE_INFO:
                    $this->parseFileInfo($mkNotesIfd, $this->data, $data, $components);
                    break;
                case PelTag::CANON_CUSTOM_FUNCTIONS:
                    //TODO
                default:
                    $mkNotesIfd->loadSingleValue($this->data, $this->offset, $i, $tag);
                    break;
            }
        }
        $this->parent->addSubIfd($mkNotesIfd);
    }

    private function parseCameraSettings($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_CAMERA_SETTINGS;
        Pel::debug('Found Canon Camera Settings sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SSHORT);
        if ($size / $components !== $elemSize) {
            // TODO throw
        }
        $camIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            $camIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, PelFormat::SSHORT);
        }
        $parent->addSubIfd($camIfd);
    }

    private function parseShotInfo($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_SHOT_INFO;
        Pel::debug('Found Canon Camera Settings sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SHORT);
        if ($size / $components !== $elemSize) {
            // TODO throw
        }
        $shotIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            $shotIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, PelFormat::SHORT);
        }
        $parent->addSubIfd($shotIfd);
    }

    private function parsePanorama($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_PANORAMA;
        Pel::debug('Found Canon Panorama sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SHORT);
        if ($size / $components !== $elemSize) {
            // TODO throw
        }
        $panoramaIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            $panoramaIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, PelFormat::SHORT);
        }
        $parent->addSubIfd($panoramaIfd);
    }

    private function parsePictureInfo($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_PICTURE_INFO;
        Pel::debug('Found Canon Picture Info sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SHORT);
        if ($size / $components !== $elemSize) {
            // TODO throw
        }
        $picIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            $picIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, PelFormat::SHORT);
        }
        $parent->addSubIfd($picIfd);
    }

    private function parseFileInfo($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_FILE_INFO;
        Pel::debug('Found Canon File Info sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SSHORT);
        if ($size === $elemSize*($components-1) + PelFormat::getSize(PelFormat::LONG)) {
            // TODO throw
        }
        $fileIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            $format = PelFormat::SSHORT;
            if ($i + 1 == PelTag::CANON_FI_FILE_NUMBER) {
                $format = PelFormat::LONG;
            }
            $fileIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, $format);
        }
        $parent->addSubIfd($fileIfd);
    }
}
