<?php

namespace app\models;

use Yii;
use \app\models\base\Specification as BaseSpecification;

/**
 * This is the model class for table "specification".
 */
class Specification extends BaseSpecification
{
    public static function createByMl($specification)
    {
        if (!$specificationModel = self::findOne(['accounting_id' => $specification->id])) {
            $specificationModel = new self;
            $specificationModel->name = $specification->name;
            $specificationModel->accounting_id = $specification->id;
            $specificationModel->save();
        }
        return $specificationModel;
    }
}
