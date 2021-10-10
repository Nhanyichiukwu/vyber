<?php


namespace App\Utility;


class CustomMessages
{
    private static $_MESSAGES = [
        'missing_page' => "Oops! We searched everywhere but could not ' .
            'find the page you're looking for.",
        'invalid_request' => '',
        'unknown_user' => '',
        'missing_record' => '',
        ''
    ];

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
