<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * CustomString component
 */
class CustomStringComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function sanitize($str) {

        return $str;
    }

    /**
     * 
     * @param mixed $str
     * @return string
     */
    public function toCamelCase($str) {
        $camelCased = null;
        $arr = (
                stripos($str, '_') != false ? explode('_', $str) :
                (stripos($str, '-') != false ? explode('-', $str) : [$str])
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

    public function toPascalCase($str) 
    {
        
    }

    public function toCommaSeparated($str) 
    {
        
    }

    public function underscore($str) 
    {
        
    }
    
    /**
     * 
     * @param Mixed $str
     */
    public function hyphenate($str)
    {
        $hyphenatedStr = str_ireplace(' ', '-', $str);
        
        return $hyphenatedStr;
    }

    public function splitCamelCase($str) {
        
    }

    /**
     * Random string generator method
     *
     * This function will randomly generate an alpha-numeric string from a given set of characters
     *
     * @param int $length, length of the password you want to generate
     * @param array $options options for to use to generate the string
     * @return string, the $generatedString
     */
    public function generateRandom($length = 8, $options = array()) {
        // initialize variables
        $generatedString = "";
        $i = 0;
        $possible = '';

        $numerals = '0123456789';
        $lowerAlpha = 'abcdefghijklmnopqrstuvwxyz';
        $upperAlpha = strtoupper($lowerAlpha);
        
        $defaultOptions = array('type' => 'alphanumeric', 'case' => 'mixed');

        $options = array_merge($defaultOptions, $options);

        if ($options['type'] == 'alphanumeric') {
            $possible .= $numerals;
            if ($options['case'] == 'lower') {
                $possible .= $lowerAlpha;
            } elseif ($options['case'] == 'upper') {
                $possible .= $upperAlpha;
            } elseif ($options['case'] == 'mixed') {
                $possible .= $lowerAlpha . $upperAlpha;
            }
        } elseif ($options['type'] == 'numbers') {
            $possible = $numerals;
        } elseif ($options['type'] == 'alpha') {
            //$possible = $lowerAlpha;
            if ($options['case'] == 'lower') {
                $possible .= $lowerAlpha;
            } elseif ($options['case'] == 'upper') {
                $possible .= $upperAlpha;
            } elseif ($options['case'] == 'mixed') {
                $possible .= $lowerAlpha . $upperAlpha;
            }
        }

        // $possible = '';
        // $numerals = '0123456789';
        // $lowerAlphabet = 'abcdefghijklmnopqrstuvwxyz';
        // $upperAlphabet = strtoupper($lowerAlphabet);
        // $symbols = '$#@!~`%^&*()_+-=|}{\][:;<>.,/?';
        // $defaultOptions = array('type'=>'alphanumeric', 'case'=>'mixed');
        // $options = array_merge($defaultOptions, $options);
        // $possible = $numerals;
        // if ($options['case'] == 'lower' OR $options['case'] == 'mixed') {
        // $possible .= $lowerAlphabet;
        // } elseif ($options['case'] == 'upper' OR $options['case'] == 'mixed') {
        // $possible .= $upperAlphabet;
        // }
        // if ($options['type'] != 'alphanumeric') {
        // $possible .= $symbols;
        // }
        // add random characters to $generatedString until $length is reached
        for ($i; $i < $length; $i++) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) -1), 1);

            // we don't want this character if it's already in the password
            if (strstr($generatedString, $char) === false) {
                $generatedString .= $char;
                //continue;
                //$i++;
            }
            //$generatedString .= $char;
        }
        if (strlen($generatedString) < $length) {
            $generatedString = $this->generateRandom($length, $options);
        }
        return $generatedString;
    }
    
    public function randomString($length = 8, $type = 'mixed')
    {
        $generatedString = "";
        $possible = '';
        $i = 0;

        $numbers = '0123456789';
        $lowerAlpha = 'abcdefghijklmnopqrstuvwxyz';
        $upperAlpha = strtoupper($lowerAlpha);
        
        switch ($type)
        {
            case 'mixed' :
                $possible = $numbers . $lowerAlpha . $upperAlpha;
                break;
            case 'numbers' :
                $possible = $numbers;
                break;
            case 'loweralpha' :
                $possible = $lowerAlpha;
                break;
            case 'upperlower' :
                $possible = $upperAlpha;
                break;
            default :
               $possible = $numbers . $lowerAlpha . $upperAlpha; 
        }
        
        for ($i; $i < $length; $i++) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) -1), 1);

            // we don't want this character if it's already in the password
            if (strstr($generatedString, $char) === false) {
                $generatedString .= $char;
                //continue;
                //$i++;
            }
            //$generatedString .= $char;
        }
        if (strlen($generatedString) < $length) {
            $generatedString = $this->generateRandom($length, $options);
        }
        return $generatedString;
    }

}
