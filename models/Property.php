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
        $ids = [];
        foreach ($property->getAvailableValues() as $value) {
            if (!$propertyValue = PropertyValue::findOne(['accounting_id' => $value->id])) {
                $propertyValue = new PropertyValue();
                $ids[] = $propertyValue->accounting_id = (string)$value->ИдЗначения;
                $propertyValue->name = (string)$value->Значение;
                $propertyValue->property_id = $model->id;
                $propertyValue->save();
                unset($propertyValue);
            }
        }
        if ($ids) {
            PropertyValue::deleteAll(['and', ['property_id' => $model->id], ['not', ['accounting_id' => $ids]]]);
        }
        return $model;
    }
}
