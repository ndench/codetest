<?php

/* @var $this yii\web\View */

use app\models\RaffleDraw;
use app\models\RaffleOffer;
use app\models\RafflePrize;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $draw RaffleDraw */
$prize = $draw->getPrize();
$offers = $draw->getOffers();

$this->title = 'Raffle Draws';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $draw->getName() ?></h1>

        <p class="lead"><?= $draw->getDescription() ?></p>
        <p><?= \yii\helpers\Html::img($prize->getImage(), ['alt' => 'Prize Image Not Found']) ?></p>

        <p><small>View the <?= \yii\helpers\Html::a('terms & conditions', $draw->getTermsUrl()) ?></small></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h2>Lottery Detail</h2>

                <?php
                echo DetailView::widget([
                    'model' => $draw,
                    'attributes' => [
                        [
                            'attribute' => 'name',
                            'value' => $draw->getName(),
                        ],
                        [
                            'attribute' => 'description',
                            'value' => $draw->getDescription(),
                        ],
                        [
                            'attribute' => 'number',
                            'value' => $draw->getNumber(),
                        ],
                        [
                            'attribute' => 'drawStarts',
                            'value' => $draw->getStart(),
                            'format' => 'datetime',
                        ],
                        [
                            'attribute' => 'drawEnds',
                            'value' => $draw->getEnd(),
                            'format' => 'datetime',
                        ],
                        [
                            'attribute' => 'Terms',
                            'value' => $draw->getTermsUrl(),
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h2>Prize Detail</h2>
                <small>What we're all here for</small>

                <?php
                echo DetailView::widget([
                    'model' => $prize,
                    'attributes' => [
                        [
                            'attribute' => 'cardTitle',
                            'value' => $prize->getCardTitle(),
                        ],
                        [
                            'attribute' => 'name',
                            'value' => $prize->getName(),
                        ],
                        [
                            'attribute' => 'description',
                            'value' => $prize->getDescription(),
                        ],
                        [
                            'attribute' => 'valueIsExact',
                            'value' => function (RafflePrize $model) {
                                if ($model->isExact()) {
                                    return \yii\bootstrap\Html::icon('ok', ['style' => 'color:green']);
                                }

                                return \yii\bootstrap\Html::icon('remove', ['style' => 'color:red']);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'image',
                            'value' => $prize->getImage(),
                        ],
                        [
                            'attribute' => 'value',
                            'value' => $prize->getValue(),
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h2>Buy Some Tickets!</h2>
                <small>Help out a charity and feel good about yourself while you do it!</small>

                <?php
                $offerDataProvider = new ArrayDataProvider([
                    'allModels' => array_map(function (RaffleOffer $offer) {
                        return $offer->toArray();
                    }, $offers),
                ]);
                echo \yii\grid\GridView::widget([
                    'dataProvider' => $offerDataProvider,
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        switch ($model['ribbon']) {
                            case 'most_popular':
                                return [
                                    'style'          => 'background-color: #fcf8e3 !important',
                                    'title'          => 'Most Popular!',
                                    'data-toggle'    => 'tooltip',
                                    'data-placement' => 'top',
                                ];
                                break;
                            case 'our_pick':
                                return [
                                    'style'          => 'background-color: #d9edf7 !important',
                                    'title'          => 'Our Pick!',
                                    'data-toggle'    => 'tooltip',
                                    'data-placement' => 'top',
                                ];
                                break;
                            case 'best_value':
                                return [
                                    'style'          => 'background-color: #dff0d8 !important',
                                    'title'          => 'Best Value!',
                                    'data-toggle'    => 'tooltip',
                                    'data-placement' => 'top',
                                ];
                                break;
                        }

                        return [];
                    },
                    'columns' => [
                        'name',
                        'numTickets',
                        'price',
                        [
                            'value' => function () {
                                return \yii\helpers\Html::a('Purchase', null, ['class' => 'btn btn-xs btn-success']);
                            },
                            'format' => 'raw',
                        ]
                    ]
                ])
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(
    "$('[data-toggle=\"tooltip\"]').tooltip()",
    View::POS_READY
);
?>
