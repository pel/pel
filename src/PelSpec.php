<?php

namespace lsolesen\pel;

use lsolesen\pel\Util\SpecCompiler;

/**
 * Class to retrieve IFD and TAG information from YAML specs.
 */
class PelSpec
{
    /**
     * The compiled PEL specification map.
     *
     * @var array
     */
    private static $map;

    /**
     * Returns the compiled PEL specification map.
     *
     * In case the map is not yet initialized, defaults to the pre-compiled
     * one.
     *
     * @return array
     *            the PEL specification map.
     */
    private static function getMap()
    {
        if (!isset(self::$map)) {
            self::setMap(__DIR__ . '/../resources/spec.php');
        }
        return self::$map;
    }

    /**
     * Sets the compiled PEL specification map.
     *
     * @param string $file
     *            the file containing the PEL specification map.
     */
    public static function setMap($file)
    {
        if ($file === null) {
            self::$map = null;
        } else {
            self::$map = include $file;
        }
    }

    /**
     * Returns the IFD types in the specification.
     *
     * @return array
     *            an associative array, with keys the IFD identifiers, and
     *            values the IFD types.
     */
    public static function getIfdTypes()
    {
        return self::getMap()['ifds'];
    }

    /**
     * Returns the TAG ids supported in an IFD.
     *
     * @param int $ifd_id
     *            the IFD id.
     *
     * @return array
     *            an simple array, with values the TAG identifiers supported by
     *            the IFD.
     */
    public static function getIfdSupportedTagIds($ifd_id)
    {
        return array_keys(self::getMap()['tags'][$ifd_id]);
    }

    /**
     * Returns the IFD type.
     *
     * @param int $ifd_id
     *            the IFD id.
     *
     * @return string
     *            the IFD type.
     */
    public static function getIfdType($ifd_id)
    {
        return isset(self::getMap()['ifds'][$ifd_id]) ? self::getMap()['ifds'][$ifd_id] : null;
    }

    /**
     * Returns the IFD id given its type.
     *
     * @param string $ifd_type
     *            the IFD type.
     *
     * @return int
     *            the IFD id.
     */
    public static function getIfdIdByType($ifd_type)
    {
        return isset(self::getMap()['ifdsByType'][$ifd_type]) ? self::getMap()['ifdsByType'][$ifd_type] : null;
    }

    /**
     * Determines if the TAG is an IFD pointer.
     *
     * @param int $ifd_id
     *            the IFD id.
     * @param int $tag_id
     *            the TAG id.
     *
     * @return int
     *            the IFD id, or FALSE.
     */
    public static function isTagAnIfdPointer($ifd_id, $tag_id)
    {
        return isset(self::getMap()['tags'][$ifd_id][$tag_id]['ifd']) ? self::getMap()['tags'][$ifd_id][$tag_id]['ifd'] : false;
    }

    /**
     * Returns the TAG name.
     *
     * @param int $ifd_id
     *            the IFD id.
     * @param int $tag_id
     *            the TAG id.
     *
     * @return string
     *            the TAG name.
     */
    public static function getTagName($ifd_id, $tag_id)
    {
        return isset(self::getMap()['tags'][$ifd_id][$tag_id]['name']) ? self::getMap()['tags'][$ifd_id][$tag_id]['name'] : null;
    }

    /**
     * Returns the TAG id given its name.
     *
     * @param int $ifd_id
     *            the IFD id.
     * @param string $tag_name
     *            the TAG name.
     *
     * @return int
     *            the TAG id.
     */
    public static function getTagIdByName($ifd_id, $tag_name)
    {
        return isset(self::getMap()['tagsByName'][$ifd_id][$tag_name]) ? self::getMap()['tagsByName'][$ifd_id][$tag_name] : null;
    }
}
