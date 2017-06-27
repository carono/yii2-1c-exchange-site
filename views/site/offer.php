<?php
use app\models\Offer;
use yii\helpers\Html;
use yii\widgets\DetailView;

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

<?php
//echo Html::tag('div', Html::img($offer->product->getImageUrl(), ['class' => 'offer-image']), ['class' => 'text-center']);
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

