<?php

namespace App\Utility;

use Cake\Chronos\Traits\TimezoneTrait;
use Cake\I18n\DateFormatTrait;
use InvalidArgumentException;
use Cake\I18n\Date;
use Cake\I18n\Time;

class DateTimeFormatter
{
    use DateFormatTrait;
    use TimezoneTrait;

    protected $_timeString;

    /**
     * Get the current datetime in the format 2020-05-14 05:47:02
     *
     * @return Cake\I18n\Time|string
     */
    public static function getCurrentDateTime($tz = null)
    {
        $time = new Time('now', $tz);
        $now = self::getInstance()->fullDateTime($time);

        return $now;
    }

    public static function humanizeDatetime($datetime, $timezone = null)
    {
        $niceTime = '';
        $datetime = self::fullDateTime($datetime);
        return $datetime;
//        $datetime = self::createFromFormat('Y-m-d H:i:s', $datetime, $timezone);

//        if ($this->Time->isToday($datetime)) {
//            $niceTime = $this->Time->timeAgoInWords($datetime);
//        } elseif ($this->Time->wasYesterday($datetime) || $this->Time->isPast($datetime) ) {
//            $niceTime = $this->Time->nice($datetime);
//        }
//        if (!$this->Time->isToday($datetime)) {
//            $lastComma = strrpos($niceTime, ',');
//            $niceTime = substr_replace($niceTime, ' @ ', $lastComma, 2);
//        }
//        if ($this->Time->wasYesterday($datetime)) {
//            $atpos = strpos($niceTime, '@');
//            $niceTime = substr_replace($niceTime, 'Yesterday ', 0, $atpos);
//        }
//
//        return $niceTime;
    }

    public static function fullDateTime($datetime)
    {
        if (is_string($datetime)) {
            $datetime = new Time($datetime);
        }

        $dateTimeString = $datetime->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $result = $datetime->parseDateTime($dateTimeString, 'yyyy-MM-dd HH:mm:ss');

        return $result;
    }

    public static function getInstance()
    {
//        if (isset($this)) {
////            $instance = $this;
//        } else {
            $instance = new static;
//        }

        return $instance;
    }
}
