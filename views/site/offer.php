<?php

use app\models\Offer;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\widgets\Carousel;
use yii\data\ArrayDataProvider;
/**
 * @var Offer $offer
 */
$dataProvider = new ArrayDataProvider(['allModels' => $offer->product->getImages()->all()]);
echo Carousel::widget(['dataProvider' => $dataProvider]);

?>

<?= Html::a('Положить в корзину', $offer->getUrl('put-to-basket'), ['class' => 'btn btn-success']) ?>
    <div class="row">
        <div class="col-lg-6">
            <h2>Значения продукта</h2>
            <?php

            echo DetailView::widget([
                'model' => $offer->product,
                'attributes' => [
                    'name',
                    'article',
                    'description',
                ],
            ]);
            ?>
        </div>

        <div class="col-lg-6">
            <h2>Значения предложения</h2>
            <?php

            echo DetailView::widget([
                'model' => $offer,
                'attributes' => [
                    'name',
                    'remnant',
                ],
            ]);
            ?>
        </div>
    </div>
    <h2>Цены предложения</h2>
<?php
echo GridView::widget([
    'dataProvider' => $offer->getPrices()->joinWith(['type'])->search(),
    'columns' => [
        'type.name',
        'performance',
        'currency',
        'rate',
        [
            'attribute' => 'value',
            'value' => function ($price) {
                return Yii::$app->formatter->asCurrency($price->value, $price->currency);
            }
        ]
    ]
]);

?>
    <div class="row">
        <div class="col-lg-6">
            <h2>Реквизиты продукта</h2>
            <?php
            $dataProvider = $offer->product->getPvProductRequisites()->search();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'requisite.name',
                    'value',
                ],
            ]);
            ?>
        </div>

        <div class="col-lg-6">
            <h2>Свойства продукта</h2>
            <?php
            $dataProvider = $offer->product->getPvProductProperties()->joinWith(['propertyValue.property'])->search();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'property.name',
                    'public_value',
                ],
            ]);
            ?>
        </div>
    </div>
    <h2>Характеристики предложения</h2>
<?php
$dataProvider = $offer->getPvOfferSpecifications()->joinWith(['specification'])->search();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'specification.name',
        'value',
    ],
]);