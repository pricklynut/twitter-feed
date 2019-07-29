<?php

namespace app\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Class AbstractController
 * @package app\controllers
 */
abstract class AbstractController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!$this->validateSecret(\Yii::$app->request->queryParams)) {
            $this->setError('access denied', 403);
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @param $params
     * @return bool
     */
    protected function validateSecret($params)
    {
        $secret = null;
        if (isset($params['secret'])) {
            $secret = $params['secret'];
            unset($params['secret']);
        }
        return !empty($secret) && $secret === sha1(implode('', $params));
    }

    /**
     * @param string $error
     * @param int $statusCode
     */
    protected function setError($error, $statusCode = 400)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->statusCode = $statusCode;
        \Yii::$app->response->data = ['error' => $error];
    }
}
