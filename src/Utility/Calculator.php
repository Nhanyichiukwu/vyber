<?php

namespace App\Utility;

use InvalidArgumentException;

class Calculator
{

    protected $_timeString;
    
    public function calculateTimePassedSince($datetime, $limit = 1, $offset = 0, $full = false)
    {
        $ago = new \DateTime($datetime);
        $now = new \DateTime;
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        
//        $this->_timeString = $string;

        if (!$full)
            $string = array_slice($string, $offset, $limit);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    
    public function byteToMegabyte($bytes)
    {
        $float = $bytes / pow(10, 6);
        $arr = explode('.', $float);
        $mb = (int) $arr[0];
        $decimals =  0;
        if (isset($arr[1])) {
            $decimals = $arr[1] / pow(10, 2);
            $decimals = (int) ceil($decimals);
            $mb = (int) $mb . '.' . $decimals;
        }

        return $mb . 'MB';
    }
}
