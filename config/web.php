<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::class,
                    'pluralize' => false,
                    'controller' => 'feed',
                ],
                'GET /add' => 'user/add',
                'GET /remove' => 'user/remove',
            ],
        ],
        'twitterApi' => [
            'class' => '\app\components\TwitterApiExchangeMock',
            'oauth_access_token' => $params['twitterApi']['oauth_access_token'],
            'oauth_access_token_secret' => $params['twitterApi']['oauth_access_token_secret'],
            'consumer_key' => $params['twitterApi']['consumer_key'],
            'consumer_secret' => $params['twitterApi']['consumer_secret'],
        ],
    ],
    'params' => $params,
];

return $config;
