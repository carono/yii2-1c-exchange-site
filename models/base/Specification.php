<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%specification}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\PvOfferSpecification[] $pvOfferSpecifications
 * @property \app\models\Offer[] $offers
 */
class Specification extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%specification}}';
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
	 * @return \app\models\Specification|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Specification not found"));
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
	 * @return \app\models\query\SpecificationQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\SpecificationQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PvOfferSpecificationQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferSpecifications()
	{
		return $this->hasMany(\app\models\PvOfferSpecification::className(), ['specification_id' => 'id']);
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffers()
	{
		return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('{{%pv_offer_specifications}}', ['specification_id' => 'id']);
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
