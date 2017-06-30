<?php
use app\models\Offer;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * @var Offer $offer
 */

?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <?php
            foreach ($offer->product->images as $i => $image) {
                $options = ['data-target' => "#myCarousel", 'data-slide-to' => $i];
                if (!$i) {
                    Html::addCssClass($options, 'active');
                }
                echo Html::tag('li', '', $options);
            }
            ?>
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <?php
            foreach ($offer->product->images as $i => $image) {
                $img = Html::img($image->getImageUrl(), ['class' => 'offer-image']);
                $options = ['class' => 'item'];
                if (!$i) {
                    Html::addCssClass($options, 'active');
                }
                echo Html::tag('div', $img, $options);
            }
            ?>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

<?= Html::a('Положить в корзину', $offer->getUrl('put-to-basket'), ['class' => 'btn btn-success']) ?>

    <h2>Значения товара</h2>
<?php
$price = ArrayHelper::getValue($offer->prices, 0);

echo DetailView::widget([
    'model' => $offer,
    'attributes' => [
        'name',
        'product.article',
        [
            'attribute' => 'price',
            'format' => ['currency', $price->currency],
            'value' => $price->value
        ],
        'remnant',
        'product.description',
    ],
]);
?>
    <h2>Реквизиты товара</h2>
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
    <h2>Свойства товара</h2>
<?php
$dataProvider = $offer->product->getPvProductProperties()->joinWith(['propertyValue.property'])->search();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'property.name',
        'propertyValue.name',
    ],
]);
?>