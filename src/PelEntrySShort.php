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
namespace lsolesen\pel;

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
class PelEntrySShort extends PelEntryNumber
{

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
     *
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
     *
     * @param boolean $order
     *            one of {@link PelConvert::LITTLE_ENDIAN} and
     *            {@link PelConvert::BIG_ENDIAN}, specifying the target byte order.
     *
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
     * @param
     *            boolean some values can be returned in a long or more
     *            brief form, and this parameter controls that.
     *
     * @return string the value as text.
     */
    public function getText($brief = false)
    {
        if ($this->ifd_type == PelIfd::CANON_FILE_INFO) {
            switch ($this->tag) {
                case PelTag::CANON_FI_BRACKET_MODE:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Off');
                        case 1:
                            return Pel::tra('AEB');
                        case 2:
                            return Pel::tra('FEB');
                        case 3:
                            return Pel::tra('ISO');
                        case 4:
                            return Pel::tra('WB');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_RAW_JPG_QUALITY:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 1:
                            return Pel::tra('Economy');
                        case 2:
                            return Pel::tra('Normal');
                        case 3:
                            return Pel::tra('Fine');
                        case 4:
                            return Pel::tra('RAW');
                        case 5:
                            return Pel::tra('Superfine');
                        case 130:
                            return Pel::tra('Normal Movie');
                        case 131:
                            return Pel::tra('Movie (2)');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_RAW_JPG_SIZE:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Large');
                        case 1:
                            return Pel::tra('Medium');
                        case 2:
                            return Pel::tra('Small');
                        case 5:
                            return Pel::tra('Medium 1');
                        case 6:
                            return Pel::tra('Medium 2');
                        case 7:
                            return Pel::tra('Medium 3');
                        case 8:
                            return Pel::tra('Postcard');
                        case 9:
                            return Pel::tra('Widescreen');
                        case 10:
                            return Pel::tra('Medium Widescreen');
                        case 14:
                            return Pel::tra('Small 1');
                        case 15:
                            return Pel::tra('Small 2');
                        case 16:
                            return Pel::tra('Small 3');
                        case 128:
                            return Pel::tra('640x480 Movie');
                        case 129:
                            return Pel::tra('Medium Movie');
                        case 130:
                            return Pel::tra('Small Movie');
                        case 137:
                            return Pel::tra('1280x720 Movie');
                        case 142:
                            return Pel::tra('1920x1080 Movie');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_NOISE_REDUCTION:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Off');
                        case 1:
                            return Pel::tra('On (1D)');
                        case 3:
                            return Pel::tra('On');
                        case 4:
                            return Pel::tra('Auto');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_WB_BRACKET_MODE:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Off');
                        case 1:
                            return Pel::tra('On (shift AB)');
                        case 2:
                            return Pel::tra('On (shift GM)');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_FILTER_EFFECT:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('None');
                        case 1:
                            return Pel::tra('Yellow');
                        case 2:
                            return Pel::tra('Orange');
                        case 3:
                            return Pel::tra('Red');
                        case 4:
                            return Pel::tra('Green');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_TONING_EFFECT:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('None');
                        case 1:
                            return Pel::tra('Sepia');
                        case 2:
                            return Pel::tra('Blue');
                        case 3:
                            return Pel::tra('Purple');
                        case 4:
                            return Pel::tra('Green');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_LIVE_VIEW_SHOOTING:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Off');
                        case 1:
                            return Pel::tra('On');
                        default:
                            return $this->value[0];
                    }
                    break;
                case PelTag::CANON_FI_FLASH_EXPOSURE_LOCK:
                    // CC (e->components, 1, v);
                    switch ($this->value[0]) {
                        case 0:
                            return Pel::tra('Off');
                        case 1:
                            return Pel::tra('On');
                        default:
                            return $this->value[0];
                    }
                    break;
                default:
                    return $this->value[0];
            }
        }
        switch ($this->tag) {
            case PelTag::CANON_CS_MACRO:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 1:
                        return Pel::tra('Macro');
                    case 2:
                        return Pel::tra('Normal');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_QUALITY:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 1:
                        return Pel::tra('Economy');
                    case 2:
                        return Pel::tra('Normal');
                    case 3:
                        return Pel::tra('Fine');
                    case 4:
                        return Pel::tra('RAW');
                    case 5:
                        return Pel::tra('Superfine');
                    case 130:
                        return Pel::tra('Normal Movie');
                    case 131:
                        return Pel::tra('Movie (2)');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_FLASH_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Off');
                    case 1:
                        return Pel::tra('Auto');
                    case 2:
                        return Pel::tra('On');
                    case 3:
                        return Pel::tra('Red-eye reduction');
                    case 4:
                        return Pel::tra('Slow-sync');
                    case 5:
                        return Pel::tra('Red-eye reduction (Auto)');
                    case 6:
                        return Pel::tra('Red-eye reduction (On)');
                    case 16:
                        return Pel::tra('External flash');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_DRIVE_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Single');
                    case 1:
                        return Pel::tra('Continuous');
                    case 2:
                        return Pel::tra('Movie');
                    case 3:
                        return Pel::tra('Continuous, Speed Priority');
                    case 4:
                        return Pel::tra('Continuous, Low');
                    case 5:
                        return Pel::tra('Continuous, High');
                    case 6:
                        return Pel::tra('Silent Single');
                    case 9:
                        return Pel::tra('Single, Silent');
                    case 10:
                        return Pel::tra('Continuous, Silent');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_FOCUS_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('One-shot AF');
                    case 1:
                        return Pel::tra('AI Servo AF');
                    case 2:
                        return Pel::tra('AI Focus AF');
                    case 3:
                        return Pel::tra('Manual Focus (3)');
                    case 4:
                        return Pel::tra('Single');
                    case 5:
                        return Pel::tra('Continuous');
                    case 6:
                        return Pel::tra('Manual Focus (6)');
                    case 16:
                        return Pel::tra('Pan Focus');
                    case 256:
                        return Pel::tra('AF + MF');
                    case 512:
                        return Pel::tra('Movie Snap Focus');
                    case 519:
                        return Pel::tra('Movie Servo AF');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_RECORD_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 1:
                        return Pel::tra('JPEG');
                    case 2:
                        return Pel::tra('CRW+THM');
                    case 3:
                        return Pel::tra('AVI+THM');
                    case 4:
                        return Pel::tra('TIF');
                    case 5:
                        return Pel::tra('TIF+JPEG');
                    case 6:
                        return Pel::tra('CR2');
                    case 7:
                        return Pel::tra('CR2+JPEG');
                    case 9:
                        return Pel::tra('MOV');
                    case 10:
                        return Pel::tra('MP4');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_IMAGE_SIZE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Large');
                    case 1:
                        return Pel::tra('Medium');
                    case 2:
                        return Pel::tra('Small');
                    case 5:
                        return Pel::tra('Medium 1');
                    case 6:
                        return Pel::tra('Medium 2');
                    case 7:
                        return Pel::tra('Medium 3');
                    case 8:
                        return Pel::tra('Postcard');
                    case 9:
                        return Pel::tra('Widescreen');
                    case 10:
                        return Pel::tra('Medium Widescreen');
                    case 14:
                        return Pel::tra('Small 1');
                    case 15:
                        return Pel::tra('Small 2');
                    case 16:
                        return Pel::tra('Small 3');
                    case 128:
                        return Pel::tra('640x480 Movie');
                    case 129:
                        return Pel::tra('Medium Movie');
                    case 130:
                        return Pel::tra('Small Movie');
                    case 137:
                        return Pel::tra('1280x720 Movie');
                    case 142:
                        return Pel::tra('1920x1080 Movie');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_EASY_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Full auto');
                    case 1:
                        return Pel::tra('Manual');
                    case 2:
                        return Pel::tra('Landscape');
                    case 3:
                        return Pel::tra('Fast shutter');
                    case 4:
                        return Pel::tra('Slow shutter');
                    case 5:
                        return Pel::tra('Night');
                    case 6:
                        return Pel::tra('Gray Scale');
                    case 7:
                        return Pel::tra('Sepia');
                    case 8:
                        return Pel::tra('Portrait');
                    case 9:
                        return Pel::tra('Sports');
                    case 10:
                        return Pel::tra('Macro');
                    case 11:
                        return Pel::tra('Black & White');
                    case 12:
                        return Pel::tra('Pan focus');
                    case 13:
                        return Pel::tra('Vivid');
                    case 14:
                        return Pel::tra('Neutral');
                    case 15:
                        return Pel::tra('Flash Off');
                    case 16:
                        return Pel::tra('Long Shutter');
                    case 17:
                        return Pel::tra('Super Macro');
                    case 18:
                        return Pel::tra('Foliage');
                    case 19:
                        return Pel::tra('Indoor');
                    case 20:
                        return Pel::tra('Fireworks');
                    case 21:
                        return Pel::tra('Beach');
                    case 22:
                        return Pel::tra('Underwater');
                    case 23:
                        return Pel::tra('Snow');
                    case 24:
                        return Pel::tra('Kids & Pets');
                    case 25:
                        return Pel::tra('Night Snapshot');
                    case 26:
                        return Pel::tra('Digital Macro');
                    case 27:
                        return Pel::tra('My Colors');
                    case 28:
                        return Pel::tra('Movie Snap');
                    case 29:
                        return Pel::tra('Super Macro 2');
                    case 30:
                        return Pel::tra('Color Accent');
                    case 31:
                        return Pel::tra('Color Swap');
                    case 32:
                        return Pel::tra('Aquarium');
                    case 33:
                        return Pel::tra('ISO 3200');
                    case 34:
                        return Pel::tra('ISO 6400');
                    case 35:
                        return Pel::tra('Creative Light Effect');
                    case 36:
                        return Pel::tra('Easy');
                    case 37:
                        return Pel::tra('Quick Shot');
                    case 38:
                        return Pel::tra('Creative Auto');
                    case 39:
                        return Pel::tra('Zoom Blur');
                    case 40:
                        return Pel::tra('Low Light');
                    case 41:
                        return Pel::tra('Nostalgic');
                    case 42:
                        return Pel::tra('Super Vivid');
                    case 43:
                        return Pel::tra('Poster Effect');
                    case 44:
                        return Pel::tra('Face Self-timer');
                    case 45:
                        return Pel::tra('Smile');
                    case 46:
                        return Pel::tra('Wink Self-timer');
                    case 47:
                        return Pel::tra('Fisheye Effect');
                    case 48:
                        return Pel::tra('Miniature Effect');
                    case 49:
                        return Pel::tra('High-speed Burst');
                    case 50:
                        return Pel::tra('Best Image Selection');
                    case 51:
                        return Pel::tra('High Dynamic Range');
                    case 52:
                        return Pel::tra('Handheld Night Scene');
                    case 53:
                        return Pel::tra('Movie Digest');
                    case 54:
                        return Pel::tra('Live View Control');
                    case 55:
                        return Pel::tra('Discreet');
                    case 56:
                        return Pel::tra('Blur Reduction');
                    case 57:
                        return Pel::tra('Monochrome');
                    case 58:
                        return Pel::tra('Toy Camera Effect');
                    case 59:
                        return Pel::tra('Scene Intelligent Auto');
                    case 60:
                        return Pel::tra('High-speed Burst HQ');
                    case 61:
                        return Pel::tra('Smooth Skin');
                    case 62:
                        return Pel::tra('Soft Focus');
                    case 257:
                        return Pel::tra('Spotlight');
                    case 258:
                        return Pel::tra('Night 2');
                    case 259:
                        return Pel::tra('Night+');
                    case 260:
                        return Pel::tra('Super Night');
                    case 261:
                        return Pel::tra('Sunset');
                    case 263:
                        return Pel::tra('Night Scene');
                    case 264:
                        return Pel::tra('Surface');
                    case 265:
                        return Pel::tra('Low Light 2');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_DIGITAL_ZOOM:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('None');
                    case 1:
                        return Pel::tra('2x');
                    case 2:
                        return Pel::tra('4x');
                    case 3:
                        return Pel::tra('Other');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_CONTRAST:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Normal');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_SATURATION:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Normal');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_METERING_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Default');
                    case 1:
                        return Pel::tra('Spot');
                    case 2:
                        return Pel::tra('Average');
                    case 3:
                        return Pel::tra('Evaluative');
                    case 4:
                        return Pel::tra('Partial');
                    case 5:
                        return Pel::tra('Center-weighted average');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_FOCUS_TYPE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Manual');
                    case 1:
                        return Pel::tra('Auto');
                    case 2:
                        return Pel::tra('Not Known');
                    case 3:
                        return Pel::tra('Macro');
                    case 4:
                        return Pel::tra('Very Close');
                    case 5:
                        return Pel::tra('Close');
                    case 6:
                        return Pel::tra('Middle Range');
                    case 7:
                        return Pel::tra('Far Range');
                    case 8:
                        return Pel::tra('Pan Focus');
                    case 9:
                        return Pel::tra('Super Macro');
                    case 10:
                        return Pel::tra('Infinity');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_AF_POINT:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0x2005:
                        return Pel::tra('Manual AF point selection');
                    case 0x3000:
                        return Pel::tra('None (MF)');
                    case 0x3001:
                        return Pel::tra('Auto AF point selection');
                    case 0x3002:
                        return Pel::tra('Right');
                    case 0x3003:
                        return Pel::tra('Center');
                    case 0x3004:
                        return Pel::tra('Left');
                    case 0x4001:
                        return Pel::tra('Auto AF point selection');
                    case 0x4006:
                        return Pel::tra('Face Detect');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_EXPOSURE_PROGRAM:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Easy');
                    case 1:
                        return Pel::tra('Program AE');
                    case 2:
                        return Pel::tra('Shutter speed priority AE');
                    case 3:
                        return Pel::tra('Aperture-priority AE');
                    case 4:
                        return Pel::tra('Manual');
                    case 5:
                        return Pel::tra('Depth-of-field AE');
                    case 6:
                        return Pel::tra('M-Dep');
                    case 7:
                        return Pel::tra('Bulb');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_LENS_TYPE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 1:
                        return Pel::tra('Canon EF 50mm f/1.8');
                    case 2:
                        return Pel::tra('Canon EF 28mm f/2.8');
                    case 3:
                        return Pel::tra('Canon EF 135mm f/2.8 Soft');
                    case 4:
                        return Pel::tra('Canon EF 35-105mm f/3.5-4.5 or Sigma Lens');
                    case 4.1:
                        return Pel::tra('Sigma UC Zoom 35-135mm f/4-5.6');
                    case 5:
                        return Pel::tra('Canon EF 35-70mm f/3.5-4.5');
                    case 6:
                        return Pel::tra('Canon EF 28-70mm f/3.5-4.5 or Sigma or Tokina Lens');
                    case 6.1:
                        return Pel::tra('Sigma 18-50mm f/3.5-5.6 DC');
                    case 6.2:
                        return Pel::tra('Sigma 18-125mm f/3.5-5.6 DC IF ASP');
                    case 6.3:
                        return Pel::tra('Tokina AF 193-2 19-35mm f/3.5-4.5');
                    case 6.4:
                        return Pel::tra('Sigma 28-80mm f/3.5-5.6 II Macro');
                    case 7:
                        return Pel::tra('Canon EF 100-300mm f/5.6L');
                    case 8:
                        return Pel::tra('Canon EF 100-300mm f/5.6 or Sigma or Tokina Lens');
                    case 8.1:
                        return Pel::tra('Sigma 70-300mm f/4-5.6 [APO] DG Macro');
                    case 8.2:
                        return Pel::tra('Tokina AT-X 242 AF 24-200mm f/3.5-5.6');
                    case 9:
                        return Pel::tra('Canon EF 70-210mm f/4');
                    case 9.1:
                        return Pel::tra('Sigma 55-200mm f/4-5.6 DC');
                    case 10:
                        return Pel::tra('Canon EF 50mm f/2.5 Macro or Sigma Lens');
                    case 10.1:
                        return Pel::tra('Sigma 50mm f/2.8 EX');
                    case 10.2:
                        return Pel::tra('Sigma 28mm f/1.8');
                    case 10.3:
                        return Pel::tra('Sigma 105mm f/2.8 Macro EX');
                    case 10.4:
                        return Pel::tra('Sigma 70mm f/2.8 EX DG Macro EF');
                    case 11:
                        return Pel::tra('Canon EF 35mm f/2');
                    case 13:
                        return Pel::tra('Canon EF 15mm f/2.8 Fisheye');
                    case 14:
                        return Pel::tra('Canon EF 50-200mm f/3.5-4.5L');
                    case 15:
                        return Pel::tra('Canon EF 50-200mm f/3.5-4.5');
                    case 16:
                        return Pel::tra('Canon EF 35-135mm f/3.5-4.5');
                    case 17:
                        return Pel::tra('Canon EF 35-70mm f/3.5-4.5A');
                    case 18:
                        return Pel::tra('Canon EF 28-70mm f/3.5-4.5');
                    case 20:
                        return Pel::tra('Canon EF 100-200mm f/4.5A');
                    case 21:
                        return Pel::tra('Canon EF 80-200mm f/2.8L');
                    case 22:
                        return Pel::tra('Canon EF 20-35mm f/2.8L or Tokina Lens');
                    case 22.1:
                        return Pel::tra('Tokina AT-X 280 AF Pro 28-80mm f/2.8 Aspherical');
                    case 23:
                        return Pel::tra('Canon EF 35-105mm f/3.5-4.5');
                    case 24:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6 Power Zoom');
                    case 25:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6 Power Zoom');
                    case 26:
                        return Pel::tra('Canon EF 100mm f/2.8 Macro or Other Lens');
                    case 26.1:
                        return Pel::tra('Cosina 100mm f/3.5 Macro AF');
                    case 26.2:
                        return Pel::tra('Tamron SP AF 90mm f/2.8 Di Macro');
                    case 26.3:
                        return Pel::tra('Tamron SP AF 180mm f/3.5 Di Macro');
                    case 26.4:
                        return Pel::tra('Carl Zeiss Planar T* 50mm f/1.4');
                    case 27:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6');
                    case 28:
                        return Pel::tra('Canon EF 80-200mm f/4.5-5.6 or Tamron Lens');
                    case 28.1:
                        return Pel::tra('Tamron SP AF 28-105mm f/2.8 LD Aspherical IF');
                    case 28.2:
                        return Pel::tra('Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro');
                    case 28.3:
                        return Pel::tra('Tamron AF 70-300mm f/4-5.6 Di LD 1:2 Macro');
                    case 28.4:
                        return Pel::tra('Tamron AF Aspherical 28-200mm f/3.8-5.6');
                    case 29:
                        return Pel::tra('Canon EF 50mm f/1.8 II');
                    case 30:
                        return Pel::tra('Canon EF 35-105mm f/4.5-5.6');
                    case 31:
                        return Pel::tra('Canon EF 75-300mm f/4-5.6 or Tamron Lens');
                    case 31.1:
                        return Pel::tra('Tamron SP AF 300mm f/2.8 LD IF');
                    case 32:
                        return Pel::tra('Canon EF 24mm f/2.8 or Sigma Lens');
                    case 32.1:
                        return Pel::tra('Sigma 15mm f/2.8 EX Fisheye');
                    case 33:
                        return Pel::tra('Voigtlander or Carl Zeiss Lens');
                    case 33.1:
                        return Pel::tra('Voigtlander Ultron 40mm f/2 SLII Aspherical');
                    case 33.2:
                        return Pel::tra('Voigtlander Color Skopar 20mm f/3.5 SLII Aspherical');
                    case 33.3:
                        return Pel::tra('Voigtlander APO-Lanthar 90mm f/3.5 SLII Close Focus');
                    case 33.4:
                        return Pel::tra('Carl Zeiss Distagon T* 15mm f/2.8 ZE');
                    case 33.5:
                        return Pel::tra('Carl Zeiss Distagon T* 18mm f/3.5 ZE');
                    case 33.6:
                        return Pel::tra('Carl Zeiss Distagon T* 21mm f/2.8 ZE');
                    case 33.7:
                        return Pel::tra('Carl Zeiss Distagon T* 25mm f/2 ZE');
                    case 33.8:
                        return Pel::tra('Carl Zeiss Distagon T* 28mm f/2 ZE');
                    case 33.9:
                        return Pel::tra('Carl Zeiss Distagon T* 35mm f/2 ZE');
                    case 33.10:
                        return Pel::tra('Carl Zeiss Distagon T* 35mm f/1.4 ZE');
                    case 33.11:
                        return Pel::tra('Carl Zeiss Planar T* 50mm f/1.4 ZE');
                    case 33.12:
                        return Pel::tra('Carl Zeiss Makro-Planar T* 50mm f/2 ZE');
                    case 33.13:
                        return Pel::tra('Carl Zeiss Makro-Planar T* 100mm f/2 ZE');
                    case 33.14:
                        return Pel::tra('Carl Zeiss Apo-Sonnar T* 135mm f/2 ZE');
                    case 35:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6');
                    case 36:
                        return Pel::tra('Canon EF 38-76mm f/4.5-5.6');
                    case 37:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6 or Tamron Lens');
                    case 37.1:
                        return Pel::tra('Tamron 70-200mm f/2.8 Di LD IF Macro');
                    case 37.2:
                        return Pel::tra('Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20');
                    case 37.3:
                        return Pel::tra('Tamron SP AF 17-50mm f/2.8 XR Di II VC LD Aspherical [IF]');
                    case 37.4:
                        return Pel::tra('Tamron AF 18-270mm f/3.5-6.3 Di II VC LD Aspherical [IF] Macro');
                    case 38:
                        return Pel::tra('Canon EF 80-200mm f/4.5-5.6');
                    case 39:
                        return Pel::tra('Canon EF 75-300mm f/4-5.6');
                    case 40:
                        return Pel::tra('Canon EF 28-80mm f/3.5-5.6');
                    case 41:
                        return Pel::tra('Canon EF 28-90mm f/4-5.6');
                    case 42:
                        return Pel::tra('Canon EF 28-200mm f/3.5-5.6 or Tamron Lens');
                    case 42.1:
                        return Pel::tra('Tamron AF 28-300mm f/3.5-6.3 XR Di VC LD Aspherical [IF] Macro Model A20');
                    case 43:
                        return Pel::tra('Canon EF 28-105mm f/4-5.6');
                    case 44:
                        return Pel::tra('Canon EF 90-300mm f/4.5-5.6');
                    case 45:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 [II]');
                    case 46:
                        return Pel::tra('Canon EF 28-90mm f/4-5.6');
                    case 47:
                        return Pel::tra('Zeiss Milvus 35mm f/2 or 50mm f/2');
                    case 47.1:
                        return Pel::tra('Zeiss Milvus 50mm f/2 Makro');
                    case 48:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 IS');
                    case 49:
                        return Pel::tra('Canon EF-S 55-250mm f/4-5.6 IS');
                    case 50:
                        return Pel::tra('Canon EF-S 18-200mm f/3.5-5.6 IS');
                    case 51:
                        return Pel::tra('Canon EF-S 18-135mm f/3.5-5.6 IS');
                    case 52:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 IS II');
                    case 53:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 III');
                    case 54:
                        return Pel::tra('Canon EF-S 55-250mm f/4-5.6 IS II');
                    case 60:
                        return Pel::tra('Irix 11mm f/4');
                    case 94:
                        return Pel::tra('Canon TS-E 17mm f/4L');
                    case 95:
                        return Pel::tra('Canon TS-E 24.0mm f/3.5 L II');
                    case 124:
                        return Pel::tra('Canon MP-E 65mm f/2.8 1-5x Macro Photo');
                    case 125:
                        return Pel::tra('Canon TS-E 24mm f/3.5L');
                    case 126:
                        return Pel::tra('Canon TS-E 45mm f/2.8');
                    case 127:
                        return Pel::tra('Canon TS-E 90mm f/2.8');
                    case 129:
                        return Pel::tra('Canon EF 300mm f/2.8L');
                    case 130:
                        return Pel::tra('Canon EF 50mm f/1.0L');
                    case 131:
                        return Pel::tra('Canon EF 28-80mm f/2.8-4L or Sigma Lens');
                    case 131.1:
                        return Pel::tra('Sigma 8mm f/3.5 EX DG Circular Fisheye');
                    case 131.2:
                        return Pel::tra('Sigma 17-35mm f/2.8-4 EX DG Aspherical HSM');
                    case 131.3:
                        return Pel::tra('Sigma 17-70mm f/2.8-4.5 DC Macro');
                    case 131.4:
                        return Pel::tra('Sigma APO 50-150mm f/2.8 [II] EX DC HSM');
                    case 131.5:
                        return Pel::tra('Sigma APO 120-300mm f/2.8 EX DG HSM');
                    case 131.6:
                        return Pel::tra('Sigma 4.5mm f/2.8 EX DC HSM Circular Fisheye');
                    case 131.7:
                        return Pel::tra('Sigma 70-200mm f/2.8 APO EX HSM');
                    case 132:
                        return Pel::tra('Canon EF 1200mm f/5.6L');
                    case 134:
                        return Pel::tra('Canon EF 600mm f/4L IS');
                    case 135:
                        return Pel::tra('Canon EF 200mm f/1.8L');
                    case 136:
                        return Pel::tra('Canon EF 300mm f/2.8L');
                    case 137:
                        return Pel::tra('Canon EF 85mm f/1.2L or Sigma or Tamron Lens');
                    case 137.1:
                        return Pel::tra('Sigma 18-50mm f/2.8-4.5 DC OS HSM');
                    case 137.2:
                        return Pel::tra('Sigma 50-200mm f/4-5.6 DC OS HSM');
                    case 137.3:
                        return Pel::tra('Sigma 18-250mm f/3.5-6.3 DC OS HSM');
                    case 137.4:
                        return Pel::tra('Sigma 24-70mm f/2.8 IF EX DG HSM');
                    case 137.5:
                        return Pel::tra('Sigma 18-125mm f/3.8-5.6 DC OS HSM');
                    case 137.6:
                        return Pel::tra('Sigma 17-70mm f/2.8-4 DC Macro OS HSM | C');
                    case 137.7:
                        return Pel::tra('Sigma 17-50mm f/2.8 OS HSM');
                    case 137.8:
                        return Pel::tra('Sigma 18-200mm f/3.5-6.3 DC OS HSM [II]');
                    case 137.9:
                        return Pel::tra('Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD');
                    case 137.10:
                        return Pel::tra('Sigma 8-16mm f/4.5-5.6 DC HSM');
                    case 137.11:
                        return Pel::tra('Tamron SP 17-50mm f/2.8 XR Di II VC');
                    case 137.12:
                        return Pel::tra('Tamron SP 60mm f/2 Macro Di II');
                    case 137.13:
                        return Pel::tra('Sigma 10-20mm f/3.5 EX DC HSM');
                    case 137.14:
                        return Pel::tra('Tamron SP 24-70mm f/2.8 Di VC USD');
                    case 137.15:
                        return Pel::tra('Sigma 18-35mm f/1.8 DC HSM');
                    case 137.16:
                        return Pel::tra('Sigma 12-24mm f/4.5-5.6 DG HSM II');
                    case 138:
                        return Pel::tra('Canon EF 28-80mm f/2.8-4L');
                    case 139:
                        return Pel::tra('Canon EF 400mm f/2.8L');
                    case 140:
                        return Pel::tra('Canon EF 500mm f/4.5L');
                    case 141:
                        return Pel::tra('Canon EF 500mm f/4.5L');
                    case 142:
                        return Pel::tra('Canon EF 300mm f/2.8L IS');
                    case 143:
                        return Pel::tra('Canon EF 500mm f/4L IS or Sigma Lens');
                    case 143.1:
                        return Pel::tra('Sigma 17-70mm f/2.8-4 DC Macro OS HSM');
                    case 144:
                        return Pel::tra('Canon EF 35-135mm f/4-5.6 USM');
                    case 145:
                        return Pel::tra('Canon EF 100-300mm f/4.5-5.6 USM');
                    case 146:
                        return Pel::tra('Canon EF 70-210mm f/3.5-4.5 USM');
                    case 147:
                        return Pel::tra('Canon EF 35-135mm f/4-5.6 USM');
                    case 148:
                        return Pel::tra('Canon EF 28-80mm f/3.5-5.6 USM');
                    case 149:
                        return Pel::tra('Canon EF 100mm f/2 USM');
                    case 150:
                        return Pel::tra('Canon EF 14mm f/2.8L or Sigma Lens');
                    case 150.1:
                        return Pel::tra('Sigma 20mm EX f/1.8');
                    case 150.2:
                        return Pel::tra('Sigma 30mm f/1.4 DC HSM');
                    case 150.3:
                        return Pel::tra('Sigma 24mm f/1.8 DG Macro EX');
                    case 150.4:
                        return Pel::tra('Sigma 28mm f/1.8 DG Macro EX');
                    case 151:
                        return Pel::tra('Canon EF 200mm f/2.8L');
                    case 152:
                        return Pel::tra('Canon EF 300mm f/4L IS or Sigma Lens');
                    case 152.1:
                        return Pel::tra('Sigma 12-24mm f/4.5-5.6 EX DG ASPHERICAL HSM');
                    case 152.2:
                        return Pel::tra('Sigma 14mm f/2.8 EX Aspherical HSM');
                    case 152.3:
                        return Pel::tra('Sigma 10-20mm f/4-5.6');
                    case 152.4:
                        return Pel::tra('Sigma 100-300mm f/4');
                    case 153:
                        return Pel::tra('Canon EF 35-350mm f/3.5-5.6L or Sigma or Tamron Lens');
                    case 153.1:
                        return Pel::tra('Sigma 50-500mm f/4-6.3 APO HSM EX');
                    case 153.2:
                        return Pel::tra('Tamron AF 28-300mm f/3.5-6.3 XR LD Aspherical [IF] Macro');
                    case 153.3:
                        return Pel::tra('Tamron AF 18-200mm f/3.5-6.3 XR Di II LD Aspherical [IF] Macro Model A14');
                    case 153.4:
                        return Pel::tra('Tamron 18-250mm f/3.5-6.3 Di II LD Aspherical [IF] Macro');
                    case 154:
                        return Pel::tra('Canon EF 20mm f/2.8 USM or Zeiss Lens');
                    case 154.1:
                        return Pel::tra('Zeiss Milvus 21mm f/2.8');
                    case 155:
                        return Pel::tra('Canon EF 85mm f/1.8 USM');
                    case 156:
                        return Pel::tra('Canon EF 28-105mm f/3.5-4.5 USM or Tamron Lens');
                    case 156.1:
                        return Pel::tra('Tamron SP 70-300mm f/4.0-5.6 Di VC USD');
                    case 156.2:
                        return Pel::tra('Tamron SP AF 28-105mm f/2.8 LD Aspherical IF');
                    case 160:
                        return Pel::tra('Canon EF 20-35mm f/3.5-4.5 USM or Tamron or Tokina Lens');
                    case 160.1:
                        return Pel::tra('Tamron AF 19-35mm f/3.5-4.5');
                    case 160.2:
                        return Pel::tra('Tokina AT-X 124 AF Pro DX 12-24mm f/4');
                    case 160.3:
                        return Pel::tra('Tokina AT-X 107 AF DX 10-17mm f/3.5-4.5 Fisheye');
                    case 160.4:
                        return Pel::tra('Tokina AT-X 116 AF Pro DX 11-16mm f/2.8');
                    case 160.5:
                        return Pel::tra('Tokina AT-X 11-20 F2.8 PRO DX Aspherical 11-20mm f/2.8');
                    case 161:
                        return Pel::tra('Canon EF 28-70mm f/2.8L or Sigma or Tamron Lens');
                    case 161.1:
                        return Pel::tra('Sigma 24-70mm f/2.8 EX');
                    case 161.2:
                        return Pel::tra('Sigma 28-70mm f/2.8 EX');
                    case 161.3:
                        return Pel::tra('Sigma 24-60mm f/2.8 EX DG');
                    case 161.4:
                        return Pel::tra('Tamron AF 17-50mm f/2.8 Di-II LD Aspherical');
                    case 161.5:
                        return Pel::tra('Tamron 90mm f/2.8');
                    case 161.6:
                        return Pel::tra('Tamron SP AF 17-35mm f/2.8-4 Di LD Aspherical IF');
                    case 161.7:
                        return Pel::tra('Tamron SP AF 28-75mm f/2.8 XR Di LD Aspherical [IF] Macro');
                    case 162:
                        return Pel::tra('Canon EF 200mm f/2.8L');
                    case 163:
                        return Pel::tra('Canon EF 300mm f/4L');
                    case 164:
                        return Pel::tra('Canon EF 400mm f/5.6L');
                    case 165:
                        return Pel::tra('Canon EF 70-200mm f/2.8 L');
                    case 166:
                        return Pel::tra('Canon EF 70-200mm f/2.8 L + 1.4x');
                    case 167:
                        return Pel::tra('Canon EF 70-200mm f/2.8 L + 2x');
                    case 168:
                        return Pel::tra('Canon EF 28mm f/1.8 USM or Sigma Lens');
                    case 168.1:
                        return Pel::tra('Sigma 50-100mm f/1.8 DC HSM | A');
                    case 169:
                        return Pel::tra('Canon EF 17-35mm f/2.8L or Sigma Lens');
                    case 169.1:
                        return Pel::tra('Sigma 18-200mm f/3.5-6.3 DC OS');
                    case 169.2:
                        return Pel::tra('Sigma 15-30mm f/3.5-4.5 EX DG Aspherical');
                    case 169.3:
                        return Pel::tra('Sigma 18-50mm f/2.8 Macro');
                    case 169.4:
                        return Pel::tra('Sigma 50mm f/1.4 EX DG HSM');
                    case 169.5:
                        return Pel::tra('Sigma 85mm f/1.4 EX DG HSM');
                    case 169.6:
                        return Pel::tra('Sigma 30mm f/1.4 EX DC HSM');
                    case 169.7:
                        return Pel::tra('Sigma 35mm f/1.4 DG HSM');
                    case 170:
                        return Pel::tra('Canon EF 200mm f/2.8L II');
                    case 171:
                        return Pel::tra('Canon EF 300mm f/4L');
                    case 172:
                        return Pel::tra('Canon EF 400mm f/5.6L or Sigma Lens');
                    case 172.1:
                        return Pel::tra('Sigma 150-600mm f/5-6.3 DG OS HSM | S');
                    case 173:
                        return Pel::tra('Canon EF 180mm Macro f/3.5L or Sigma Lens');
                    case 173.1:
                        return Pel::tra('Sigma 180mm EX HSM Macro f/3.5');
                    case 173.2:
                        return Pel::tra('Sigma APO Macro 150mm f/2.8 EX DG HSM');
                    case 174:
                        return Pel::tra('Canon EF 135mm f/2L or Other Lens');
                    case 174.1:
                        return Pel::tra('Sigma 70-200mm f/2.8 EX DG APO OS HSM');
                    case 174.2:
                        return Pel::tra('Sigma 50-500mm f/4.5-6.3 APO DG OS HSM');
                    case 174.3:
                        return Pel::tra('Sigma 150-500mm f/5-6.3 APO DG OS HSM');
                    case 174.4:
                        return Pel::tra('Zeiss Milvus 100mm f/2 Makro');
                    case 175:
                        return Pel::tra('Canon EF 400mm f/2.8L');
                    case 176:
                        return Pel::tra('Canon EF 24-85mm f/3.5-4.5 USM');
                    case 177:
                        return Pel::tra('Canon EF 300mm f/4L IS');
                    case 178:
                        return Pel::tra('Canon EF 28-135mm f/3.5-5.6 IS');
                    case 179:
                        return Pel::tra('Canon EF 24mm f/1.4L');
                    case 180:
                        return Pel::tra('Canon EF 35mm f/1.4L or Other Lens');
                    case 180.1:
                        return Pel::tra('Sigma 50mm f/1.4 DG HSM | A');
                    case 180.2:
                        return Pel::tra('Sigma 24mm f/1.4 DG HSM | A');
                    case 180.3:
                        return Pel::tra('Zeiss Milvus 50mm f/1.4');
                    case 180.4:
                        return Pel::tra('Zeiss Milvus 85mm f/1.4');
                    case 180.5:
                        return Pel::tra('Zeiss Otus 28mm f/1.4 ZE');
                    case 181:
                        return Pel::tra('Canon EF 100-400mm f/4.5-5.6L IS + 1.4x or Sigma Lens');
                    case 181.1:
                        return Pel::tra('Sigma 150-600mm f/5-6.3 DG OS HSM | S + 1.4x');
                    case 182:
                        return Pel::tra('Canon EF 100-400mm f/4.5-5.6L IS + 2x or Sigma Lens');
                    case 182.1:
                        return Pel::tra('Sigma 150-600mm f/5-6.3 DG OS HSM | S + 2x');
                    case 183:
                        return Pel::tra('Canon EF 100-400mm f/4.5-5.6L IS or Sigma Lens');
                    case 183.1:
                        return Pel::tra('Sigma 150mm f/2.8 EX DG OS HSM APO Macro');
                    case 183.2:
                        return Pel::tra('Sigma 105mm f/2.8 EX DG OS HSM Macro');
                    case 183.3:
                        return Pel::tra('Sigma 180mm f/2.8 EX DG OS HSM APO Macro');
                    case 183.4:
                        return Pel::tra('Sigma 150-600mm f/5-6.3 DG OS HSM | C');
                    case 183.5:
                        return Pel::tra('Sigma 150-600mm f/5-6.3 DG OS HSM | S');
                    case 183.6:
                        return Pel::tra('Sigma 100-400mm f/5-6.3 DG OS HSM');
                    case 184:
                        return Pel::tra('Canon EF 400mm f/2.8L + 2x');
                    case 185:
                        return Pel::tra('Canon EF 600mm f/4L IS');
                    case 186:
                        return Pel::tra('Canon EF 70-200mm f/4L');
                    case 187:
                        return Pel::tra('Canon EF 70-200mm f/4L + 1.4x');
                    case 188:
                        return Pel::tra('Canon EF 70-200mm f/4L + 2x');
                    case 189:
                        return Pel::tra('Canon EF 70-200mm f/4L + 2.8x');
                    case 190:
                        return Pel::tra('Canon EF 100mm f/2.8 Macro USM');
                    case 191:
                        return Pel::tra('Canon EF 400mm f/4 DO IS');
                    case 193:
                        return Pel::tra('Canon EF 35-80mm f/4-5.6 USM');
                    case 194:
                        return Pel::tra('Canon EF 80-200mm f/4.5-5.6 USM');
                    case 195:
                        return Pel::tra('Canon EF 35-105mm f/4.5-5.6 USM');
                    case 196:
                        return Pel::tra('Canon EF 75-300mm f/4-5.6 USM');
                    case 197:
                        return Pel::tra('Canon EF 75-300mm f/4-5.6 IS USM or Sigma Lens');
                    case 197.1:
                        return Pel::tra('Sigma 18-300mm f/3.5-6.3 DC Macro OS HS');
                    case 198:
                        return Pel::tra('Canon EF 50mm f/1.4 USM or Zeiss Lens');
                    case 198.1:
                        return Pel::tra('Zeiss Otus 55mm f/1.4 ZE');
                    case 198.2:
                        return Pel::tra('Zeiss Otus 85mm f/1.4 ZE');
                    case 199:
                        return Pel::tra('Canon EF 28-80mm f/3.5-5.6 USM');
                    case 200:
                        return Pel::tra('Canon EF 75-300mm f/4-5.6 USM');
                    case 201:
                        return Pel::tra('Canon EF 28-80mm f/3.5-5.6 USM');
                    case 202:
                        return Pel::tra('Canon EF 28-80mm f/3.5-5.6 USM IV');
                    case 208:
                        return Pel::tra('Canon EF 22-55mm f/4-5.6 USM');
                    case 209:
                        return Pel::tra('Canon EF 55-200mm f/4.5-5.6');
                    case 210:
                        return Pel::tra('Canon EF 28-90mm f/4-5.6 USM');
                    case 211:
                        return Pel::tra('Canon EF 28-200mm f/3.5-5.6 USM');
                    case 212:
                        return Pel::tra('Canon EF 28-105mm f/4-5.6 USM');
                    case 213:
                        return Pel::tra('Canon EF 90-300mm f/4.5-5.6 USM or Tamron Lens');
                    case 213.1:
                        return Pel::tra('Tamron SP 150-600mm f/5-6.3 Di VC USD');
                    case 213.2:
                        return Pel::tra('Tamron 16-300mm f/3.5-6.3 Di II VC PZD Macro');
                    case 213.3:
                        return Pel::tra('Tamron SP 35mm f/1.8 Di VC USD');
                    case 213.4:
                        return Pel::tra('Tamron SP 45mm f/1.8 Di VC USD');
                    case 214:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 USM');
                    case 215:
                        return Pel::tra('Canon EF 55-200mm f/4.5-5.6 II USM');
                    case 217:
                        return Pel::tra('Tamron AF 18-270mm f/3.5-6.3 Di II VC PZD');
                    case 224:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS');
                    case 225:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS + 1.4x');
                    case 226:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS + 2x');
                    case 227:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS + 2.8x');
                    case 228:
                        return Pel::tra('Canon EF 28-105mm f/3.5-4.5 USM');
                    case 229:
                        return Pel::tra('Canon EF 16-35mm f/2.8L');
                    case 230:
                        return Pel::tra('Canon EF 24-70mm f/2.8L');
                    case 231:
                        return Pel::tra('Canon EF 17-40mm f/4L');
                    case 232:
                        return Pel::tra('Canon EF 70-300mm f/4.5-5.6 DO IS USM');
                    case 233:
                        return Pel::tra('Canon EF 28-300mm f/3.5-5.6L IS');
                    case 234:
                        return Pel::tra('Canon EF-S 17-85mm f/4-5.6 IS USM or Tokina Lens');
                    case 234.1:
                        return Pel::tra('Tokina AT-X 12-28 PRO DX 12-28mm f/4');
                    case 235:
                        return Pel::tra('Canon EF-S 10-22mm f/3.5-4.5 USM');
                    case 236:
                        return Pel::tra('Canon EF-S 60mm f/2.8 Macro USM');
                    case 237:
                        return Pel::tra('Canon EF 24-105mm f/4L IS');
                    case 238:
                        return Pel::tra('Canon EF 70-300mm f/4-5.6 IS USM');
                    case 239:
                        return Pel::tra('Canon EF 85mm f/1.2L II');
                    case 240:
                        return Pel::tra('Canon EF-S 17-55mm f/2.8 IS USM');
                    case 241:
                        return Pel::tra('Canon EF 50mm f/1.2L');
                    case 242:
                        return Pel::tra('Canon EF 70-200mm f/4L IS');
                    case 243:
                        return Pel::tra('Canon EF 70-200mm f/4L IS + 1.4x');
                    case 244:
                        return Pel::tra('Canon EF 70-200mm f/4L IS + 2x');
                    case 245:
                        return Pel::tra('Canon EF 70-200mm f/4L IS + 2.8x');
                    case 246:
                        return Pel::tra('Canon EF 16-35mm f/2.8L II');
                    case 247:
                        return Pel::tra('Canon EF 14mm f/2.8L II USM');
                    case 248:
                        return Pel::tra('Canon EF 200mm f/2L IS or Sigma Lens');
                    case 248.1:
                        return Pel::tra('Sigma 24-35mm f/2 DG HSM | A');
                    case 249:
                        return Pel::tra('Canon EF 800mm f/5.6L IS');
                    case 250:
                        return Pel::tra('Canon EF 24mm f/1.4L II or Sigma Lens');
                    case 250.1:
                        return Pel::tra('Sigma 20mm f/1.4 DG HSM | A');
                    case 251:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS II USM');
                    case 252:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS II USM + 1.4x');
                    case 253:
                        return Pel::tra('Canon EF 70-200mm f/2.8L IS II USM + 2x');
                    case 254:
                        return Pel::tra('Canon EF 100mm f/2.8L Macro IS USM');
                    case 255:
                        return Pel::tra('Sigma 24-105mm f/4 DG OS HSM | A or Other Sigma Lens');
                    case 255.1:
                        return Pel::tra('Sigma 180mm f/2.8 EX DG OS HSM APO Macro');
                    case 488:
                        return Pel::tra('Canon EF-S 15-85mm f/3.5-5.6 IS USM');
                    case 489:
                        return Pel::tra('Canon EF 70-300mm f/4-5.6L IS USM');
                    case 490:
                        return Pel::tra('Canon EF 8-15mm f/4L Fisheye USM');
                    case 491:
                        return Pel::tra('Canon EF 300mm f/2.8L IS II USM or Tamron Lens');
                    case 491.1:
                        return Pel::tra('Tamron SP 70-200mm F/2.8 Di VC USD G2 (A025)');
                    case 491.2:
                        return Pel::tra('Tamron 18-400mm F/3.5-6.3 Di II VC HLD (B028)');
                    case 492:
                        return Pel::tra('Canon EF 400mm f/2.8L IS II USM');
                    case 493:
                        return Pel::tra('Canon EF 500mm f/4L IS II USM or EF 24-105mm f4L IS USM');
                    case 493.1:
                        return Pel::tra('Canon EF 24-105mm f/4L IS USM');
                    case 494:
                        return Pel::tra('Canon EF 600mm f/4.0L IS II USM');
                    case 495:
                        return Pel::tra('Canon EF 24-70mm f/2.8L II USM or Sigma Lens');
                    case 495.1:
                        return Pel::tra('Sigma 24-70mm F2.8 DG OS HSM | A');
                    case 496:
                        return Pel::tra('Canon EF 200-400mm f/4L IS USM');
                    case 499:
                        return Pel::tra('Canon EF 200-400mm f/4L IS USM + 1.4x');
                    case 502:
                        return Pel::tra('Canon EF 28mm f/2.8 IS USM');
                    case 503:
                        return Pel::tra('Canon EF 24mm f/2.8 IS USM');
                    case 504:
                        return Pel::tra('Canon EF 24-70mm f/4L IS USM');
                    case 505:
                        return Pel::tra('Canon EF 35mm f/2 IS USM');
                    case 506:
                        return Pel::tra('Canon EF 400mm f/4 DO IS II USM');
                    case 507:
                        return Pel::tra('Canon EF 16-35mm f/4L IS USM');
                    case 508:
                        return Pel::tra('Canon EF 11-24mm f/4L USM or Tamron Lens');
                    case 508.1:
                        return Pel::tra('Tamron 10-24mm f/3.5-4.5 Di II VC HLD');
                    case 747:
                        return Pel::tra('Canon EF 100-400mm f/4.5-5.6L IS II USM or Tamron Lens');
                    case 747.1:
                        return Pel::tra('Tamron SP 150-600mm F5-6.3 Di VC USD G2');
                    case 748:
                        return Pel::tra('Canon EF 100-400mm f/4.5-5.6L IS II USM + 1.4x');
                    case 750:
                        return Pel::tra('Canon EF 35mm f/1.4L II USM');
                    case 751:
                        return Pel::tra('Canon EF 16-35mm f/2.8L III USM');
                    case 752:
                        return Pel::tra('Canon EF 24-105mm f/4L IS II USM');
                    case 4142:
                        return Pel::tra('Canon EF-S 18-135mm f/3.5-5.6 IS STM');
                    case 4143:
                        return Pel::tra('Canon EF-M 18-55mm f/3.5-5.6 IS STM or Tamron Lens');
                    case 4143.1:
                        return Pel::tra('Tamron 18-200mm F/3.5-6.3 Di III VC');
                    case 4144:
                        return Pel::tra('Canon EF 40mm f/2.8 STM');
                    case 4145:
                        return Pel::tra('Canon EF-M 22mm f/2 STM');
                    case 4146:
                        return Pel::tra('Canon EF-S 18-55mm f/3.5-5.6 IS STM');
                    case 4147:
                        return Pel::tra('Canon EF-M 11-22mm f/4-5.6 IS STM');
                    case 4148:
                        return Pel::tra('Canon EF-S 55-250mm f/4-5.6 IS STM');
                    case 4149:
                        return Pel::tra('Canon EF-M 55-200mm f/4.5-6.3 IS STM');
                    case 4150:
                        return Pel::tra('Canon EF-S 10-18mm f/4.5-5.6 IS STM');
                    case 4152:
                        return Pel::tra('Canon EF 24-105mm f/3.5-5.6 IS STM');
                    case 4153:
                        return Pel::tra('Canon EF-M 15-45mm f/3.5-6.3 IS STM');
                    case 4154:
                        return Pel::tra('Canon EF-S 24mm f/2.8 STM');
                    case 4155:
                        return Pel::tra('Canon EF-M 28mm f/3.5 Macro IS STM');
                    case 4156:
                        return Pel::tra('Canon EF 50mm f/1.8 STM');
                    case 4157:
                        return Pel::tra('Canon EF-M 18-150mm 1:3.5-6.3 IS STM');
                    case 4158:
                        return Pel::tra('Canon EF-S 18-55mm f/4-5.6 IS STM');
                    case 4160:
                        return Pel::tra('Canon EF-S 35mm f/2.8 Macro IS STM');
                    case 36910:
                        return Pel::tra('Canon EF 70-300mm f/4-5.6 IS II USM');
                    case 36912:
                        return Pel::tra('Canon EF-S 18-135mm f/3.5-5.6 IS USM');
                    case 61494:
                        return Pel::tra('Canon CN-E 85mm T1.3 L F');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_FOCUS_CONTINUOUS:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Single');
                    case 1:
                        return Pel::tra('Continuous');
                    case 8:
                        return Pel::tra('Manual');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_AE_SETTING:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Normal AE');
                    case 1:
                        return Pel::tra('Exposure Compensation');
                    case 2:
                        return Pel::tra('AE Lock');
                    case 3:
                        return Pel::tra('AE Lock + Exposure Comp.');
                    case 4:
                        return Pel::tra('No AE');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_IMAGE_STABILIZATION:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Off');
                    case 1:
                        return Pel::tra('On');
                    case 2:
                        return Pel::tra('Shoot Only');
                    case 3:
                        return Pel::tra('Panning');
                    case 4:
                        return Pel::tra('Dynamic');
                    case 256:
                        return Pel::tra('Off (2)');
                    case 257:
                        return Pel::tra('On (2)');
                    case 258:
                        return Pel::tra('Shoot Only (2)');
                    case 259:
                        return Pel::tra('Panning (2)');
                    case 260:
                        return Pel::tra('Dynamic (2)');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_SPOT_METERING_MODE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Center');
                    case 1:
                        return Pel::tra('AF Point');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_PHOTO_EFFECT:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Off');
                    case 1:
                        return Pel::tra('Vivid');
                    case 2:
                        return Pel::tra('Neutral');
                    case 3:
                        return Pel::tra('Smooth');
                    case 4:
                        return Pel::tra('Sepia');
                    case 5:
                        return Pel::tra('B&W');
                    case 6:
                        return Pel::tra('Custom');
                    case 100:
                        return Pel::tra('My Color Data');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_MANUAL_FLASH_OUTPUT:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0x500:
                        return Pel::tra('Full');
                    case 0x502:
                        return Pel::tra('Medium');
                    case 0x504:
                        return Pel::tra('Low');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_COLOR_TONE:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 0:
                        return Pel::tra('Normal');
                    default:
                        return $this->value[0];
                }
                break;
            case PelTag::CANON_CS_SRAW_QUALITY:
                // CC (e->components, 1, v);
                switch ($this->value[0]) {
                    case 1:
                        return Pel::tra('sRAW1 (mRAW)');
                    case 2:
                        return Pel::tra('sRAW2 (sRAW)');
                    default:
                        return $this->value[0];
                }
                break;
            default:
                return parent::getText($brief);
        }
    }
}
