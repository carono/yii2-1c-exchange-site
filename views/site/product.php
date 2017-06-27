<?php
use yii\widgets\ListView;

/**
 * @var \app\models\Group $group
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'product-item',
    'pager' => ['options' => ['class' => 'col-lg-12 pagination']],
]);