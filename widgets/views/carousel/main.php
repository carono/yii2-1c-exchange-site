<?php

use yii\helpers\Html;

/**
 * @var \yii\base\Widget $this
 * @var \app\models\FileUpload[] $images
 */
$id = $this->context->id;
$result = [];
foreach ($images as $image) {
    $result[] = $image->getImageUrl();
}
if (!$result) {
    $result[] = '/images/product.png';
}

?>
<div id="<?= $id ?>" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        foreach ($images as $i => $image) {
            $options = ['data-target' => "#{$id}", 'data-slide-to' => $i];
            if (!$i) {
                Html::addCssClass($options, 'active');
            }
            echo Html::tag('li', '', $options);
        }
        ?>
    </ol>
    <div class="carousel-inner">
        <?php
        foreach ($result as $i => $url) {
            $img = Html::img($url, ['class' => 'offer-image']);
            $options = ['class' => 'item'];
            if (!$i) {
                Html::addCssClass($options, 'active');
            }
            echo Html::tag('div', $img, $options);
        }
        ?>
    </div>
    <a class="carousel-control left" href="#<?= $id ?>" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="carousel-control right" href="#<?= $id ?>" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>