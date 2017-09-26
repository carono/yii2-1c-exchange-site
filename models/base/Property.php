<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "property".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\PropertyValue[] $propertyValues
 * @property \app\models\PvProductProperty[] $pvProductProperties
 * @property \app\models\Product[] $products
 */
class Property extends ActiveRecord
{
	protected $_relationClasses = [];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%property}}';
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
	 * @return \app\models\Property|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Property not found"));
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
	 * @return \app\models\query\PropertyQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PropertyQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PropertyValueQuery|\yii\db\ActiveQuery
	 */
	public function getPropertyValues()
	{
		return $this->hasMany(\app\models\PropertyValue::className(), ['property_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvProductPropertyQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductProperties()
	{
		return $this->hasMany(\app\models\PvProductProperty::className(), ['property_id' => 'id']);
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(\app\models\Product::className(), ['id' => 'product_id'])->viaTable('pv_product_properties', ['property_id' => 'id']);
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
