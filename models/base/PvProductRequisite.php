<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%pv_product_requisite}}".
 *
 * @property integer $product_id
 * @property integer $requisite_id
 * @property string $value
 *
 * @property \app\models\Product $product
 * @property \app\models\Requisite $requisite
 */
class PvProductRequisite extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%pv_product_requisite}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['product_id', 'requisite_id'], 'required'],
		            [['product_id', 'requisite_id'], 'default', 'value' => null],
		            [['product_id', 'requisite_id'], 'integer'],
		            [['value'], 'string', 'max' => 1024],
		            [['product_id', 'requisite_id'], 'unique', 'targetAttribute' => ['product_id', 'requisite_id']],
		            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']],
		            [['requisite_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Requisite::className(), 'targetAttribute' => ['requisite_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PvProductRequisite|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PvProductRequisite not found"));
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
		    'product_id' => Yii::t('models', 'Product ID'),
		    'requisite_id' => Yii::t('models', 'Requisite ID'),
		    'value' => Yii::t('models', 'Value')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PvProductRequisiteQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PvProductRequisiteQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProduct()
	{
		return $this->hasOne(\app\models\Product::className(), ['id' => 'product_id']);
	}


	/**
	 * @return \app\models\query\RequisiteQuery|\yii\db\ActiveQuery
	 */
	public function getRequisite()
	{
		return $this->hasOne(\app\models\Requisite::className(), ['id' => 'requisite_id']);
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
