<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Offer;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                /**
                 * @var Offer $model
                 */
                return Html::a($model->name, $model->getUrl('view'));
            },
        ],
        'count_in_basket',
        [
            'attribute' => 'sum_in_basket',
            'format' => 'raw',
            'value' => function ($model) {
                /**
                 * @var Offer $model
                 */
                $price = $model->getMainPrice();
                return Yii::$app->formatter->asCurrency($model->sum_in_basket, $price->currency);
            }
        ],
    ]
]);
echo Html::a('Купить', ['/site/pay'], ['class' => 'btn btn-primary']);