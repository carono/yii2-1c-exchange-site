<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "offer".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 * @property integer $product_id
 * @property string $remnant
 * @property boolean $is_active
 *
 * @property \app\models\Product $product
 * @property \app\models\PvOfferPrice[] $pvOfferPrices
 * @property \app\models\Price[] $prices
 * @property \app\models\PvOfferSpecification[] $pvOfferSpecifications
 * @property \app\models\Specification[] $specifications
 * @property \app\models\PvOfferWarehouse[] $pvOfferWarehouses
 * @property \app\models\Warehouse[] $warehouses
 * @property \app\models\PvOrderOffer[] $pvOrderOffers
 * @property \app\models\Order[] $orders
 */
class Offer extends ActiveRecord
{
	protected $_relationClasses = ['product_id' => 'app\models\Product'];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%offer}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['product_id'], 'integer'],
		            [['remnant'], 'number'],
		            [['is_active'], 'boolean'],
		            [['name', 'accounting_id'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Offer|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Offer not found"));
		}else{
		    return $model;
		}
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
		    'product_id' => Yii::t('models', 'Product ID'),
		    'remnant' => Yii::t('models', 'Remnant'),
		    'is_active' => Yii::t('models', 'Is Active')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\OfferQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\OfferQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProduct()
	{
		return $this->hasOne(\app\models\Product::className(), ['id' => 'product_id']);
	}


	/**
	 * @return \app\models\query\PvOfferPriceQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferPrices()
	{
		return $this->hasMany(\app\models\PvOfferPrice::className(), ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PriceQuery|\yii\db\ActiveQuery
	 */
	public function getPrices()
	{
		return $this->hasMany(\app\models\Price::className(), ['id' => 'price_id'])->viaTable('pv_offer_prices', ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvOfferSpecificationQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferSpecifications()
	{
		return $this->hasMany(\app\models\PvOfferSpecification::className(), ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\SpecificationQuery|\yii\db\ActiveQuery
	 */
	public function getSpecifications()
	{
		return $this->hasMany(\app\models\Specification::className(), ['id' => 'specification_id'])->viaTable('pv_offer_specifications', ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvOfferWarehouseQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferWarehouses()
	{
		return $this->hasMany(\app\models\PvOfferWarehouse::className(), ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\WarehouseQuery|\yii\db\ActiveQuery
	 */
	public function getWarehouses()
	{
		return $this->hasMany(\app\models\Warehouse::className(), ['id' => 'warehouse_id'])->viaTable('pv_offer_warehouses', ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvOrderOfferQuery|\yii\db\ActiveQuery
	 */
	public function getPvOrderOffers()
	{
		return $this->hasMany(\app\models\PvOrderOffer::className(), ['offer_id' => 'id']);
	}


	/**
	 * @return \app\models\query\OrderQuery|\yii\db\ActiveQuery
	 */
	public function getOrders()
	{
		return $this->hasMany(\app\models\Order::className(), ['id' => 'order_id'])->viaTable('pv_order_offers', ['offer_id' => 'id']);
	}


	/**
	 * @param string $attribute
	 * @return string|null
	 */
	public function getRelationClass($attribute)
	{
		return ArrayHelper::getValue($this->_relationClasses, $attribute);
	}
}
