<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "catalog".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Product[] $products
 */
class Catalog extends ActiveRecord
{
	protected $_relationClasses = [];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%catalog}}';
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
	 * @return \app\models\Catalog|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Catalog not found"));
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
		    'created_at' => Yii::t('models', 'Created At'),
		    'updated_at' => Yii::t('models', 'Updated At')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\CatalogQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\CatalogQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(\app\models\Product::className(), ['catalog_id' => 'id']);
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
