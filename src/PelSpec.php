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
        if (!isset(static::$map)) {
            static::setMap(__DIR__ . '/../resources/spec.php');
        }
        return static::$map;
    }

    /**
     * Sets the compiled PEL specification map.
     *
     * @param string $file
     *            the file containing the PEL specification map.
     */
    public static function setMap($file)
    {
        static::$map = include $file;
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
        return static::getMap()['ifds'];
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
        return array_keys(static::getMap()['tags'][$ifd_id]);
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
        return isset(static::getMap()['ifds'][$ifd_id]) ? static::getMap()['ifds'][$ifd_id] : null;
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
        return isset(static::getMap()['ifdsByType'][$ifd_type]) ? static::getMap()['ifdsByType'][$ifd_type] : null;
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
        return isset(static::getMap()['tags'][$ifd_id][$tag_id]['name']) ? static::getMap()['tags'][$ifd_id][$tag_id]['name'] : null;
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
        return isset(static::getMap()['tagsByName'][$ifd_id][$tag_name]) ? static::getMap()['tagsByName'][$ifd_id][$tag_name] : null;
    }
}
