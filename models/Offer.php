<?php

namespace app\models;

use app\components\Basket;
use carono\exchange1c\interfaces\GroupInterface;
use carono\exchange1c\interfaces\OfferInterface;
use carono\yii2migrate\traits\PivotTrait;
use Yii;
use \app\models\base\Offer as BaseOffer;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Zenwalker\CommerceML\CommerceML;
use \Zenwalker\CommerceML\Model\Offer as MlOffer;
use Zenwalker\CommerceML\Model\Product as MlProduct;

/**
 * This is the model class for table "offer".
 *
 * @property mixed count_in_basket
 * @property mixed sum_in_basket
 */
class Offer extends BaseOffer implements OfferInterface
{
    use PivotTrait;

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
            $offerModel->name = (string)$offer->name;
            $offerModel->accounting_id = (string)$offer->id;
        }
        $offerModel->remnant = (string)$offer->Количество;
        return $offerModel;
    }

    public static function getFields1c()
    {
        return [
            'Наименование' => 'name',
            'Описание' => 'description',
        ];
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

    /**
     * Если по каким то причинам файлы import.xml или offers.xml были модифицированы и какие то данные
     * не попадают в парсер, в самом конце вызывается данный метод, в $product и $cml можно получить все
     * возможные данные для ручного парсинга
     *
     * @param CommerceML $cml
     * @param MlProduct $product
     * @return void
     */
    public function setRaw1cData($cml, $product)
    {
        // TODO: Implement setRaw1cData() method.
    }

    /**
     * @return GroupInterface
     */
    public function getGroup1c()
    {
        return $this->product->group;
    }

    public function getExportFields1c($context = null)
    {
        /**
         * @var Order $context
         */
        $pv = PvOrderOffer::find()->andWhere(['offer_id' => $this->id, 'order_id' => $context->id])->one();
        return [
            'Ид' => $this->accounting_id,
            'Наименование' => $this->name,
            'ЦенаЗаЕдиницу' => $this->getMainPrice()->value,
            'Сумма' => function (self $model) use ($pv) {
                return ArrayHelper::getValue($pv, 'sum');
            },
            'Количество' => function (self $model) use ($pv) {
                return ArrayHelper::getValue($pv, 'count');
            },
            'БазоваяЕдиница' => [
                '@content' => 'шт',
                '@attributes' => [
                    'Код' => '796',
                    'НаименованиеПолное' => 'Штука',
                    'МеждународноеСокращение' => 'PCE'
                ]
            ]
        ];
    }

    /**
     * offers.xml > ПакетПредложений > Предложения > Предложение > Цены
     *
     * Цена товара,
     * К $price можно обратиться как к массиву, чтобы получить список цен (Цены > Цена)
     * $price->type - тип цены (offers.xml > ПакетПредложений > ТипыЦен > ТипЦены)
     *
     * @param \Zenwalker\CommerceML\Model\Price $price
     * @return void
     */
    public function setPrice1c($price)
    {
        $priceType = PriceType::findOne(['accounting_id' => $price->getType()->id]);
        $priceModel = Price::createByMl($price, $this, $priceType);
        $this->addPivot($priceModel, PvOfferPrice::class);
    }

    /**
     * @param $types
     * @return void
     */
    public static function createPriceTypes1c($types)
    {
        foreach ($types as $type) {
            PriceType::createByMl($type);
        }
    }


    /**
     * offers.xml > ПакетПредложений > Предложения > Предложение > ХарактеристикиТовара > ХарактеристикаТовара
     *
     * Характеристики товара
     * $name - Наименование
     * $value - Значение
     *
     * @param \Zenwalker\CommerceML\Model\Simple $specification
     * @return void
     */
    public function setSpecification1c($specification)
    {
        $specificationModel = Specification::createByMl($specification);
        $this->addPivot($specificationModel, PvOfferSpecification::class, ['value' => (string)$specification->Значение]);
    }

    /**
     * Возвращаем имя поля в базе данных, в котором хранится ID из 1с
     *
     * @return string
     */
    public static function getIdFieldName1c()
    {
        return 'accounting_id';
    }
}
