<?php

namespace app\controllers;

use app\api\LotteryClient;
use app\models\RaffleTicket;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
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
        /** @var LotteryClient $client */
        $client = Yii::$app->lotteryClient;

        $tickets = $client->getRaffleTickets();
        $ticketArray = array_map(
            function (RaffleTicket $ticket) {
                return $ticket->toArray();
            },
            $tickets
        );

        return $this->render('index', [
            'raffles'   => $ticketArray,
            'lotteries' => [],
        ]);
    }

    public function actionLotteries($id)
    {
        /** @var LotteryClient $client */
        $client = Yii::$app->lotteryClient;

        $lottery = $client->getLotteryById($id);

        return $this->render('lotteries', [
            'lottery' => $lottery,
        ]);
    }

    public function actionDraws($number)
    {
        /** @var LotteryClient $client */
        $client = Yii::$app->lotteryClient;

        $draw = $client->getDrawByNumber($number);

        return $this->render('draws', [
            'draw' => $draw,
        ]);
    }
}
