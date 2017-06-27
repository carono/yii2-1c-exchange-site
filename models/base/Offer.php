<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "offer".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 * @property integer $price_id
 * @property integer $product_id
 * @property string $remnant
 *
 * @property \app\models\Price $price
 * @property \app\models\Product $product
 * @property \app\models\PvOfferWarehouse[] $pvOfferWarehouses
 * @property \app\models\Warehouse[] $warehouses
 */
class Offer extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['price_id'=>'app\models\Price','product_id'=>'app\models\Product'];


    /**
    * @inheritdoc
    * @return \app\models\Offer    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Offer not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_id', 'product_id'], 'integer'],
            [['remnant'], 'number'],
            [['name', 'accounting_id'], 'string', 'max' => 255],
            [['accounting_id'], 'unique'],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Price::className(), 'targetAttribute' => ['price_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'name' => Yii::t('models', 'Name'),
            'accounting_id' => Yii::t('models', 'Accounting ID'),
            'price_id' => Yii::t('models', 'Price ID'),
            'product_id' => Yii::t('models', 'Product ID'),
            'remnant' => Yii::t('models', 'Remnant'),
        ];
    }

    /**
     * @return \app\models\query\PriceQuery
     */
    public function getPrice()
    {
        return $this->hasOne(\app\models\Price::className(), ['id' => 'price_id']);
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\app\models\Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \app\models\query\PvOfferWarehouseQuery
     */
    public function getPvOfferWarehouses()
    {
        return $this->hasMany(\app\models\PvOfferWarehouse::className(), ['offer_id' => 'id']);
    }

    /**
     * @return \app\models\query\WarehouseQuery
     */
    public function getWarehouses()
    {
        return $this->hasMany(\app\models\Warehouse::className(), ['id' => 'warehouse_id'])->viaTable('pv_offer_warehouses', ['offer_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\OfferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OfferQuery(get_called_class());
    }


}
