<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%order_status}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\Order[] $orders
 */
class OrderStatus extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%order_status}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['name'], 'string', 'max' => 255],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\OrderStatus|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\OrderStatus not found"));
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
		    'name' => Yii::t('models', 'Name')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\OrderStatusQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\OrderStatusQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OrderQuery|\yii\db\ActiveQuery
	 */
	public function getOrders()
	{
		return $this->hasMany(\app\models\Order::className(), ['status_id' => 'id']);
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
