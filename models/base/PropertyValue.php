<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%property_value}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\Property $property
 * @property \app\models\PvProductProperty[] $pvProductProperties
 */
class PropertyValue extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%property_value}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['property_id'], 'default', 'value' => null],
		            [['property_id'], 'integer'],
		            [['name', 'accounting_id'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Property::className(), 'targetAttribute' => ['property_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PropertyValue|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PropertyValue not found"));
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
		    'property_id' => Yii::t('models', 'Property ID'),
		    'name' => Yii::t('models', 'Name'),
		    'accounting_id' => Yii::t('models', 'Accounting ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PropertyValueQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PropertyValueQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PropertyQuery|\yii\db\ActiveQuery
	 */
	public function getProperty()
	{
		return $this->hasOne(\app\models\Property::className(), ['id' => 'property_id']);
	}


	/**
	 * @return \app\models\query\PvProductPropertyQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductProperties()
	{
		return $this->hasMany(\app\models\PvProductProperty::className(), ['property_value_id' => 'id']);
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
