<?php

namespace app\models;

use carono\exchange1c\interfaces\GroupInterface;
use carono\exchange1c\interfaces\ProductInterface;
use Yii;
use \app\models\base\Product as BaseProduct;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Group as MlGroup;
use Zenwalker\CommerceML\Model\Offer as MlOffer;
use Zenwalker\CommerceML\Model\Price as MlPrice;
use Zenwalker\CommerceML\Model\Property as MlProperty;
use Zenwalker\CommerceML\Model\Simple;

/**
 * This is the model class for table "product".
 */
class Product extends BaseProduct implements ProductInterface
{
    /**
     * Если по каким то причинам файлы import.xml или offers.xml были модифицированы и какие то данные
     * не попадают в парсер, в самом конце вызывается данный метод, в $product и $cml можно получить все
     * возможные данные для ручного парсинга
     *
     * @param CommerceML $cml
     * @param \Zenwalker\CommerceML\Model\Product $product
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
        return [
            'id' => 'accounting_id',
            'Наименование' => 'name',
            'Описание' => 'description',
            'Артикул' => 'article',
        ];
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
        $this->updateAttributes(['group_id' => Group::createByML($group)->id]);
    }

    /**
     * Характеристики товара, (offers.xml > ПакетПредложений > Предложения > Предложение > ХарактеристикиТовара > ХарактеристикаТовара)
     * $name - Наименование
     * $value - Значение
     *
     * @param Offer $offer
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
     * @param MlPrice $price
     * @return void
     */
    public function setPrice1c($offer, $price)
    {
        $priceType = PriceType::createByMl($price->getType());
        $offerModel = Offer::createByMl($offer);
        $priceModel = Price::createByMl($price);
        $priceModel->updateAttributes(['type_id' => $priceType->id]);
        $offerModel->updateAttributes(['product_id' => $this->id, 'price_id' => $priceModel->id]);
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
        // TODO: Implement getGroup1c() method.
    }

    public function getExportFields1c($context = null)
    {
        // TODO: Implement getExportFields1c() method.
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getImageUrl()
    {
        return '/images/product.png';
    }
}
