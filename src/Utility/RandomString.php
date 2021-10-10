<?php
namespace App\Utility;

use InvalidArgumentException;

class RandomString
{
    private static $RSeed = 0;

    private static $str;


    public function __construct($str = null) {
        self::$str = $str;
    }

    public static function seed($s = 0) {
        self::$RSeed = abs(intval($s)) % 9999999 + 1;
        self::num();
    }

    public static function num($min = 0, $max = 9999999) {
        if (self::$RSeed == 0) {
            self::seed(mt_rand());
        }
        self::$RSeed = (self::$RSeed * 125) % 2796203;
        return self::$RSeed % ($max - $min + 1) + $min;
    }

    /**
     * Generates a random key
     *
     * @param int $length Length of the id. If left empty, it will default to 16
     * @param string $type What data type of id should be generated.
     * Valid options are: numbers, mixed, loweralpha, upperalpha, mixedalpha.
     *  If left empty, it will default to numbers
     * @return mixed A randomly generated unique id of the type specified
     * in $type
     */
    public static function generateString(
        int $length = null,
        string $type = 'numbers',
        string $startWith = null)
    {
        $generatedString = "";
        $possible = '';
        $i = 0;

        if ($length === null) {
            $length = 6;
        }

        $numbers = implode('',range(0,9));
        $lowerAlpha = implode('',range('a','z'));
        $upperAlpha = strtoupper($lowerAlpha);

        switch ($type) {
            case 'mixed' :
                $possible .= $numbers . $lowerAlpha . $upperAlpha;
                break;
            case 'numbers' :
                $possible .= $numbers;
                break;
            case 'loweralpha' :
                $possible .= $lowerAlpha;
                break;
            case 'upperalpha' :
                $possible .= $upperAlpha;
                break;
            case 'mixedalpha':
                $possible .= $lowerAlpha . $upperAlpha;
                break;
            default :
               $possible .= $numbers . $lowerAlpha . $upperAlpha;
        }

        for ($i; $i < $length; $i++) {
            $char = substr($possible, self::num(0, strlen($possible) - 1), 1);
            $generatedString .= $char;
        }
        if (strlen($generatedString) < $length) {
            $generatedString = self::generateString($length, $type);
        }
        if ($startWith !== null) {
            $firstChar = substr($generatedString, 0,1);
            if ($startWith === 'alpha' && is_numeric($firstChar)) {
                return static::generateString($length, $type, $startWith);
            } elseif ($startWith === 'num' && !is_numeric($firstChar)) {
                return static::generateString($length, $type, $startWith);
            }
        }

        return $generatedString;
    }

    /**
     * Generates a random id that stands unique, especially compared to its
     * counter parts. For example: When storing data with unique IDs field,
     * the $callback should be used to test newly generated id against the
     * existing records. If there is a record that matched the new id,
     * it should return true. Then the process will be started all over.
     * Otherwise, it must return false to end the process
     *
     * @param \callable $callback The user defined callback function used to
     * test for uniqueness on the destination of the new id.
     * @param int $len Length of the id. If left empty, it will default to 16
     * @param string $type What data type of id should be generated.
     * Valid options are: numbers, mixed, loweralpha, upperalpha, mixedalpha.
     *  If left empty, it will default to mixed
     * @return mixed A random but truly unique id
     */
    public static function generateUniqueID(callable $callback, int $len = null, string $type = null)
    {
        $len = $len ?? 16;
        $type = $type ?? 'mixed';
        $id = self::generateString($len, $type);
        // Check if the id already exists in the destination
        if (true === call_user_func_array($callback, [$id])) {
            return static::generateUniqueID($callback, $len, $type); // Start all over
        }
        return $id;
    }
}

