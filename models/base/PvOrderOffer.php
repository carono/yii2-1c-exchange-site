<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "pv_order_offers".
 *
 * @property integer $order_id
 * @property integer $offer_id
 * @property string $count
 * @property string $sum
 * @property integer $price_type_id
 *
 * @property \app\models\Offer $offer
 * @property \app\models\Order $order
 * @property \app\models\PriceType $priceType
 */
class PvOrderOffer extends ActiveRecord
{
	protected $_relationClasses = [
		'offer_id' => 'app\models\Offer',
		'order_id' => 'app\models\Order',
		'price_type_id' => 'app\models\PriceType',
	];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%pv_order_offers}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['order_id', 'offer_id'], 'required'],
		            [['order_id', 'offer_id', 'price_type_id'], 'integer'],
		            [['count', 'sum'], 'number'],
		            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
		            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Order::className(), 'targetAttribute' => ['order_id' => 'id']],
		            [['price_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\PriceType::className(), 'targetAttribute' => ['price_type_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\PvOrderOffer|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\PvOrderOffer not found"));
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
		    'order_id' => Yii::t('models', 'Order ID'),
		    'offer_id' => Yii::t('models', 'Offer ID'),
		    'count' => Yii::t('models', 'Count'),
		    'sum' => Yii::t('models', 'Sum'),
		    'price_type_id' => Yii::t('models', 'Price Type ID')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\PvOrderOfferQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\PvOrderOfferQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffer()
	{
		return $this->hasOne(\app\models\Offer::className(), ['id' => 'offer_id']);
	}


	/**
	 * @return \app\models\query\OrderQuery|\yii\db\ActiveQuery
	 */
	public function getOrder()
	{
		return $this->hasOne(\app\models\Order::className(), ['id' => 'order_id']);
	}


	/**
	 * @return \app\models\query\PriceTypeQuery|\yii\db\ActiveQuery
	 */
	public function getPriceType()
	{
		return $this->hasOne(\app\models\PriceType::className(), ['id' => 'price_type_id']);
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
