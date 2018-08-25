<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status_id
 * @property string $sum
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\OrderStatus $status
 * @property \app\models\PvOrderOffer[] $pvOrderOffers
 * @property \app\models\Offer[] $offers
 */
class Order extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%order}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['user_id', 'status_id'], 'default', 'value' => null],
		            [['user_id', 'status_id'], 'integer'],
		            [['sum'], 'number'],
		            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\OrderStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Order|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Order not found"));
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
		    'user_id' => Yii::t('models', 'User ID'),
		    'created_at' => Yii::t('models', 'Created At'),
		    'updated_at' => Yii::t('models', 'Updated At'),
		    'status_id' => Yii::t('models', 'Status ID'),
		    'sum' => Yii::t('models', 'Sum')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\OrderQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\OrderQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OrderStatusQuery|\yii\db\ActiveQuery
	 */
	public function getStatus()
	{
		return $this->hasOne(\app\models\OrderStatus::className(), ['id' => 'status_id']);
	}


	/**
	 * @return \app\models\query\PvOrderOfferQuery|\yii\db\ActiveQuery
	 */
	public function getPvOrderOffers()
	{
		return $this->hasMany(\app\models\PvOrderOffer::className(), ['order_id' => 'id']);
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffers()
	{
		return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('{{%pv_order_offers}}', ['order_id' => 'id']);
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
