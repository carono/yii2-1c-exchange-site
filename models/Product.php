<?php

namespace app\models;

use carono\exchange1c\interfaces\GroupInterface;
use carono\exchange1c\interfaces\ProductInterface;
use carono\yii2installer\traits\PivotTrait;
use Yii;
use \app\models\base\Product as BaseProduct;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Group as MlGroup;
use Zenwalker\CommerceML\Model\Offer as MlOffer;
use Zenwalker\CommerceML\Model\Price as MlPrice;
use Zenwalker\CommerceML\Model\Property as MlProperty;
use Zenwalker\CommerceML\Model\PropertyCollection;
use Zenwalker\CommerceML\Model\Simple;

/**
 * This is the model class for table "product".
 */
class Product extends BaseProduct implements ProductInterface
{
    use PivotTrait;

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
        if (!$requisite = Requisite::findOne(['name' => $name])) {
            $requisite = new Requisite();
            $requisite->name = $name;
            $requisite->save();
        };
        $pv = $this->addPivot($requisite, PvProductRequisite::className());
        $pv->updateAttributes(['value' => $value]);
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
     * @param MlProperty $property
     * @return void
     */
    public function setProperty1c($property)
    {
        $propertyModel = Property::createByMl($property);
        $pv = $this->addPivot($propertyModel, PvProductProperty::className());
        if ($value = PropertyValue::findOne(['accounting_id' => (string)$property->getValueModel()->ИдЗначения])) {
            $pv->updateAttributes(['property_value_id' => $value->id]);
            unset($pv);
        }
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
        $offerModel = Offer::createByMl($offer);
        $offerModel->updateAttributes([
            'product_id' => $this->id,
            'remnant' => (string)$offer->Количество
        ]);
        $priceType = PriceType::createByMl($price->getType());
        $priceModel = Price::createByMl($price, $offerModel, $priceType);
        $offerModel->addPivot($priceModel, PvOfferPrice::className());
    }

    /**
     * @param string $path
     * @param string $caption
     * @return mixed
     */
    public function addImage1c($path, $caption)
    {
        if (!$this->getImages()->andWhere(['size' => filesize($path)])->exists()) {
            $this->addPivot(FileUpload::upload($path), PvProductImage::className());
        }
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
        if ($this->images) {
            return $this->images[0]->getImageUrl();
        } else {
            return '/images/product.png';
        }
    }

    /**
     * @param PropertyCollection $properties
     * @return mixed
     */
    public static function createProperties1c($properties)
    {
        /**
         * @var \Zenwalker\CommerceML\Model\Property $property
         */
        foreach ($properties as $property) {
            $propertyModel = Property::createByMl($property);
            foreach ($property->getAvailableValues() as $value) {
                if (!$propertyValue = PropertyValue::findOne(['accounting_id' => $value->id])) {
                    $propertyValue = new PropertyValue();
                    $ids[] = $propertyValue->accounting_id = (string)$value->ИдЗначения;
                    $propertyValue->name = (string)$value->Значение;
                    $propertyValue->property_id = $propertyModel->id;
                    $propertyValue->save();
                    unset($propertyValue);
                }
            }
        }
    }
}
