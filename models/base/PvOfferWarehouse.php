<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%pv_offer_warehouses}}".
 *
 * @property integer $offer_id
 * @property integer $warehouse_id
 *
 * @property \app\models\Offer $offer
 * @property \app\models\Warehouse $warehouse
 */
class PvOfferWarehouse extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%pv_offer_warehouses}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['offer_id', 'warehouse_id'], 'required'],
		            [['offer_id', 'warehouse_id'], 'default', 'value' => null],
		            [['offer_id', 'warehouse_id'], 'integer'],
		            [['offer_id', 'warehouse_id'], 'unique', 'targetAttribute' => ['offer_id', 'warehouse_id']],
		            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
		            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Warehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PvOfferWarehouse|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PvOfferWarehouse not found"));
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
		    'offer_id' => Yii::t('models', 'Offer ID'),
		    'warehouse_id' => Yii::t('models', 'Warehouse ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PvOfferWarehouseQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PvOfferWarehouseQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffer()
	{
		return $this->hasOne(\app\models\Offer::className(), ['id' => 'offer_id']);
	}


	/**
	 * @return \app\models\query\WarehouseQuery|\yii\db\ActiveQuery
	 */
	public function getWarehouse()
	{
		return $this->hasOne(\app\models\Warehouse::className(), ['id' => 'warehouse_id']);
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
