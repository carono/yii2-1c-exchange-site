<?php
use app\models\Offer;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Offer $offer
 */
echo Html::tag('div', Html::img($offer->product->getImageUrl(), ['class' => 'offer-image']), ['class' => 'text-center']);
echo DetailView::widget([
    'model' => $offer,
    'attributes' => [
        'name',
        'product.article',
        [
            'attribute' => 'price.value',
            'format' => ['currency', $offer->price->currency],
        ],
        'product.description',
    ],
]);

