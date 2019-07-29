<?php

namespace app\components;

/**
 * Class TwitterApiExchange
 * Mock that returns expected result
 */
class TwitterApiExchange extends \TwitterAPIExchange
{
    public $oauth_access_token;
    public $oauth_access_token_secret;
    public $consumer_key;
    public $consumer_secret;

    /**
     * TwitterApiExchange constructor.
     */
    public function __construct()
    {
    }
}
