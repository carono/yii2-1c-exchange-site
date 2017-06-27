<?php

namespace app\models;

use Yii;
use \app\models\base\Price as BasePrice;
use Zenwalker\CommerceML\Model\Price as MlPrice;

/**
 * This is the model class for table "price".
 */
class Price extends BasePrice
{
    /**
     * @param MlPrice $price
     * @return Price
     */
    public static function createByMl($price)
    {
        $priceModel = new self();
        $priceModel->value = $price->cost;
        $priceModel->performance = $price->performance;
        $priceModel->currency = $price->currency;
        $priceModel->rate = $price->rate;
        $priceModel->save();
        return $priceModel;
    }
}
