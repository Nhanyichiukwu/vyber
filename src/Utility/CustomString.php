<?php
namespace App\Utility;

use InvalidArgumentException;

/**
 * String Manipulation methods
 */
class CustomString
{
    public static function sanitize($str = null)
    {
        $str = htmlentities($str);
        $str = addslashes($str);
//        $str = addcslashes($str, '');
        $str = str_replace("'", "`", $str);
        return $str;
    }

    /**
     * Converts a given string from comma (,) separated, underscored (_) separated,
     *  hyphen (-) separated or dot (.) separated strings into camelCase.
     *
     * @param mixed $str
     * @return string
     */
    public static function toCamelCase($str)
    {
        $camelCased = null;
        $arr = (
            stripos($str, '_') != false
                ? explode('_', $str)
                : (
                stripos($str, '-') != false
                    ? explode('-', $str)
                    : [$str]
            )
        );

        if (!empty($arr)) {
            array_walk($arr, function(&$value, $index) {
                $value = ucfirst($value);
            });

            $camelCased = implode('', $arr);
            $camelCased = lcfirst($camelCased);
        }

        return $camelCased;
    }

    public static function toPascalCase($str)
    {

    }

    public static function toCommaSeparated($str)
    {

    }

    public static function underscore($str)
    {
        $underscored = str_replace(' ', '_', $str);
        $underscored = str_replace('-', '_', $str);

        return $underscored;
    }

    /**
     *
     * @param Mixed $str
     */
    public static function hyphenate($str)
    {
        $hyphenatedStr = str_ireplace(' ', '-', $str);
        $hyphenatedStr = str_ireplace('_', '-', $str);

        return $hyphenatedStr;
    }

    public static function splitCamelCase($str) {

    }
}
