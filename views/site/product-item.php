<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var \app\models\Offer $model
 */
$price = ArrayHelper::getValue($model->prices, 0);

?>

<a href="/site/offer?id=<?= $model->id ?>">
    <div class="col-lg-3 product-thumb">
        <?= Html::img($model->product->getImageUrl()) ?>
        <?php if ($price) { ?>
            <div><?= Yii::$app->formatter->asCurrency($price->value, $price->currency) ?></div>
        <?php } ?>
        <div><?= $model->product->name ?></div>
    </div>
</a>
