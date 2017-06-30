<?php

namespace app\models;

use app\components\Basket;
use Yii;
use \app\models\base\Offer as BaseOffer;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use \Zenwalker\CommerceML\Model\Offer as MlOffer;

/**
 * This is the model class for table "offer".
 *
 * @property mixed count_in_basket
 * @property mixed sum_in_basket
 */
class Offer extends BaseOffer
{
    public function getUrl($action, $asString = false)
    {
        $url = [];
        if ($action == 'put-to-basket') {
            $url = ['/site/put-to-basket', 'id' => $this->id];
        } elseif ($action == 'view') {
            $url = ['/site/offer', 'id' => $this->id];
        }
        return $asString ? Url::to($url, true) : $url;
    }

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

    public function getCount_in_basket()
    {
        return ArrayHelper::getValue(Basket::show(), $this->id, 0);
    }

    public function getSum_in_basket()
    {
        return $this->count_in_basket * $this->getMainPrice()->value;
    }


    public function getMainPrice()
    {
        return $this->prices[0];
    }
}
