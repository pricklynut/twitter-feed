<?php

use yii\db\Migration;

/**
 * Class m190728_165414_create_table_subscribed_users
 */
class m190728_165414_create_table_subscribed_users extends Migration
{
    const TABLE_NAME = 'subscribed_users';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'twitter_username' => $this->string(50)->notNull(),
            'last_tweet_id' => $this->string(),
        ]);

        $this->createIndex(
            'ix_twitter_username',
            self::TABLE_NAME,
            'twitter_username',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
