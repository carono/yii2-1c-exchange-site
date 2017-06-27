<?php
use yii\helpers\Html;

/**
 * @var \app\models\Offer $model
 */

?>

<a href="/site/offer?id=<?= $model->id ?>">
    <div class="col-lg-3 product-thumb">
        <?= Html::img($model->product->getImageUrl()) ?>
        <div><?= Yii::$app->formatter->asCurrency($model->price->value, $model->price->currency) ?></div>
        <div><?= $model->product->name ?></div>
    </div>
</a>
