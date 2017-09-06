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
     * @param Offer $offer
     * @param PriceType $type
     * @return Price
     */
    public static function createByMl($price, $offer, $type)
    {
        if (!$priceModel = $offer->getPrices()->andWhere(['type_id' => $type->id])->one()) {
            $priceModel = new self();
        }
        $priceModel->value = $price->cost;
        $priceModel->performance = $price->performance;
        $priceModel->currency = $price->currency;
        $priceModel->rate = $price->rate;
        $priceModel->type_id = $type->id;
        $priceModel->save();
        return $priceModel;
    }
}
