<?php

/* @var $this yii\web\View */

use app\models\Lottery;
use yii\widgets\DetailView;

/* @var $lottery Lottery */

$this->title = 'Lottery Draws';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $lottery->getName() ?></h1>

        <p class="lead"><?= $lottery->getDescription() ?></p>
        <p><?= \yii\helpers\Html::img($lottery->getIconUrl(), ['alt' => 'Lottery Icon Not Found']) ?></p>

        <p><?= \yii\helpers\Html::a('Play', $lottery->getPlayUrl(), ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h2>Lottery Detail</h2>

                <?php
                echo DetailView::widget([
                    'model' => $lottery,
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'value' => $lottery->getId(),
                        ],
                        [
                            'attribute' => 'name',
                            'value' => $lottery->getName(),
                        ],
                        [
                            'attribute' => 'description',
                            'value' => $lottery->getDescription(),
                        ],
                        [
                            'attribute' => 'multiDraw',
                            'value' => function (Lottery $model) {
                                if ($model->isMultidraw()) {
                                    return \yii\bootstrap\Html::icon('ok', ['style' => 'color:green']);
                                }

                                return \yii\bootstrap\Html::icon('remove', ['style' => 'color:red']);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'type',
                            'value' => $lottery->getType(),
                        ],
                        [
                            'attribute' => 'icon',
                            'value' => $lottery->getIconUrl(),
                        ],
                        [
                            'attribute' => 'play',
                            'value' => $lottery->getPlayUrl(),
                        ],
                        [
                            'attribute' => 'lotteryId',
                            'value' => $lottery->getLotteryId(),
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>
</div>
