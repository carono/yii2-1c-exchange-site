<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%requisite}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\PvProductRequisite[] $pvProductRequisites
 * @property \app\models\Product[] $products
 */
class Requisite extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%requisite}}';
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
	 * @return \app\models\Requisite|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Requisite not found"));
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
	 * @return \app\models\query\RequisiteQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\RequisiteQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PvProductRequisiteQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductRequisites()
	{
		return $this->hasMany(\app\models\PvProductRequisite::className(), ['requisite_id' => 'id']);
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(\app\models\Product::className(), ['id' => 'product_id'])->viaTable('{{%pv_product_requisite}}', ['requisite_id' => 'id']);
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
