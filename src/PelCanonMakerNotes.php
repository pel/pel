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
 * @author Thanks to Benedikt Rosenkranz <beluro@web.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package
 *
 */
class PelCanonMakerNotes extends PelMakerNotes
{
    private $undefinedMakerNotesTags = [
        0x0000,
        0x0003,
        0x000a,
        0x000e,
        0x0011,
        0x0014,
        0x0016,
        0x0017,
        0x0018,
        0x0019,
        0x001b,
        0x001c,
        0x001d,
        0x001f,
        0x0020,
        0x0021,
        0x0022,
        0x0023,
        0x0024,
        0x0025,
        0x0031,
        0x0035,
        0x0098,
        0x009a,
        0x00b5,
        0x00c0,
        0x00c1,
        0x4008,
        0x4009,
        0x4010,
        0x4011,
        0x4012,
        0x4013,
        0x4015,
        0x4016,
        0x4018,
        0x4019,
        0x4020,
        0x4025,
        0x4027
    ];

    private $undefinedCameraSettingsTags = [
        0x0006,
        0x0008,
        0x0015,
        0x001e,
        0x001f,
        0x0026,
        0x002b,
        0x002c,
        0x002d,
        0x002f,
        0x0030,
        0x0031
    ];

    private $undefinedShotInfoTags = [
        0x0001,
        0x0006,
        0x000a,
        0x000b,
        0x000c,
        0x000d,
        0x0011,
        0x0012,
        0x0014,
        0x0018,
        0x0019,
        0x001d,
        0x001e,
        0x001f,
        0x0020,
        0x0021,
        0x0022
    ];

    private $undefinedPanoramaTags = [
        0x0001,
        0x0003,
        0x0004
    ];

    private $undefinedPicInfoTags = [
        0x0001,
        0x0006,
        0x0007,
        0x0008,
        0x0009,
        0x000a,
        0x000b,
        0x000c,
        0x000d,
        0x000e,
        0x000f,
        0x0010,
        0x0011,
        0x0012,
        0x0013,
        0x0014,
        0x0015,
        0x0017,
        0x0018,
        0x0019,
        0x001b,
        0x001c
    ];

    private $undefinedFileInfoTags = [
        0x0002,
        0x000a,
        0x000b,
        0x0011,
        0x0012,
        0x0016,
        0x0017,
        0x0018,
        0x001a,
        0x001b,
        0x001c,
        0x001d,
        0x001e,
        0x001f,
        0x0020
    ];

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
            // check if tag is defined
            if (in_array($tag, $this->undefinedMakerNotesTags)) {
                continue;
            }
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
                    // $this->parsePictureInfo($mkNotesIfd, $this->data, $data, $components);
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
            throw new PelMakerNotesMalformedException('Size of Canon Camera Settings does not match the number of entries.');
        }
        $camIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            // check if tag is defined
            if (in_array($i+1, $this->undefinedCameraSettingsTags)) {
                continue;
            }
            $camIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, PelFormat::SSHORT);
        }
        $parent->addSubIfd($camIfd);
    }

    private function parseShotInfo($parent, $data, $offset, $components)
    {
        $type = PelIfd::CANON_SHOT_INFO;
        Pel::debug('Found Canon Shot Info sub IFD at offset %d', $offset);
        $size = $data->getShort($offset);
        $offset += 2;
        $elemSize = PelFormat::getSize(PelFormat::SHORT);
        if ($size / $components !== $elemSize) {
            throw new PelMakerNotesMalformedException('Size of Canon Shot Info does not match the number of entries.');
        }
        $shotIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            // check if tag is defined
            if (in_array($i+1, $this->undefinedShotInfoTags)) {
                continue;
            }
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
            throw new PelMakerNotesMalformedException('Size of Canon Panorama does not match the number of entries.');
        }
        $panoramaIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            // check if tag is defined
            if (in_array($i+1, $this->undefinedPanoramaTags)) {
                continue;
            }
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
            throw new PelMakerNotesMalformedException('Size of Canon Picture Info does not match the number of entries. ' . $size . '/' . $components . ' = ' . $elemSize);
        }
        $picIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            // check if tag is defined
            printf("Current Tag: %d\n", ($i+1));
            if (in_array($i+1, $this->undefinedPicInfoTags)) {
                continue;
            }
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
            throw new PelMakerNotesMalformedException('Size of Canon File Info does not match the number of entries.');
        }
        $fileIfd = new PelIfd($type);

        for ($i=0; $i<$components; $i++) {
            // check if tag is defined
            if (in_array($i+1, $this->undefinedFileInfoTags)) {
                continue;
            }
            $format = PelFormat::SSHORT;
            if ($i + 1 == PelTag::CANON_FI_FILE_NUMBER) {
                $format = PelFormat::LONG;
            }
            $fileIfd->loadSingleMakerNotesValue($type, $data, $offset, $size, $i, $format);
        }
        $parent->addSubIfd($fileIfd);
    }
}
