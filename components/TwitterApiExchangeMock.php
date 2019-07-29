<?php

namespace app\components;

/**
 * Class TwitterApiExchangeMock
 */
class TwitterApiExchangeMock extends TwitterApiExchange
{
    /**
     * @param bool $return
     * @param array $curlOptions
     * @return bool|string
     */
    public function performRequest($return = true, $curlOptions = array())
    {
        return file_get_contents(
            \Yii::getAlias('@app/config/twitter_fixtures.txt')
        );
    }
}
