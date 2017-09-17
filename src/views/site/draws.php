<?php

/* @var $this yii\web\View */

use app\models\RaffleDraw;
use app\models\RafflePrize;
use yii\widgets\DetailView;

/* @var $draw RaffleDraw */
$prize = $draw->getPrize();

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
    </div>
</div>
