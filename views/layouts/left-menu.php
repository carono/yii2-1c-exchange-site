<?php
use yii\widgets\Menu;
use app\models\Group;

echo Menu::widget(['items' => Group::formMenuItems()]);