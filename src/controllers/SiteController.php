<?php

namespace app\controllers;

use app\models\ApiResult;
use app\serializer\handler\LotteryApiResultHandler;
use GuzzleHttp\Client;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Serializer;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $apiUrl = Yii::$app->params['lotteryApi'];
        $guzzle = new Client();
        $res = $guzzle->get($apiUrl);
        $body = $res->getBody()->getContents();

        /** @var \krtv\yii2\serializer\Serializer $serializer */
        $serializer = Yii::$app->serializer;
        $shit = $serializer->deserialize($body, LotteryApiResultHandler::TYPE, 'json');
        return $this->render('index', [
            'data' => $shit,
        ]);
    }
}
