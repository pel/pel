<?php

/**
 * PEL: PHP Exif Library.
 * A library with support for reading and
 * writing all Exif headers in JPEG and TIFF images using PHP.
 *
 * Copyright (C) 2004, 2005, 2006 Martin Geisler.
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
 * Classes used to hold shorts, both signed and unsigned.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 *          License (GPL)
 * @package PEL
 */

/**
 * Class for holding signed shorts.
 *
 * This class can hold shorts, either just a single short or an array
 * of shorts. The class will be used to manipulate any of the Exif
 * tags which has format {@link PelFormat::SSHORT}.
 *
 * @author Martin Geisler <mgeisler@users.sourceforge.net>
 * @package PEL
 */
namespace lsolesen\pel;

class PelEntrySShort extends PelEntryNumber
{

    private const TRANSLATIONS = [
        PelIfd::CANON_FILE_INFO => [
            PelTag::CANON_FI_BRACKET_MODE => [
                0 => 'Off',
                1 => 'AEB',
                2 => 'FEB',
                3 => 'ISO',
                4 => 'WB'
            ],
            PelTag::CANON_FI_RAW_JPG_QUALITY => [
                1 => 'Economy',
                2 => 'Normal',
                3 => 'Fine',
                4 => 'RAW',
                5 => 'Superfine',
                130 => 'Normal Movie',
                131 => 'Movie (2)'
            ],
            PelTag::CANON_FI_RAW_JPG_SIZE => [
                0 => 'Large',
                1 => 'Medium',
                2 => 'Small',
                5 => 'Medium 1',
                6 => 'Medium 2',
                7 => 'Medium 3',
                8 => 'Postcard',
                9 => 'Widescreen',
                10 => 'Medium Widescreen',
                14 => 'Small 1',
                15 => 'Small 2',
                16 => 'Small 3',
                128 => '640x480 Movie',
                129 => 'Medium Movie',
                130 => 'Small Movie',
                137 => '1280x720 Movie',
                142 => '1920x1080 Movie'
            ],
            PelTag::CANON_FI_NOISE_REDUCTION => [
                0 => 'Off',
                1 => 'On (1D)',
                3 => 'On',
                4 => 'Auto'
            ],
            PelTag::CANON_FI_WB_BRACKET_MODE => [
                0 => 'Off',
                1 => 'On (shift AB)',
                2 => 'On (shift GM)'
            ],
            PelTag::CANON_FI_FILTER_EFFECT => [
                0 => 'None',
                1 => 'Yellow',
                2 => 'Orange',
                3 => 'Red',
                4 => 'Green'
            ],
            PelTag::CANON_FI_TONING_EFFECT => [
                0 => 'None',
                1 => 'Sepia',
                2 => 'Blue',
                3 => 'Purple',
                4 => 'Green'
            ],
            PelTag::CANON_FI_LIVE_VIEW_SHOOTING => [
                0 => 'Off',
                1 => 'On'
            ],
            PelTag::CANON_FI_FLASH_EXPOSURE_LOCK => [
                0 => 'Off',
                1 => 'On'
            ]
        ],
        PelIfd::CANON_CAMERA_SETTINGS => [
            PelTag::CANON_CS_MACRO => [
                1 => 'Macro',
                2 => 'Normal'
            ],
            PelTag::CANON_CS_QUALITY => [
                1 => 'Economy',
                2 => 'Normal',
                3 => 'Fine',
                4 => 'RAW',
                5 => 'Superfine',
                130 => 'Normal Movie',
                131 => 'Movie (2)'
            ],
            PelTag::CANON_CS_FLASH_MODE => [
                0 => 'Off',
                1 => 'Auto',
                2 => 'On',
                3 => 'Red-eye reduction',
                4 => 'Slow-sync',
                5 => 'Red-eye reduction (Auto)',
                6 => 'Red-eye reduction (On)',
                16 => 'External flash'
            ],
            PelTag::CANON_CS_DRIVE_MODE => [
                0 => 'Single',
                1 => 'Continuous',
                2 => 'Movie',
                3 => 'Continuous, Speed Priority',
                4 => 'Continuous, Low',
                5 => 'Continuous, High',
                6 => 'Silent Single',
                9 => 'Single, Silent',
                10 => 'Continuous, Silent'
            ],
            PelTag::CANON_CS_FOCUS_MODE => [
                0 => 'One-shot AF',
                1 => 'AI Servo AF',
                2 => 'AI Focus AF',
                3 => 'Manual Focus (3)',
                4 => 'Single',
                5 => 'Continuous',
                6 => 'Manual Focus (6)',
                16 => 'Pan Focus',
                256 => 'AF + MF',
                512 => 'Movie Snap Focus',
                519 => 'Movie Servo AF'
            ],
            PelTag::CANON_CS_RECORD_MODE => [
                1 => 'JPEG',
                2 => 'CRW+THM',
                3 => 'AVI+THM',
                4 => 'TIF',
                5 => 'TIF+JPEG',
                6 => 'CR2',
                7 => 'CR2+JPEG',
                9 => 'MOV',
                10 => 'MP4'
            ],
            PelTag::CANON_CS_IMAGE_SIZE => [
                0 => 'Large',
                1 => 'Medium',
                2 => 'Small',
                5 => 'Medium 1',
                6 => 'Medium 2',
                7 => 'Medium 3',
                8 => 'Postcard',
                9 => 'Widescreen',
                10 => 'Medium Widescreen',
                14 => 'Small 1',
                15 => 'Small 2',
                16 => 'Small 3',
                128 => '640x480 Movie',
                129 => 'Medium Movie',
                130 => 'Small Movie',
                137 => '1280x720 Movie',
                142 => '1920x1080 Movie'
            ],
            PelTag::CANON_CS_EASY_MODE => [
                0 => 'Full auto',
                1 => 'Manual',
                2 => 'Landscape',
                3 => 'Fast shutter',
                4 => 'Slow shutter',
                5 => 'Night',
                6 => 'Gray Scale',
                7 => 'Sepia',
                8 => 'Portrait',
                9 => 'Sports',
                10 => 'Macro',
                11 => 'Black & White',
                12 => 'Pan focus',
                13 => 'Vivid',
                14 => 'Neutral',
                15 => 'Flash Off',
                16 => 'Long Shutter',
                17 => 'Super Macro',
                18 => 'Foliage',
                19 => 'Indoor',
                20 => 'Fireworks',
                21 => 'Beach',
                22 => 'Underwater',
                23 => 'Snow',
                24 => 'Kids & Pets',
                25 => 'Night Snapshot',
                26 => 'Digital Macro',
                27 => 'My Colors',
                28 => 'Movie Snap',
                29 => 'Super Macro 2',
                30 => 'Color Accent',
                31 => 'Color Swap',
                32 => 'Aquarium',
                33 => 'ISO 3200',
                34 => 'ISO 6400',
                35 => 'Creative Light Effect',
                36 => 'Easy',
                37 => 'Quick Shot',
                38 => 'Creative Auto',
                39 => 'Zoom Blur',
                40 => 'Low Light',
                41 => 'Nostalgic',
                42 => 'Super Vivid',
                43 => 'Poster Effect',
                44 => 'Face Self-timer',
                45 => 'Smile',
                46 => 'Wink Self-timer',
                47 => 'Fisheye Effect',
                48 => 'Miniature Effect',
                49 => 'High-speed Burst',
                50 => 'Best Image Selection',
                51 => 'High Dynamic Range',
                52 => 'Handheld Night Scene',
                53 => 'Movie Digest',
                54 => 'Live View Control',
                55 => 'Discreet',
                56 => 'Blur Reduction',
                57 => 'Monochrome',
                58 => 'Toy Camera Effect',
                59 => 'Scene Intelligent Auto',
                60 => 'High-speed Burst HQ',
                61 => 'Smooth Skin',
                62 => 'Soft Focus',
                257 => 'Spotlight',
                258 => 'Night 2',
                259 => 'Night+',
                260 => 'Super Night',
                261 => 'Sunset',
                263 => 'Night Scene',
                264 => 'Surface',
                265 => 'Low Light 2'
            ],
            PelTag::CANON_CS_DIGITAL_ZOOM => [
                0 => 'None',
                1 => '2x',
                2 => '4x',
                3 => 'Other'
            ],
            PelTag::CANON_CS_CONTRAST => [
                0 => 'Normal'
            ],
            PelTag::CANON_CS_SATURATION => [
                0 => 'Normal'
            ],
            PelTag::CANON_CS_METERING_MODE => [
                0 => 'Default',
                1 => 'Spot',
                2 => 'Average',
                3 => 'Evaluative',
                4 => 'Partial',
                5 => 'Center-weighted average'
            ],
            PelTag::CANON_CS_FOCUS_TYPE => [
                0 => 'Manual',
                1 => 'Auto',
                2 => 'Not Known',
                3 => 'Macro',
                4 => 'Very Close',
                5 => 'Close',
                6 => 'Middle Range',
                7 => 'Far Range',
                8 => 'Pan Focus',
                9 => 'Super Macro',
                10 => 'Infinity'
            ],
            PelTag::CANON_CS_AF_POINT => [
                0x2005 => 'Manual AF point selection',
                0x3000 => 'None (MF)',
                0x3001 => 'Auto AF point selection',
                0x3002 => 'Right',
                0x3003 => 'Center',
                0x3004 => 'Left',
                0x4001 => 'Auto AF point selection',
                0x4006 => 'Face Detect'
            ],
            PelTag::CANON_CS_EXPOSURE_PROGRAM => [
                0 => 'Easy',
                1 => 'Program AE',
                2 => 'Shutter speed priority AE',
                3 => 'Aperture-priority AE',
                4 => 'Manual',
                5 => 'Depth-of-field AE',
                6 => 'M-Dep',
                7 => 'Bulb'
            ],
            PelTag::CANON_CS_LENS_TYPE => [
                // ATTENTION: Every index is multiplied by 100
                1000 => 'Canon EF 50mm f/1.8',
                2000 => 'Canon EF 28mm f/2.8',
                3000 => 'Canon EF 135mm f/2.8 Soft',
                4000 => 'Canon EF 35-105mm f/3.5-4.5 or Sigma Lens',
                4100 => 'Sigma UC Zoom 35-135mm f/4-5.6',
                5000 => 'Canon EF 35-70mm f/3.5-4.5',
                6000 => 'Canon EF 28-70mm f/3.5-4.5 or Sigma or Tokina Lens',
                6100 => 'Sigma 18-50mm f/3.5-5.6 DC',
                6200 => 'Sigma 18-125mm f/3.5-5.6 DC IF ASP',
                6300 => 'Tokina AF 193-2 19-35mm f/3.5-4.5',
                6400 => 'Sigma 28-80mm f/3.5-5.6 II Macro',
                7000 => 'Canon EF 100-300mm f/5.6L',
                8000 => 'Canon EF 100-300mm f/5.6 or Sigma or Tokina Lens',
                8100 => 'Sigma 70-300mm f/4-5.6 [APO] DG Macro',
                8200 => 'Tokina AT-X 242 AF 24-200mm f/3.5-5.6',
                9000 => 'Canon EF 70-210mm f/4',
                9100 => 'Sigma 55-200mm f/4-5.6 DC',
                1000 => 'Canon EF 50mm f/2.5 Macro or Sigma Lens',
                1010 => 'Sigma 50mm f/2.8 EX',
                1020 => 'Sigma 28mm f/1.8',
                1030 => 'Sigma 105mm f/2.8 Macro EX',
                1040 => 'Sigma 70mm f/2.8 EX DG Macro EF',
                1100 => 'Canon EF 35mm f/2',
                1300 => 'Canon EF 15mm f/2.8 Fisheye',
                1400 => 'Canon EF 50-200mm f/3.5-4.5L',
                1500 => 'Canon EF 50-200mm f/3.5-4.5',
                1600 => 'Canon EF 35-135mm f/3.5-4.5',
                1700 => 'Canon EF 35-70mm f/3.5-4.5A',
                1800 => 'Canon EF 28-70mm f/3.5-4.5',
                2000 => 'Canon EF 100-200mm f/4.5A',
                2100 => 'Canon EF 80-200mm f/2.8L',
                2200 => 'Canon EF 20-35mm f/2.8L or Tokina Lens',
                2210 => 'Tokina AT-X 280 AF Pro 28-80mm f/2.8 Aspherical',
                2300 => 'Canon EF 35-105mm f/3.5-4.5',
                2400 => 'Canon EF 35-80mm f/4-5.6 Power Zoom',
                2500 => 'Canon EF 35-80mm f/4-5.6 Power Zoom',
                2600 => 'Canon EF 100mm f/2.8 Macro or Other Lens',
                2610 => 'Cosina 100mm f/3.5 Macro AF',
                2620 => 'Tamron SP AF 90mm f/2.8 Di Macro',
                2630 => 'Tamron SP AF 180mm f/3.5 Di Macro',
                2640 => 'Carl Zeiss Planar T* 50mm f/1.4',
                2700 => 'Canon EF 35-80mm f/4-5.6',
                2800 => 'Canon EF 80-200mm f/4.5-5.6 or Tamron Lens',
                2810 => 'Tamron SP AF 28-105mm f/2.8 LD Aspherical IF',
                2820 => 'Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro',
                2830 => 'Tamron AF 70-300mm f/4-5.6 Di LD 1:2 Macro',
                2840 => 'Tamron AF Aspherical 28-200mm f/3.8-5.6',
                2900 => 'Canon EF 50mm f/1.8 II',
                3000 => 'Canon EF 35-105mm f/4.5-5.6',
                3100 => 'Canon EF 75-300mm f/4-5.6 or Tamron Lens',
                3110 => 'Tamron SP AF 300mm f/2.8 LD IF',
                3200 => 'Canon EF 24mm f/2.8 or Sigma Lens',
                3210 => 'Sigma 15mm f/2.8 EX Fisheye',
                3300 => 'Voigtlander or Carl Zeiss Lens',
                3310 => 'Voigtlander Ultron 40mm f/2 SLII Aspherical',
                3320 => 'Voigtlander Color Skopar 20mm f/3.5 SLII Aspherical',
                3330 => 'Voigtlander APO-Lanthar 90mm f/3.5 SLII Close Focus',
                3340 => 'Carl Zeiss Distagon T* 15mm f/2.8 ZE',
                3350 => 'Carl Zeiss Distagon T* 18mm f/3.5 ZE',
                3360 => 'Carl Zeiss Distagon T* 21mm f/2.8 ZE',
                3370 => 'Carl Zeiss Distagon T* 25mm f/2 ZE',
                3380 => 'Carl Zeiss Distagon T* 28mm f/2 ZE',
                3390 => 'Carl Zeiss Distagon T* 35mm f/2 ZE',
                3310 => 'Carl Zeiss Distagon T* 35mm f/1.4 ZE',
                3311 => 'Carl Zeiss Planar T* 50mm f/1.4 ZE',
                3312 => 'Carl Zeiss Makro-Planar T* 50mm f/2 ZE',
                3313 => 'Carl Zeiss Makro-Planar T* 100mm f/2 ZE',
                3314 => 'Carl Zeiss Apo-Sonnar T* 135mm f/2 ZE',
                3500 => 'Canon EF 35-80mm f/4-5.6',
                3600 => 'Canon EF 38-76mm f/4.5-5.6',
                3700 => 'Canon EF 35-80mm f/4-5.6 or Tamron Lens',
                3710 => 'Tamron 70-200mm f/2.8 Di LD IF Macro',
                3720 => 'Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20',
                3730 => 'Tamron SP AF 17-50mm f/2.8 XR Di II VC LD Aspherical [IF]',
                3740 => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC LD Aspherical [IF] Macro',
                3800 => 'Canon EF 80-200mm f/4.5-5.6',
                3900 => 'Canon EF 75-300mm f/4-5.6',
                4000 => 'Canon EF 28-80mm f/3.5-5.6',
                4100 => 'Canon EF 28-90mm f/4-5.6',
                4200 => 'Canon EF 28-200mm f/3.5-5.6 or Tamron Lens',
                4210 => 'Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20',
                4300 => 'Canon EF 28-105mm f/4-5.6',
                4400 => 'Canon EF 90-300mm f/4.5-5.6',
                4500 => 'Canon EF-S 18-55mm f/3.5-5.6 [II]',
                4600 => 'Canon EF 28-90mm f/4-5.6',
                4700 => 'Zeiss Milvus 35mm f/2 or 50mm f/2',
                4710 => 'Zeiss Milvus 50mm f/2 Makro',
                4800 => 'Canon EF-S 18-55mm f/3.5-5.6 IS',
                4900 => 'Canon EF-S 55-250mm f/4-5.6 IS',
                5000 => 'Canon EF-S 18-200mm f/3.5-5.6 IS',
                5100 => 'Canon EF-S 18-135mm f/3.5-5.6 IS',
                5200 => 'Canon EF-S 18-55mm f/3.5-5.6 IS II',
                5300 => 'Canon EF-S 18-55mm f/3.5-5.6 III',
                5400 => 'Canon EF-S 55-250mm f/4-5.6 IS II',
                6000 => 'Irix 11mm f/4',
                9400 => 'Canon TS-E 17mm f/4L',
                9500 => 'Canon TS-E 24.0mm f/3.5 L II',
                12400 => 'Canon MP-E 65mm f/2.8 1-5x Macro Photo',
                12500 => 'Canon TS-E 24mm f/3.5L',
                12600 => 'Canon TS-E 45mm f/2.8',
                12700 => 'Canon TS-E 90mm f/2.8',
                12900 => 'Canon EF 300mm f/2.8L',
                13000 => 'Canon EF 50mm f/1.0L',
                13100 => 'Canon EF 28-80mm f/2.8-4L or Sigma Lens',
                13110 => 'Sigma 8mm f/3.5 EX DG Circular Fisheye',
                13120 => 'Sigma 17-35mm f/2.8-4 EX DG Aspherical HSM',
                13130 => 'Sigma 17-70mm f/2.8-4.5 DC Macro',
                13140 => 'Sigma APO 50-150mm f/2.8 [II] EX DC HSM',
                13150 => 'Sigma APO 120-300mm f/2.8 EX DG HSM',
                13160 => 'Sigma 4.5mm f/2.8 EX DC HSM Circular Fisheye',
                13170 => 'Sigma 70-200mm f/2.8 APO EX HSM',
                13200 => 'Canon EF 1200mm f/5.6L',
                13400 => 'Canon EF 600mm f/4L IS',
                13500 => 'Canon EF 200mm f/1.8L',
                13600 => 'Canon EF 300mm f/2.8L',
                13700 => 'Canon EF 85mm f/1.2L or Sigma or Tamron Lens',
                13710 => 'Sigma 18-50mm f/2.8-4.5 DC OS HSM',
                13720 => 'Sigma 50-200mm f/4-5.6 DC OS HSM',
                13730 => 'Sigma 18-250mm f/3.5-6.3 DC OS HSM',
                13740 => 'Sigma 24-70mm f/2.8 IF EX DG HSM',
                13750 => 'Sigma 18-125mm f/3.8-5.6 DC OS HSM',
                13760 => 'Sigma 17-70mm f/2.8-4 DC Macro OS HSM | C',
                13770 => 'Sigma 17-50mm f/2.8 OS HSM',
                13780 => 'Sigma 18-200mm f/3.5-6.3 DC OS HSM [II]',
                13790 => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD',
                13710 => 'Sigma 8-16mm f/4.5-5.6 DC HSM',
                13711 => 'Tamron SP 17-50mm f/2.8 XR Di II VC',
                13712 => 'Tamron SP 60mm f/2 Macro Di II',
                13713 => 'Sigma 10-20mm f/3.5 EX DC HSM',
                13714 => 'Tamron SP 24-70mm f/2.8 Di VC USD',
                13715 => 'Sigma 18-35mm f/1.8 DC HSM',
                13716 => 'Sigma 12-24mm f/4.5-5.6 DG HSM II',
                13800 => 'Canon EF 28-80mm f/2.8-4L',
                13900 => 'Canon EF 400mm f/2.8L',
                14000 => 'Canon EF 500mm f/4.5L',
                14100 => 'Canon EF 500mm f/4.5L',
                14200 => 'Canon EF 300mm f/2.8L IS',
                14300 => 'Canon EF 500mm f/4L IS or Sigma Lens',
                14310 => 'Sigma 17-70mm f/2.8-4 DC Macro OS HSM',
                14400 => 'Canon EF 35-135mm f/4-5.6 USM',
                14500 => 'Canon EF 100-300mm f/4.5-5.6 USM',
                14600 => 'Canon EF 70-210mm f/3.5-4.5 USM',
                14700 => 'Canon EF 35-135mm f/4-5.6 USM',
                14800 => 'Canon EF 28-80mm f/3.5-5.6 USM',
                14900 => 'Canon EF 100mm f/2 USM',
                15000 => 'Canon EF 14mm f/2.8L or Sigma Lens',
                15010 => 'Sigma 20mm EX f/1.8',
                15020 => 'Sigma 30mm f/1.4 DC HSM',
                15030 => 'Sigma 24mm f/1.8 DG Macro EX',
                15040 => 'Sigma 28mm f/1.8 DG Macro EX',
                15100 => 'Canon EF 200mm f/2.8L',
                15200 => 'Canon EF 300mm f/4L IS or Sigma Lens',
                15210 => 'Sigma 12-24mm f/4.5-5.6 EX DG ASPHERICAL HSM',
                15220 => 'Sigma 14mm f/2.8 EX Aspherical HSM',
                15230 => 'Sigma 10-20mm f/4-5.6',
                15240 => 'Sigma 100-300mm f/4',
                15300 => 'Canon EF 35-350mm f/3.5-5.6L or Sigma or Tamron Lens',
                15310 => 'Sigma 50-500mm f/4-6.3 APO HSM EX',
                15320 => 'Tamron AF 28-300mm f/3.5-6.3 XR LD Aspherical [IF] Macro',
                15330 => 'Tamron AF 18-200mm f/3.5-6.3 XR Di II LD Aspherical [IF] Macro Model A14',
                15340 => 'Tamron 18-250mm f/3.5-6.3 Di II LD Aspherical [IF] Macro',
                15400 => 'Canon EF 20mm f/2.8 USM or Zeiss Lens',
                15410 => 'Zeiss Milvus 21mm f/2.8',
                15500 => 'Canon EF 85mm f/1.8 USM',
                15600 => 'Canon EF 28-105mm f/3.5-4.5 USM or Tamron Lens',
                15610 => 'Tamron SP 70-300mm f/4.0-5.6 Di VC USD',
                15620 => 'Tamron SP AF 28-105mm f/2.8 LD Aspherical IF',
                16000 => 'Canon EF 20-35mm f/3.5-4.5 USM or Tamron or Tokina Lens',
                16010 => 'Tamron AF 19-35mm f/3.5-4.5',
                16020 => 'Tokina AT-X 124 AF Pro DX 12-24mm f/4',
                16030 => 'Tokina AT-X 107 AF DX 10-17mm f/3.5-4.5 Fisheye',
                16040 => 'Tokina AT-X 116 AF Pro DX 11-16mm f/2.8',
                16050 => 'Tokina AT-X 11-20 F2.8 PRO DX Aspherical 11-20mm f/2.8',
                16100 => 'Canon EF 28-70mm f/2.8L or Sigma or Tamron Lens',
                16110 => 'Sigma 24-70mm f/2.8 EX',
                16120 => 'Sigma 28-70mm f/2.8 EX',
                16130 => 'Sigma 24-60mm f/2.8 EX DG',
                16140 => 'Tamron AF 17-50mm f/2.8 Di-II LD Aspherical',
                16150 => 'Tamron 90mm f/2.8',
                16160 => 'Tamron SP AF 17-35mm f/2.8-4 Di LD Aspherical IF',
                16170 => 'Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro',
                16200 => 'Canon EF 200mm f/2.8L',
                16300 => 'Canon EF 300mm f/4L',
                16400 => 'Canon EF 400mm f/5.6L',
                16500 => 'Canon EF 70-200mm f/2.8 L',
                16600 => 'Canon EF 70-200mm f/2.8 L + 1.4x',
                16700 => 'Canon EF 70-200mm f/2.8 L + 2x',
                16800 => 'Canon EF 28mm f/1.8 USM or Sigma Lens',
                16810 => 'Sigma 50-100mm f/1.8 DC HSM | A',
                16900 => 'Canon EF 17-35mm f/2.8L or Sigma Lens',
                16910 => 'Sigma 18-200mm f/3.5-6.3 DC OS',
                16920 => 'Sigma 15-30mm f/3.5-4.5 EX DG Aspherical',
                16930 => 'Sigma 18-50mm f/2.8 Macro',
                16940 => 'Sigma 50mm f/1.4 EX DG HSM',
                16950 => 'Sigma 85mm f/1.4 EX DG HSM',
                16960 => 'Sigma 30mm f/1.4 EX DC HSM',
                16970 => 'Sigma 35mm f/1.4 DG HSM',
                17000 => 'Canon EF 200mm f/2.8L II',
                17100 => 'Canon EF 300mm f/4L',
                17200 => 'Canon EF 400mm f/5.6L or Sigma Lens',
                17210 => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S',
                17300 => 'Canon EF 180mm Macro f/3.5L or Sigma Lens',
                17310 => 'Sigma 180mm EX HSM Macro f/3.5',
                17320 => 'Sigma APO Macro 150mm f/2.8 EX DG HSM',
                17400 => 'Canon EF 135mm f/2L or Other Lens',
                17410 => 'Sigma 70-200mm f/2.8 EX DG APO OS HSM',
                17420 => 'Sigma 50-500mm f/4.5-6.3 APO DG OS HSM',
                17430 => 'Sigma 150-500mm f/5-6.3 APO DG OS HSM',
                17440 => 'Zeiss Milvus 100mm f/2 Makro',
                17500 => 'Canon EF 400mm f/2.8L',
                17600 => 'Canon EF 24-85mm f/3.5-4.5 USM',
                17700 => 'Canon EF 300mm f/4L IS',
                17800 => 'Canon EF 28-135mm f/3.5-5.6 IS',
                17900 => 'Canon EF 24mm f/1.4L',
                18000 => 'Canon EF 35mm f/1.4L or Other Lens',
                18010 => 'Sigma 50mm f/1.4 DG HSM | A',
                18020 => 'Sigma 24mm f/1.4 DG HSM | A',
                18030 => 'Zeiss Milvus 50mm f/1.4',
                18040 => 'Zeiss Milvus 85mm f/1.4',
                18050 => 'Zeiss Otus 28mm f/1.4 ZE',
                18100 => 'Canon EF 100-400mm f/4.5-5.6L IS + 1.4x or Sigma Lens',
                18110 => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S + 1.4x',
                18200 => 'Canon EF 100-400mm f/4.5-5.6L IS + 2x or Sigma Lens',
                18210 => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S + 2x',
                18300 => 'Canon EF 100-400mm f/4.5-5.6L IS or Sigma Lens',
                18310 => 'Sigma 150mm f/2.8 EX DG OS HSM APO Macro',
                18320 => 'Sigma 105mm f/2.8 EX DG OS HSM Macro',
                18330 => 'Sigma 180mm f/2.8 EX DG OS HSM APO Macro',
                18340 => 'Sigma 150-600mm f/5-6.3 DG OS HSM | C',
                18350 => 'Sigma 150-600mm f/5-6.3 DG OS HSM | S',
                18360 => 'Sigma 100-400mm f/5-6.3 DG OS HSM',
                18400 => 'Canon EF 400mm f/2.8L + 2x',
                18500 => 'Canon EF 600mm f/4L IS',
                18600 => 'Canon EF 70-200mm f/4L',
                18700 => 'Canon EF 70-200mm f/4L + 1.4x',
                18800 => 'Canon EF 70-200mm f/4L + 2x',
                18900 => 'Canon EF 70-200mm f/4L + 2.8x',
                19000 => 'Canon EF 100mm f/2.8 Macro USM',
                19100 => 'Canon EF 400mm f/4 DO IS',
                19300 => 'Canon EF 35-80mm f/4-5.6 USM',
                19400 => 'Canon EF 80-200mm f/4.5-5.6 USM',
                19500 => 'Canon EF 35-105mm f/4.5-5.6 USM',
                19600 => 'Canon EF 75-300mm f/4-5.6 USM',
                19700 => 'Canon EF 75-300mm f/4-5.6 IS USM or Sigma Lens',
                19710 => 'Sigma 18-300mm f/3.5-6.3 DC Macro OS HS',
                19800 => 'Canon EF 50mm f/1.4 USM or Zeiss Lens',
                19810 => 'Zeiss Otus 55mm f/1.4 ZE',
                19820 => 'Zeiss Otus 85mm f/1.4 ZE',
                19900 => 'Canon EF 28-80mm f/3.5-5.6 USM',
                20000 => 'Canon EF 75-300mm f/4-5.6 USM',
                20100 => 'Canon EF 28-80mm f/3.5-5.6 USM',
                20200 => 'Canon EF 28-80mm f/3.5-5.6 USM IV',
                20800 => 'Canon EF 22-55mm f/4-5.6 USM',
                20900 => 'Canon EF 55-200mm f/4.5-5.6',
                21000 => 'Canon EF 28-90mm f/4-5.6 USM',
                21100 => 'Canon EF 28-200mm f/3.5-5.6 USM',
                21200 => 'Canon EF 28-105mm f/4-5.6 USM',
                21300 => 'Canon EF 90-300mm f/4.5-5.6 USM or Tamron Lens',
                21310 => 'Tamron SP 150-600mm f/5-6.3 Di VC USD',
                21320 => 'Tamron 16-300mm f/3.5-6.3 Di II VC PZD Macro',
                21330 => 'Tamron SP 35mm f/1.8 Di VC USD',
                21340 => 'Tamron SP 45mm f/1.8 Di VC USD',
                21400 => 'Canon EF-S 18-55mm f/3.5-5.6 USM',
                21500 => 'Canon EF 55-200mm f/4.5-5.6 II USM',
                21700 => 'Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD',
                22400 => 'Canon EF 70-200mm f/2.8L IS',
                22500 => 'Canon EF 70-200mm f/2.8L IS + 1.4x',
                22600 => 'Canon EF 70-200mm f/2.8L IS + 2x',
                22700 => 'Canon EF 70-200mm f/2.8L IS + 2.8x',
                22800 => 'Canon EF 28-105mm f/3.5-4.5 USM',
                22900 => 'Canon EF 16-35mm f/2.8L',
                23000 => 'Canon EF 24-70mm f/2.8L',
                23100 => 'Canon EF 17-40mm f/4L',
                23200 => 'Canon EF 70-300mm f/4.5-5.6 DO IS USM',
                23300 => 'Canon EF 28-300mm f/3.5-5.6L IS',
                23400 => 'Canon EF-S 17-85mm f/4-5.6 IS USM or Tokina Lens',
                23410 => 'Tokina AT-X 12-28 PRO DX 12-28mm f/4',
                23500 => 'Canon EF-S 10-22mm f/3.5-4.5 USM',
                23600 => 'Canon EF-S 60mm f/2.8 Macro USM',
                23700 => 'Canon EF 24-105mm f/4L IS',
                23800 => 'Canon EF 70-300mm f/4-5.6 IS USM',
                23900 => 'Canon EF 85mm f/1.2L II',
                24000 => 'Canon EF-S 17-55mm f/2.8 IS USM',
                24100 => 'Canon EF 50mm f/1.2L',
                24200 => 'Canon EF 70-200mm f/4L IS',
                24300 => 'Canon EF 70-200mm f/4L IS + 1.4x',
                24400 => 'Canon EF 70-200mm f/4L IS + 2x',
                24500 => 'Canon EF 70-200mm f/4L IS + 2.8x',
                24600 => 'Canon EF 16-35mm f/2.8L II',
                24700 => 'Canon EF 14mm f/2.8L II USM',
                24800 => 'Canon EF 200mm f/2L IS or Sigma Lens',
                24810 => 'Sigma 24-35mm f/2 DG HSM | A',
                24900 => 'Canon EF 800mm f/5.6L IS',
                25000 => 'Canon EF 24mm f/1.4L II or Sigma Lens',
                25010 => 'Sigma 20mm f/1.4 DG HSM | A',
                25100 => 'Canon EF 70-200mm f/2.8L IS II USM',
                25200 => 'Canon EF 70-200mm f/2.8L IS II USM + 1.4x',
                25300 => 'Canon EF 70-200mm f/2.8L IS II USM + 2x',
                25400 => 'Canon EF 100mm f/2.8L Macro IS USM',
                25500 => 'Sigma 24-105mm f/4 DG OS HSM | A or Other Sigma Lens',
                25510 => 'Sigma 180mm f/2.8 EX DG OS HSM APO Macro',
                48800 => 'Canon EF-S 15-85mm f/3.5-5.6 IS USM',
                48900 => 'Canon EF 70-300mm f/4-5.6L IS USM',
                49000 => 'Canon EF 8-15mm f/4L Fisheye USM',
                49100 => 'Canon EF 300mm f/2.8L IS II USM or Tamron Lens',
                49110 => 'Tamron SP 70-200mm F/2.8 Di VC USD G2 (A025)',
                49120 => 'Tamron 18-400mm F/3.5-6.3 Di II VC HLD (B028)',
                49200 => 'Canon EF 400mm f/2.8L IS II USM',
                49300 => 'Canon EF 500mm f/4L IS II USM or EF 24-105mm f4L IS USM',
                49310 => 'Canon EF 24-105mm f/4L IS USM',
                49400 => 'Canon EF 600mm f/4.0L IS II USM',
                49500 => 'Canon EF 24-70mm f/2.8L II USM or Sigma Lens',
                49510 => 'Sigma 24-70mm F2.8 DG OS HSM | A',
                49600 => 'Canon EF 200-400mm f/4L IS USM',
                49900 => 'Canon EF 200-400mm f/4L IS USM + 1.4x',
                50200 => 'Canon EF 28mm f/2.8 IS USM',
                50300 => 'Canon EF 24mm f/2.8 IS USM',
                50400 => 'Canon EF 24-70mm f/4L IS USM',
                50500 => 'Canon EF 35mm f/2 IS USM',
                50600 => 'Canon EF 400mm f/4 DO IS II USM',
                50700 => 'Canon EF 16-35mm f/4L IS USM',
                50800 => 'Canon EF 11-24mm f/4L USM or Tamron Lens',
                50810 => 'Tamron 10-24mm f/3.5-4.5 Di II VC HLD',
                74700 => 'Canon EF 100-400mm f/4.5-5.6L IS II USM or Tamron Lens',
                74710 => 'Tamron SP 150-600mm F5-6.3 Di VC USD G2',
                74800 => 'Canon EF 100-400mm f/4.5-5.6L IS II USM + 1.4x',
                75000 => 'Canon EF 35mm f/1.4L II USM',
                75100 => 'Canon EF 16-35mm f/2.8L III USM',
                75200 => 'Canon EF 24-105mm f/4L IS II USM',
                414200 => 'Canon EF-S 18-135mm f/3.5-5.6 IS STM',
                414300 => 'Canon EF-M 18-55mm f/3.5-5.6 IS STM or Tamron Lens',
                414310 => 'Tamron 18-200mm F/3.5-6.3 Di III VC',
                414400 => 'Canon EF 40mm f/2.8 STM',
                414500 => 'Canon EF-M 22mm f/2 STM',
                414600 => 'Canon EF-S 18-55mm f/3.5-5.6 IS STM',
                414700 => 'Canon EF-M 11-22mm f/4-5.6 IS STM',
                414800 => 'Canon EF-S 55-250mm f/4-5.6 IS STM',
                414900 => 'Canon EF-M 55-200mm f/4.5-6.3 IS STM',
                415000 => 'Canon EF-S 10-18mm f/4.5-5.6 IS STM',
                415200 => 'Canon EF 24-105mm f/3.5-5.6 IS STM',
                415300 => 'Canon EF-M 15-45mm f/3.5-6.3 IS STM',
                415400 => 'Canon EF-S 24mm f/2.8 STM',
                415500 => 'Canon EF-M 28mm f/3.5 Macro IS STM',
                415600 => 'Canon EF 50mm f/1.8 STM',
                415700 => 'Canon EF-M 18-150mm 1:3.5-6.3 IS STM',
                415800 => 'Canon EF-S 18-55mm f/4-5.6 IS STM',
                416000 => 'Canon EF-S 35mm f/2.8 Macro IS STM',
                3691000 => 'Canon EF 70-300mm f/4-5.6 IS II USM',
                3691200 => 'Canon EF-S 18-135mm f/3.5-5.6 IS USM',
                6149400 => 'Canon CN-E 85mm T1.3 L F'
            ],
            PelTag::CANON_CS_FOCUS_CONTINUOUS => [
                0 => 'Single',
                1 => 'Continuous',
                8 => 'Manual'
            ],
            PelTag::CANON_CS_AE_SETTING => [
                0 => 'Normal AE',
                1 => 'Exposure Compensation',
                2 => 'AE Lock',
                3 => 'AE Lock + Exposure Comp.',
                4 => 'No AE'
            ],
            PelTag::CANON_CS_IMAGE_STABILIZATION => [
                0 => 'Off',
                1 => 'On',
                2 => 'Shoot Only',
                3 => 'Panning',
                4 => 'Dynamic',
                256 => 'Off (2)',
                257 => 'On (2)',
                258 => 'Shoot Only (2)',
                259 => 'Panning (2)',
                260 => 'Dynamic (2)'
            ],
            PelTag::CANON_CS_SPOT_METERING_MODE => [
                0 => 'Center',
                1 => 'AF Point'
            ],
            PelTag::CANON_CS_PHOTO_EFFECT => [
                0 => 'Off',
                1 => 'Vivid',
                2 => 'Neutral',
                3 => 'Smooth',
                4 => 'Sepia',
                5 => 'B&W',
                6 => 'Custom',
                100 => 'My Color Data'
            ],
            PelTag::CANON_CS_MANUAL_FLASH_OUTPUT => [
                0x500 => 'Full',
                0x502 => 'Medium',
                0x504 => 'Low'
            ],
            PelTag::CANON_CS_COLOR_TONE => [
                0 => 'Normal'
            ],
            PelTag::CANON_CS_SRAW_QUALITY => [
                1 => 'sRAW1 (mRAW)',
                2 => 'sRAW2 (sRAW)'
            ]
        ]
    ];

    /**
     * Make a new entry that can hold a signed short.
     *
     * The method accept several integer arguments. The {@link
     * getValue} method will always return an array except for when a
     * single integer argument is given here.
     *
     * @param int $tag
     *            the tag which this entry represents. This
     *            should be one of the constants defined in {@link PelTag}
     *            which has format {@link PelFormat::SSHORT}.
     * @param int $value...
     *            the signed short(s) that this entry will
     *            represent. The argument passed must obey the same rules as the
     *            argument to {@link setValue}, namely that it should be within
     *            range of a signed short, that is between -32768 to 32767
     *            (inclusive). If not, then a {@link PelOverFlowException} will be
     *            thrown.
     */
    public function __construct($tag, $value = null)
    {
        $this->tag = $tag;
        $this->min = - 32768;
        $this->max = 32767;
        $this->format = PelFormat::SSHORT;

        $value = func_get_args();
        array_shift($value);
        $this->setValueArray($value);
    }

    /**
     * Convert a number into bytes.
     *
     * @param int $number
     *            the number that should be converted.
     * @param boolean $order
     *            one of {@link PelConvert::LITTLE_ENDIAN} and
     *            {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
     * @return string bytes representing the number given.
     */
    public function numberToBytes($number, $order)
    {
        return PelConvert::sShortToBytes($number, $order);
    }

    /**
     * Get the value of an entry as text.
     *
     * The value will be returned in a format suitable for presentation,
     * e.g., instead of returning '2' for a {@link
     * PelTag::METERING_MODE} tag, 'Center-Weighted Average' is
     * returned.
     *
     * @param boolean $brief
     *            some values can be returned in a long or more
     *            brief form, and this parameter controls that.
     * @return string the value as text.
     */
    public function getText($brief = false)
    {
        if (array_key_exists($this->ifd_type, self::TRANSLATIONS) && array_key_exists($this->tag, self::TRANSLATIONS[$this->ifd_type])) {
            $val = $this->value[0];
            if ($this->ifd_type === PelIfd::CANON_CAMERA_SETTINGS && $this->tag === PelTag::CANON_CS_LENS_TYPE) {
                // special handling: lens types must be multtiplied by 100 because digits canÄt be used in arrays
                $val = $val * 100;
            }
            if (array_key_exists($val, self::TRANSLATIONS[$this->ifd_type][$this->tag])) {
                return Pel::tra(self::TRANSLATIONS[$this->ifd_type][$this->tag][$val]);
            } else {
                return $val;
            }
        }
        return parent::getText($brief);
    }
}
