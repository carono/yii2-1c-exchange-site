<?php

namespace app\models;

use carono\yii2installer\traits\PivotTrait;
use Yii;
use \app\models\base\Order as BaseOrder;

/**
 * This is the model class for table "order".
 */
class Order extends BaseOrder
{
    use PivotTrait;
}
