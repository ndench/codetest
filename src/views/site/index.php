<?php

/* @var $this yii\web\View */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Lottery Draws';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Your Lottery Draws!</h1>

        <p class="lead">Here are the greatest lotteries available. Customised specifically for you!</p>
    </div>

    <div class="body-content">

        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#raffles-tab" role="tab" data-toggle="tab">Raffles</a></li>
                <li role="presentation"><a href="#lotteries-tab" role="tab" data-toggle="tab">Lotteries</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="raffles-tab" role="tabpanel">
                    <?php
                    $raffleDataProvider = new ArrayDataProvider([
                        'allModels' => $raffles,
                    ]);
                    echo GridView::widget([
                        'dataProvider' => $raffleDataProvider,
                        'columns' => [
                            'name',
                            'autoPlayable',
                            [
                                'attribute' => 'lottery',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::a(Html::encode($model['lottery']['name']), [
                                        'site/lotteries',
                                        'id' => Html::encode($model['lottery']['id'])
                                    ]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'draw',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::a(Html::encode($model['draw']['name']), [
                                        'site/draws',
                                        'number' => Html::encode($model['draw']['number'])
                                    ]);
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ])
                    ?>
                </div>

                <div class="tab-pane" id="lotteries-tab" role="tabpanel">
                    <?php
                    $lotteryDataProvider = new ArrayDataProvider([
                        'allModels' => $lotteries,
                    ]);
                    echo GridView::widget([
                        'dataProvider' => $lotteryDataProvider,
                        'columns' => [
                            'name',
                            'autoplayable',
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
