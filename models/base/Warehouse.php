<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "warehouse".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\PvOfferWarehouse[] $pvOfferWarehouses
 * @property \app\models\Offer[] $offers
 */
class Warehouse extends ActiveRecord
{
	protected $_relationClasses = [];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%warehouse}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['name', 'accounting_id'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Warehouse|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Warehouse not found"));
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
		    'accounting_id' => Yii::t('models', 'Accounting ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\WarehouseQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\WarehouseQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PvOfferWarehouseQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferWarehouses()
	{
		return $this->hasMany(\app\models\PvOfferWarehouse::className(), ['warehouse_id' => 'id']);
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffers()
	{
		return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('pv_offer_warehouses', ['warehouse_id' => 'id']);
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
