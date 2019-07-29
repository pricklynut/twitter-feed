<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class SubscribedUser
 * @property integer $id
 * @property string $twitter_username
 * @property integer $last_tweet_id
 */
class SubscribedUser extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'subscribed_users';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['twitter_username'], 'string'],
            [['id'], 'integer'],
            [['last_tweet_id'], 'number'],
        ];
    }
}
