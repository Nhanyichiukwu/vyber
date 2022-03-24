<?php


namespace App\Utility;


class ServiceMessages
{
    private static $_MESSAGES = [
        'missing_page' => "Oops! We searched everywhere but could not ' .
            'find the page you're looking for.",
        'invalid_request' => '',
        'unknown_user' => '',
        'missing_record' => '',
        ''
    ];

    public static $missingPage = '';

    public static $wrongTurn;

    /**
     * ErrorMessages constructor.
     * @param $getMissingPageMessage
     */
    public function __construct($getMissingPageMessage)
    {
    }

    public static function getMissingPageMessage()
    {
        return self::$_MESSAGES['missing_page'];
    }
}
