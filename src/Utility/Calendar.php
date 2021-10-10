<?php

 /**
 * @package NHOCalendar
 * @author Nhanyichiukwu Hopeson Otuosorochiukwu
 * @copyright (c) 2019 Nhanyichiukwu Hopeson Otuosorochiukwu
 */

namespace App\Utility;

use InvalidArgumentException;

/**
 * @author Nhanyichiukwu Hopeson Otuosorochiukwu
 */
class NHOCalendar {

    /**
     * @var string A random but unique string id for each calendar instance
     */
    protected $_id;
    
    
    protected $_type;
    
    /**
     * Names of week days
     * 
     * @var array
     */
    protected static $_dayNames = array(
        'sun' => 'Sunday',
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday'
    );
    
    protected static $_monthNames = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );

    /**
     * A specified year
     * 
     * @var int
     */
    protected $_year = 0;

    
    protected $_day;
    
    /**
     * A specified month
     * 
     * @var int 
     */
    protected $_month;
    protected $_daysInMonth;
    protected $_daysFromPrevMonth;
    protected $_daysIntoNextMonth;
    protected $_daysInLastMonth;
    protected $_lastMonthEnding;
    protected $_weekStartsOn = 'sunday';
    protected $_date = null;
    protected $_navUrl = null;

    /**
     * Http query params as an array
     * 
     * @var array
     */
    protected $_request = array();

    /**
     * $_SERVER
     * 
     * @var array
     */
    protected $_server = array();
    
    protected $_callbacks = array();
    protected $_currentDateOptions;

    public function __construct(array $options = null) {
        $server = filter_input_array(INPUT_SERVER);
        $this->_request = filter_input_array(INPUT_GET);
        
        $this->_navUrl = $server['PHP_SELF'];
        $this->_year = date("Y", time());
        $this->_month = date("m", time());
        $this->_date = date("Y-m-d", time());
        $this->_id = 'nho-calendar';
        
        if (isset($options['weekstarts']))
            $this->_weekStartsOn = $options['weekstarts'];
        if (isset($options['id']))
            $this->_id = $options['id'];
        if (isset($options['type']))
            $this->_type = $options['type'];
        if (isset($options['default_month']))
            $this->_setDefaultMonth($options['default_month']);
        if (isset($options['current_date'])) 
            $this->_currentDateOptions = $options['current_date'];
        
        if (isset($this->_request['cal_id']) && $this->_request['cal_id'] === $this->_id) {
            if (isset($this->_request['year'])) {
                $this->_year = $this->_request['year'];
            }
            if (isset($this->_request['month'])) {
                $this->_month = $this->_request['month'];
            }
            if (isset($this->_request['date'])) {
                $this->_month = $this->_request['date'];
            }
        }
    }

    public function display(array $options = null) {
        $this->_daysInMonth = self::getNumberOfDaysInMonth($this->_month, $this->_year);
        $url = $this->_navUrl . '?cal_id=' . $this->_id;
        
        $classes = $options['class'] ?? '';
        $content = '<div id="' . $this->_id . '" class="calendar ' . $classes . '">';
        $content .= '<div class="p-3 border-bottom">' . $this->_createNav($url) . '</div>';
        $content .= '<div class="calendar-content">';
        $content .= '<div class="table-responsive">';
        $content .= '<table class="card-table table table-sm table-bordered border-top table-vcenter">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .=  self::_createLabels();
        $content .= '</tr>';
        $content .= '</thead>';
        $content .= '<tbody>';
        $weeksInMonth = self::countWeeksInMonth($this->_month, $this->_year);
        $numberOfCells = $weeksInMonth * 7;
        $emptyCells = 0;
        for ($i = 0; $i < $weeksInMonth; $i++) {
            $content .= '<tr>';
            
            for ($j = 1; $j <= 7; $j++) {
                $day = $i * 7 + $j;
              $content .= self::_getDay($day);
            }
            
            $content .= '</tr>';
        }
        $content .= '</tbody>';
        $content .= '</table>';
        $content .= '</div>';
        $content .= '<div class="clear"></div>';
        $content .= '</div>';
        $content .= '</div>';
        return $content;
    }

    protected function _getDay(int $cellNum) 
    {
         if (! $this->_day || $this->_day == 0) {
            $monthStart = self::getMonthStartDay($this->_month, $this->_year); // date('N', strtotime($this->_year . '-' . $this->_month . '-01'));
            
            if (intval($cellNum) === intval($monthStart)) {
                $this->_day = 1; // Day 1
            }
        }
        
        if (
                ($this->_day != 0) && 
                ($this->_day <= $this->_daysInMonth)
        ) {
            $this->_date = date('Y-m-d', strtotime($this->_year . '-' . $this->_month . '-' . ($this->_day)));
            $cellValue = $this->_day;
            $this->_day++;
        } else {
            $this->_date = null; 
            
            $cellValue = null;
        }
        
        $weekStartOrEnd = ($cellNum % 7 == 1 ? ' week-start' : ($cellNum % 7 == 0 ? ' week-end' : ''));
        if (null === $cellValue) 
        {
            // Include days of next month that falls within the last week
            // of the current month
            if ($this->_day > $this->_daysInMonth) 
            {
                if ( !empty($this->_daysIntoNextMonth) ) {
                    $this->_daysIntoNextMonth++;
                } else {
                    $this->_daysIntoNextMonth = 1;
                }
                
                $cellValue = $this->_daysIntoNextMonth;
                $month = (intval($this->_month) === 12 ? 1 : intval($this->_month) + 1);
                $year = (intval($this->_month) === 12 ? intval($this->_year) + 1 : intval($this->_year));
                $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $cellValue));
                $whatmonth = 'next-month';
            }
            
            // Include days of last month that falls within the first week of
            // the current month
            else 
            {
//                $prevMonth = self::getPreviousMonth($this->_month);
                $month = self::getPreviousMonth($this->_month);
                $year = (intval($this->_month) === 1 ? intval($this->_year) - 1 : $this->_year);
                
                // Get the weekday in which the month ended
                $this->_lastMonthEnding = (int) self::getMonthEndingDay(
                    $month, $year
                );
                
                $daysInLastMonth = (int) self::getNumberOfDaysInMonth(
                    $month, $year
                );
                if ( !empty($this->_daysFromPrevMonth) ) {
                    $this->_daysFromPrevMonth++;
                } else {
                    $this->_daysFromPrevMonth = intval($daysInLastMonth) - intval($this->_lastMonthEnding);
//                    $this->_daysFromPrevMonth++;
                }
                $cellValue = $this->_daysFromPrevMonth;
                $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $cellValue));
                $whatmonth = ' past-month ';
            }
            $status = ' inactive ';
        }
        else {
            $month = $this->_month;
            $year = $this->_year;
            $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $cellValue));
            $whatmonth = ' current-month ';
            $status = ' active ';
        }
        $currentDay = date('Y-m-d', strtotime($year . '-' . $month . '-' . $cellValue)) === date('Y-m-d', time()) ? ' today ' : ' ';
        
        if (self::_hasCallback('days')) {
            self::_applyCallback('days', [$date, &$cellValue]);
        }
        $cellId = $this->_currentDateOptions['id'] ?? '';
        $cellClass = $this->_currentDateOptions['class'] ?? '';
//        if (is_array($this->_currentDateOptions)) {
//            $cellId = $this->_currentDateOptions['id'] ?? '';
//            $cellClass = $this->_currentDateOptions['class'] ?? '';
//        }
        $day = '<td class="calendar-day' . $currentDay . $whatmonth . $status 
                . $weekStartOrEnd . '" data-year="' . $year . '" data-month="' 
                . self::$_monthNames[$month - 1] . '" data-date="' . $date 
                . '" title="' . self::humanReadableDate($date) . '">';
        // Apply callbacks if any
        if ($this->_hasCallback('cells'))
            $day .= $this->_applyCallback('cells', [$date]);
        $day .= $cellValue;
        $day .= '</td>';
        
        return $day;
    }
    
    public static function getPreviousMonth($month = null) {
        if (null === $month)
            $month = date ('m');
        return intval($month) === 1 ? 12 : intval($month) - 1;
    }
    
    public static function getNextMonth($month = null) {
        if (null === $month)
            $month = date ('m');
        return intval($month) === 12 ? 1 : intval($month) + 1;
    }
    
//    protected static function _getPrevYear($year = null) {
////        if (null === $month)
////            $month = date ('m', time ());
//        if (null === $year)
//            $year = date ('Y');
////        return intval($month) === 1 ? intval($year) - 1 : $year;
//        return intval($year) - 1;
//    }
//    
//    protected static function _getNextYear($year = null) {
////        if (null === $month)
////            $month = date ('m', time ());
//        if (null === $year)
//            $year = date ('Y');
////        return intval($month) === 12 ? intval($year) + 1 : $year;
//        return intval($year) + 1;
//    }

    /**
     * Get the day of the week in which the month started
     * 
     * @param string|integer $month
     * @param string|integer $year
     * @return integer A number representing the weekday (Sun, Mon, Tue, etc...) 
     * in which the month started
     */
    public static function getMonthStartDay($month = null, $year = null) {
        if (null === $month)
            $month = date('m', time());
        if (null === $year)
            $year = date('Y', time());
        
        $startDay = date('N', strtotime($year . '-' . $month . '-01'));
        $startDay += 1;
        if (isset($this) && !$this->_weekStartsOn('sunday')) {
            $startDay -= 1;
        }
        
        return $startDay;
    }
    
    /**
     * Get the day of the week in which the month ended
     * 
     * @param string|integer|null $month
     * @param string|integer|null $year
     * @return integer A number representing the weekday (Sun, Mon, Tue, etc...) 
     * in which the month ended
     */
    public static function getMonthEndingDay($month = null, $year = null) {
        if (null === $month)
            $month = date('m', time());
        if (null === $year)
            $year = date('Y', time());
        
        $endingDay = date('N', strtotime($year . '-' . $month . '-' . self::getNumberOfDaysInMonth($month, $year)));
//        $endingDay += 1;
//        if (isset($this) && !$this->_weekStartsOn('sunday')) {
//            $endingDay -= 1;
//        }
        
        return $endingDay;
    }
    
    protected function _weekStartsOn($weekday) {
        if (strtolower($this->_weekStartsOn) === strtolower($weekday))
            return true;
        return false;
    }

    /**
     * Creates the navigation for the calendar
     */
    protected function _createNav($url = null) {
        if (null === $url)
            $url = $this->_navUrl;
        
        $nextMonth = intval($this->_month) === 12 ? 1 : intval($this->_month) + 1;
        $nextYear = intval($this->_month) === 12 ? intval($this->_year) + 1 : $this->_year;
        $preMonth = intval($this->_month) === 1 ? 12 : intval($this->_month) - 1;
        $preYear = intval($this->_month) === 1 ? intval($this->_year) - 1 : $this->_year;
        return
                '<div class="header">' .
                '<div class="c-btn-group">' .
                '<a class="prev c-btn" href="' . $url . '&month=' . sprintf('%02d', $preMonth) .'&year=' . $preYear . '">Prev</a>' .
                '<a class="next c-btn" href="' . $url . '&month=' . sprintf("%02d", $nextMonth) . '&year=' . $nextYear . '">Next</a>' .
                '</div>' .
                '</div>';
    }

    /**
     * Creates the calendar week days labels
     */
    protected function _createLabels() {
        $content = '';
        if (! $this->_weekStartsOn('sunday')) {
            $startDay = strtolower(substr($this->_weekStartsOn, 0, 3));
            $dayIndex = array_search($startDay, array_keys(self::$_dayNames));
            
            if (false !== $dayIndex) {
                $slice = array_slice(self::$_dayNames, $dayIndex);
                // Pending...
            }
        }
        foreach (self::$_dayNames as $shortName => $fullName) {
            $keyIndex = array_search($shortName, array_keys(self::$_dayNames));
            $content .= '<th class="' . ( $keyIndex === 6 ? 'end title' : 'start title') . ' title" title="' . ucfirst($fullName) . '">' . ucfirst($shortName) . '</th>';
        }
        
        return $content;
    }

    public static function countWeeksInMonth($month = null, $year = null) {
        if (null == $year)
            $year = date("Y", time());
        if (null == $month)
            $month = date("m", time());
        
        $daysInMonths = self::getNumberOfDaysInMonth($month, $year);
        $numOfweeks = (($daysInMonths % 7) === 0 ? 0 : 1) + intval($daysInMonths / 7);
        $monthEndingDay = self::getMonthEndingDay($month, $year); // date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));
        $monthStartDay = self::getMonthStartDay($month, $year); // date('N', strtotime($year . '-' . $month . '-01'));
        
        // Force the calendar to maintain 6 weeks (rows) no matter what
        if ($numOfweeks < 6) {
            $numOfweeks += (6 - $numOfweeks);
        }
        
//        if ($monthEndingDay < $monthStartDay)
//            $numOfweeks++;
        
        return $numOfweeks;
    }

    public static function getNumberOfDaysInMonth($month = null, $year = null) {
        if (null === $year)
            $year = date("Y", time());
        
        if (null === $month) {
            $month = date("m", time());
        } else {
            $month = date("m", strtotime($year . '-' . $month));
        }
        
        return date('t', strtotime($year . '-' . $month));
    }
    
    /**
     * 
     * @param mixed $callback
     * @param string $to
     */
    public function setCallbacks($callback, $key = null) 
    {
        if (is_array($callback)) {
            foreach ($callback as $key => $callable) {
                if (!is_callable($callable))
                    continue;
                $this->_callbacks[$key] = $callable;
            }
        } 
        else if (is_callable($callback) && $key) {
            $this->_callbacks[$key] = $callback;
        }
    }
    
    protected function _hasCallback($section) {
        return array_key_exists($section, $this->_callbacks);
    }
    
    protected function _applyCallback($section, array $params) {
        if ($this->_hasCallback($section)) {
            $callback = $this->_callbacks[$section];
            
            return call_user_func_array($callback, $params);
        }
        
        return null;
    }
    
    protected static function _applyScript() {
        $script = '<script>';
        
        $script .= '</script>';
    }

    public static function humanReadableDate($date) {
        return date('F d, Y', strtotime($date));
    }

    protected function _setDefaultMonth($month) {
        if (is_numeric($month) || is_int($month) && \DateTime::createFromFormat('F', $month) !== false) {
            $this->_month = $month;
        } elseif (is_string($month) && \DateTime::createFromFormat('F', $month) !== false) {
            $this->_month = date('m', strtotime($month));
        }
    }
    
    /**
     * 
     * @param string $quarter (Optional) The required quarter: Valid inputs are 
     * 'first' = The first 3 months of the year,
     * 'second' = 
     * 'third' = 
     * 'current' = The current 3 month term of the year, 
     * 'previous' = The past 3 months term of the year, 
     * 'next' = The next 3 months term of the year, 
     * 'last' = The last 3 months term of the year
     * 
     * @param string|null $year (Optional) If null, the current calendar year will be used
     * as default year
     * 
     * @return string A time frame representing a space from month one to month 
     * three, in the format: Y-m-d, Y-m-d
     */
    public static function getQuarter($quarter = 'current', $year = null) {
        if (null === $year)
            $year = date ('Y');
        
        $quarters = array_chunk(self::$_monthNames, 3);
        $currentMonth = date('F');
        $requestedQuarter = '';
        $qtrIndex = 0;
        for ($i = 0; $i < count($quarters); $i++) {
            if (in_array($currentMonth, $quarters[$i])) {
                $requestedQuarter = $quarters[$i];
                $qtrIndex = $i++;
                break;
            }
        }
        switch ($quarter) {
            case 'first' :
                $requestedQuarter = $quarters[0];
                $qtrIndex = 1;
                break;
            case 'second' :
                $requestedQuarter = $quarters[1];
                $qtrIndex = 2;
                break;
            case 'third' :
                $requestedQuarter = $quarters[2];
                $qtrIndex = 3;
                break;
            case 'current' :
                for ($i = 0; $i < count($quarters); $i++) {
                    if (in_array($currentMonth, $quarters[$i])) {
                        $requestedQuarter = $quarters[$i];
                        $qtrIndex = $i++;
                        break;
                    }
                }
                break;
            case 'previous' : 
                for ($i = 0; $i < count($quarters); $i++) {
                    if (in_array($currentMonth, $quarters[$i])) {
                        $requestedQuarter = $quarters[$i--];
                        $qtrIndex = $i--;
                        break;
                    }
                }
                break;
            case 'next' : 
                for ($i = 0; $i < count($quarters); $i++) {
                    if (in_array($currentMonth, $quarters[$i])) {
                        $requestedQuarter = $quarters[$i++];
                        $qtrIndex = 1 + $i++;
                        break;
                    }
                }
                break;
            case 'last' : 
                $requestedQuarter = end($quarters);
                $qtrIndex = count($quarters);
                break;
            default :
        }
        
//        $quarterDictionary = array(
//            '1' => 'First',
//            '2' => 'Second',
//            '3' => 'Third',
//            '4' => 'Last'
//        );
//        
//        $whatQuarter = $quarterDictionary[$qtrIndex];
        $firstMonthInQuarter = $requestedQuarter[0];
        $lastMonthInQuarter = end($requestedQuarter);
        $lastMonthEnd = self::getNumberOfDaysInMonth($lastMonthInQuarter);
        $qStart = date('Y-m-d', strtotime($year . '-' . $firstMonthInQuarter . '-01'));
        $qEnd = date('Y-m-d', strtotime($year . '-' . $lastMonthInQuarter . '-' . $lastMonthEnd));
        
        $thisQuarter = $qStart . '|' . $qEnd;
        
        return $thisQuarter;
    }
    
    public static function whatQuarterIsIt()
    {
        $quarters = array_chunk(self::$_monthNames, 3);
        $currentMonth = date('F');
        $requestedQuarter = '';
        $qtrIndex = 0;
        for ($i = 0; $i < count($quarters); $i++) {
            if (in_array($currentMonth, $quarters[$i])) {
                $requestedQuarter = $quarters[$i];
                $qtrIndex = $i++;
                break;
            }
        }
    }
}
