<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "price_type".
 *
 * @property integer $id
 * @property string $accounting_id
 * @property string $name
 * @property string $currency
 *
 * @property \app\models\Price[] $prices
 * @property \app\models\PvOrderOffer[] $pvOrderOffers
 */
class PriceType extends ActiveRecord
{
	protected $_relationClasses = [];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%price_type}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['accounting_id', 'name', 'currency'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PriceType|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PriceType not found"));
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
		    'accounting_id' => Yii::t('models', 'Accounting ID'),
		    'name' => Yii::t('models', 'Name'),
		    'currency' => Yii::t('models', 'Currency')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PriceTypeQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PriceTypeQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PriceQuery|\yii\db\ActiveQuery
	 */
	public function getPrices()
	{
		return $this->hasMany(\app\models\Price::className(), ['type_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvOrderOfferQuery|\yii\db\ActiveQuery
	 */
	public function getPvOrderOffers()
	{
		return $this->hasMany(\app\models\PvOrderOffer::className(), ['price_type_id' => 'id']);
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
