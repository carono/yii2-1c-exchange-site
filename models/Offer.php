<?php

namespace app\models;

use Yii;
use \app\models\base\Offer as BaseOffer;
use \Zenwalker\CommerceML\Model\Offer as MlOffer;

/**
 * This is the model class for table "offer".
 */
class Offer extends BaseOffer
{
    /**
     * @param MlOffer $offer
     * @return Offer
     */
    public static function createByMl($offer)
    {
        if (!$offerModel = self::findOne(['accounting_id' => $offer->id])) {
            $offerModel = new self;
            $offerModel->name = $offer->name;
            $offerModel->accounting_id = $offer->id;
            $offerModel->remnant = $offer->Количество;
            $offerModel->save();
        }
        return $offerModel;
    }
}
