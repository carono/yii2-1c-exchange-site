<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $accounting_id
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Group $parent
 * @property \app\models\Group[] $groups
 * @property \app\models\Product[] $products
 */
class Group extends ActiveRecord
{
	protected $_relationClasses = ['parent_id' => 'app\models\Group'];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%group}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['parent_id'], 'integer'],
		            [['is_active'], 'boolean'],
		            [['name', 'accounting_id'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Group::className(), 'targetAttribute' => ['parent_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Group|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Group not found"));
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
		    'parent_id' => Yii::t('models', 'Parent ID'),
		    'accounting_id' => Yii::t('models', 'Accounting ID'),
		    'created_at' => Yii::t('models', 'Created At'),
		    'updated_at' => Yii::t('models', 'Updated At'),
		    'is_active' => Yii::t('models', 'Is Active')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\GroupQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\GroupQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\GroupQuery|\yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(\app\models\Group::className(), ['id' => 'parent_id']);
	}


	/**
	 * @return \app\models\query\GroupQuery|\yii\db\ActiveQuery
	 */
	public function getGroups()
	{
		return $this->hasMany(\app\models\Group::className(), ['parent_id' => 'id']);
	}


	/**
	 * @return \app\models\query\ProductQuery|\yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(\app\models\Product::className(), ['group_id' => 'id']);
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
