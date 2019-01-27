<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 27-1-2019
 * Time: 14:18
 */

class Config
{

    private static $config;

    private static function parseFile($file)
    {
        return include_once (getcwd() . '/' . $file);
    }

    private static function getConfig()
    {

        if (self::$config !== null) {
            return self::$config;
        }

        self::$config = [];

        foreach (['config.php'] as $file) {
            self::$config = array_merge(self::$config, self::parseFile($file));
        }

        return self::$config;

    }


    private static function getValue(array &$array, $parents, $glue = '.')
    {
        if (!is_array($parents)) {
            $parents = explode($glue, $parents);
        }

        $ref = &$array;

        foreach ((array)$parents as $parent) {
            if (is_array($ref) && array_key_exists($parent, $ref)) {
                $ref = &$ref[$parent];
            } else {
                return null;
            }
        }
        return $ref;
    }


    public static function get($key): string
    {
        $config = self::getConfig();
        return (string) self::getValue($config, $key);
    }

}