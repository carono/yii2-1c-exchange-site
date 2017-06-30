<?php

namespace app\models;

use app\components\Basket;
use carono\exchange1c\interfaces\GroupInterface;
use carono\exchange1c\interfaces\ProductInterface;
use Yii;
use \app\models\base\Offer as BaseOffer;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Group as MlGroup;
use \Zenwalker\CommerceML\Model\Offer as MlOffer;
use Zenwalker\CommerceML\Model\Price;
use Zenwalker\CommerceML\Model\Product as MlProduct;
use Zenwalker\CommerceML\Model\Property;
use Zenwalker\CommerceML\Model\Simple;

/**
 * This is the model class for table "offer".
 *
 * @property mixed count_in_basket
 * @property mixed sum_in_basket
 */
class Offer extends BaseOffer implements ProductInterface
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
     * Ассоциативный массив, где
     * Ключ - имя xml тега (import.xml > Каталог > Товары > Товар)
     * Значение - атрибут в модели
     * Например:
     * [
     *      'id'           => 'accounting_id',
     *      'Наименование' => 'title',
     *      'Количество'   => 'remnant',
     *      'Штрихкод'     => 'barcode'
     * ]
     *
     * @return array
     */
    public static function getFields1c()
    {
        // TODO: Implement getFields1c() method.
    }

    /**
     * Установка реквизитов, (import.xml > Каталог > Товары > Товар > ЗначенияРеквизитов > ЗначениеРеквизита)
     * $name - Наименование
     * $value - Значение
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function setRequisite1c($name, $value)
    {
        // TODO: Implement setRequisite1c() method.
    }

    /**
     * @param MlGroup $group
     * @return mixed
     */
    public function setGroup1c($group)
    {
        // TODO: Implement setGroup1c() method.
    }

    /**
     * Характеристики товара, (offers.xml > ПакетПредложений > Предложения > Предложение > ХарактеристикиТовара > ХарактеристикаТовара)
     * $name - Наименование
     * $value - Значение
     *
     * @param MlOffer $offer
     * @param Simple $specification
     * @return void
     */
    public function setSpecification1c($offer, $specification)
    {
        // TODO: Implement setSpecification1c() method.
    }

    /**
     * $property - Свойство товара (import.xml > Классификатор > Свойства > Свойство)
     * $property->value - Разыменованное значение (string) (import.xml > Классификатор > Свойства > Свойство > Значение)
     * $property->getValueModel() - Данные по значению, Ид значения, и т.д (import.xml > Классификатор > Свойства > Свойство > ВариантыЗначений > Справочник)
     *
     * @param Property $property
     * @return void
     */
    public function setProperty1c($property)
    {
        // TODO: Implement setProperty1c() method.
    }

    /**
     * Цена товара, (offers.xml > ПакетПредложений > Предложения > Предложение > Цены)
     * К $price можно обратиться как к массиву, чтобы получить список цен (Цены > Цена)
     * $price->type - тип цены (offers.xml > ПакетПредложений > ТипыЦен > ТипЦены)
     *
     * @param MlOffer $offer
     * @param Price $price
     * @return void
     */
    public function setPrice1c($offer, $price)
    {
        // TODO: Implement setPrice1c() method.
    }

    /**
     * @param string $path
     * @param string $caption
     * @return mixed
     */
    public function addImage1c($path, $caption)
    {
        // TODO: Implement addImage1c() method.
    }

    public function getRequisite1c($name)
    {
        // TODO: Implement getRequisite1c() method.
    }

    public function getRequisites1c()
    {
        // TODO: Implement getRequisites1c() method.
    }

    public function getCategory1c($id)
    {
        // TODO: Implement getCategory1c() method.
    }

    public function getProperty1c($id)
    {
        // TODO: Implement getProperty1c() method.
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
                    'Код' => "796",
                    'НаименованиеПолное' => "Штука",
                    'МеждународноеСокращение' => "PCE"
                ]
            ]
        ];
    }
}
