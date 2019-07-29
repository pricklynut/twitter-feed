<?php

namespace app\controllers;
use app\models\SubscribedUser;

/**
 * Class FeedController
 */
class FeedController extends AbstractController
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $params = \Yii::$app->request->queryParams;
        if (empty($params['id'])) {
            $this->setError('missing parameter', 400);
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        $url = \Yii::$app->params['twitterApi']['timeline_url'];
        $users = SubscribedUser::find()->all();
        $result = ['feed' => []];

        foreach ($users as $user) {
            /** @var SubscribedUser $user */
            $getfield = "?screen_name={$user->twitter_username}";
            $userTweets = json_decode(
                \Yii::$app->twitterApi
                    ->setGetfield($getfield)
                    ->buildOauth($url, 'GET')
                    ->performRequest(),
                true
            );
            $lastId = $user->last_tweet_id;

            if ($userTweets && is_array($userTweets)) {
                foreach ($userTweets as $tweet) {
                    if ($lastId < $tweet['id']) {
                        $result['feed'][] = [
                            'user' => $tweet['user']['name'],
                            'tweet' => $tweet['text'],
                            'hashtag' => $tweet['entities']['hashtags'],
                        ];
                    }
                    $lastId = $tweet['id'] > $lastId ? $tweet['id'] : $lastId;
                }
                if ($lastId) {
                    $user->last_tweet_id = $lastId;
                    $user->update(true, ['last_tweet_id']);
                }
            }
        }

        \Yii::$app->response->data = $result;
    }
}
