<?php

namespace app\models;

use Yii;
use \app\models\base\Property as BaseProperty;
use Zenwalker\CommerceML\Model\Property as MlProperty;

/**
 * This is the model class for table "property".
 */
class Property extends BaseProperty
{
    public static function createByMl(MlProperty $property)
    {
        if (!$model = self::findOne(['accounting_id' => $property->id])) {
            $model = new self;
            $model->accounting_id = $property->id;
            $model->name = $property->name;
            $model->save();
        }
        return $model;
    }
}
