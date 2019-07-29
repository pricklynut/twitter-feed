<?php

namespace app\controllers;

use app\models\SubscribedUser;
use yii\log\Logger;

/**
 * Class UserController
 */
class UserController extends AbstractController
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $params = \Yii::$app->request->queryParams;
        if (empty($params['id']) || empty($params['user'])) {
            $this->setError('missing parameter', 400);
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Add new user
     */
    public function actionAdd()
    {
        try {
            $alreadyExists = SubscribedUser::findOne([
                'twitter_username' => \Yii::$app->request->get('user')
            ]);
            if (!$alreadyExists) {
                $newUser = new SubscribedUser();
                $newUser->twitter_username = \Yii::$app->request->get('user');
                $newUser->save();
            }
        } catch (\Exception $exception) {
            $this->setError('internal error', 500);
            \Yii::getLogger()->log(
                $exception->__toString(),
                Logger::LEVEL_ERROR
            );
        }
    }

    /**
     * Remove user
     */
    public function actionRemove()
    {
        try {
            $user = SubscribedUser::findOne([
                'twitter_username' => \Yii::$app->request->get('user')
            ]);
            if ($user) {
                $user->delete();
            }
        } catch (\Exception $exception) {
            $this->setError('internal error', 500);
            \Yii::getLogger()->log(
                $exception->__toString(),
                Logger::LEVEL_ERROR
            );
        }
    }
}
