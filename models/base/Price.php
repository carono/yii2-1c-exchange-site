<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "price".
 *
 * @property integer $id
 * @property string $performance
 * @property string $value
 * @property string $currency
 * @property double $rate
 * @property integer $type_id
 *
 * @property \app\models\PriceType $type
 * @property \app\models\PvOfferPrice[] $pvOfferPrices
 * @property \app\models\Offer[] $offers
 */
class Price extends ActiveRecord
{
	protected $_relationClasses = ['type_id' => 'app\models\PriceType'];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%price}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['value', 'rate'], 'number'],
		            [['type_id'], 'integer'],
		            [['performance', 'currency'], 'string', 'max' => 255],
		            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\PriceType::className(), 'targetAttribute' => ['type_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Price|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Price not found"));
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
		    'performance' => Yii::t('models', 'Performance'),
		    'value' => Yii::t('models', 'Value'),
		    'currency' => Yii::t('models', 'Currency'),
		    'rate' => Yii::t('models', 'Rate'),
		    'type_id' => Yii::t('models', 'Type ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PriceQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PriceQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\PriceTypeQuery|\yii\db\ActiveQuery
	 */
	public function getType()
	{
		return $this->hasOne(\app\models\PriceType::className(), ['id' => 'type_id']);
	}


	/**
	 * @return \app\models\query\PvOfferPriceQuery|\yii\db\ActiveQuery
	 */
	public function getPvOfferPrices()
	{
		return $this->hasMany(\app\models\PvOfferPrice::className(), ['price_id' => 'id']);
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffers()
	{
		return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('pv_offer_prices', ['price_id' => 'id']);
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
