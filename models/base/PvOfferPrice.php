<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "pv_offer_prices".
 *
 * @property integer $offer_id
 * @property integer $price_id
 *
 * @property \app\models\Offer $offer
 * @property \app\models\Price $price
 */
class PvOfferPrice extends ActiveRecord
{
	protected $_relationClasses = ['offer_id' => 'app\models\Offer', 'price_id' => 'app\models\Price'];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%pv_offer_prices}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['offer_id', 'price_id'], 'required'],
		            [['offer_id', 'price_id'], 'integer'],
		            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
		            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Price::className(), 'targetAttribute' => ['price_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PvOfferPrice|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PvOfferPrice not found"));
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
		    'offer_id' => Yii::t('models', 'Offer ID'),
		    'price_id' => Yii::t('models', 'Price ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PvOfferPriceQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PvOfferPriceQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffer()
	{
		return $this->hasOne(\app\models\Offer::className(), ['id' => 'offer_id']);
	}


	/**
	 * @return \app\models\query\PriceQuery|\yii\db\ActiveQuery
	 */
	public function getPrice()
	{
		return $this->hasOne(\app\models\Price::className(), ['id' => 'price_id']);
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
