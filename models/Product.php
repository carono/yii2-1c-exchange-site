<?php

namespace app\models;

use carono\exchange1c\interfaces\GroupInterface;
use carono\exchange1c\interfaces\OfferInterface;
use carono\exchange1c\interfaces\ProductInterface;
use \app\models\base\Product as BaseProduct;
use carono\yii2migrate\traits\PivotTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Group as MlGroup;
use Zenwalker\CommerceML\Model\Property as MlProperty;
use Zenwalker\CommerceML\Model\PropertyCollection;

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
        }
        $this->addPivot($requisite, PvProductRequisite::class, ['value' => $value]);
    }

    /**
     * @param MlGroup $group
     * @return mixed
     */
    public function setGroup1c($group)
    {
        if ($group->id && ($id = Group::find()->select(['id'])->andWhere(['accounting_id' => $group->id])->scalar())) {
            $this->updateAttributes(['group_id' => $id]);
        }
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
        $propertyModel = Property::findOne(['accounting_id' => $property->id]);
        $propertyValue = $property->getValueModel();
        if ($propertyAccountingId = (string)$propertyValue->ИдЗначения) {
            $value = PropertyValue::findOne(['accounting_id' => $propertyAccountingId]);
            $attributes = ['property_value_id' => $value->id];
        } else {
            $attributes = ['value' => $propertyValue->value];
        }
        $this->addPivot($propertyModel, PvProductProperty::class, $attributes);
    }

    /**
     * @param string $path
     * @param string $caption
     * @return mixed
     */
    public function addImage1c($path, $caption)
    {
        if (!$this->getImages()->andWhere(['md5' => md5_file($path)])->exists()) {
            $this->addPivot(FileUpload::startUpload($path)->process(), PvProductImage::class);
        }
    }

    /**
     * @return GroupInterface
     */
    public function getGroup1c()
    {
        return $this->group;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getImageUrl()
    {
        if ($this->images) {
            return $this->images[0]->getImageUrl();
        }

        return '/images/product.png';
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
                    $propertyValue->name = (string)$value->Значение;
                    $propertyValue->property_id = $propertyModel->id;
                    $propertyValue->accounting_id = (string)$value->ИдЗначения;
                    $propertyValue->save();
                    unset($propertyValue);
                }
            }
        }
    }

    /**
     * @param \Zenwalker\CommerceML\Model\Offer $offer
     * @return OfferInterface
     */
    public function getOffer1c($offer)
    {
        $offerModel = Offer::createByMl($offer);
        $offerModel->product_id = $this->id;
        if ($offerModel->getDirtyAttributes()) {
            $offerModel->save();
        }
        return $offerModel;
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

    /**
     * @param \Zenwalker\CommerceML\Model\Product $product
     * @return mixed
     */
    public static function createModel1c($product)
    {
        $cml = $product->owner;
        if (!$catalog = Catalog::findOne(['accounting_id' => $cml->catalog->id])) {
            $catalog = new Catalog();
            $catalog->accounting_id = $cml->catalog->id;
        }
        $catalog->name = $cml->catalog->name;
        $catalog->save();
        if (!$model = Product::findOne(['accounting_id' => $product->id])) {
            $model = new Product();
            $model->accounting_id = $product->id;
        }
        $model->name = $product->name;
        $model->description = (string)$product->Описание;
        $model->article = (string)$product->Артикул;
        $model->catalog_id = $catalog->id;
        $model->save();
        return $model;
    }
}
