<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%migration}}".
 *
 * @property string $version
 * @property integer $apply_time
 */
class Migration extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%migration}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['version'], 'required'],
		            [['apply_time'], 'default', 'value' => null],
		            [['apply_time'], 'integer'],
		            [['version'], 'string', 'max' => 180],
		            [['version'], 'unique'],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Migration|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Migration not found"));
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
		    'version' => Yii::t('models', 'Version'),
		    'apply_time' => Yii::t('models', 'Apply Time')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\MigrationQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\MigrationQuery(get_called_class());
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
