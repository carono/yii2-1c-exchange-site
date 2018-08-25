<?php

namespace app\models;

use app\models\base\PriceType as BasePriceType;
use Zenwalker\CommerceML\Model\Simple;

/**
 * This is the model class for table "price_type".
 */
class PriceType extends BasePriceType
{
    /**
     * @param Simple $type
     * @return PriceType
     */
    public static function createByMl($type)
    {
        if (!$priceType = self::findOne(['accounting_id' => $type->id])) {
            $priceType = new self;
            $priceType->accounting_id = $type->id;
        }
        $priceType->name = $type->name;
        $priceType->currency = (string)$type->Валюта;
        if ($priceType->getDirtyAttributes()) {
            $priceType->save();
        }
        return $priceType;
    }
}
