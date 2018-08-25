<?php

namespace app\models;

use Yii;
use \app\models\base\PvProductProperty as BasePvProductProperty;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pv_product_properties".
 */
class PvProductProperty extends BasePvProductProperty
{
    public function getPublic_value()
    {
        return $this->value ?: ArrayHelper::getValue($this->propertyValue, 'name');
    }
}
