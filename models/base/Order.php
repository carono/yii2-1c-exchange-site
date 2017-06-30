<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "order".
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
class Order extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['status_id'=>'app\models\OrderStatus'];


    /**
    * @inheritdoc
    * @return \app\models\Order    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Order not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id'], 'integer'],
            [['sum'], 'number'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\OrderStatus::className(), 'targetAttribute' => ['status_id' => 'id']]
        ];
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
            'sum' => Yii::t('models', 'Sum'),
        ];
    }

    /**
     * @return \app\models\query\OrderStatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(\app\models\OrderStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \app\models\query\PvOrderOfferQuery
     */
    public function getPvOrderOffers()
    {
        return $this->hasMany(\app\models\PvOrderOffer::className(), ['order_id' => 'id']);
    }

    /**
     * @return \app\models\query\OfferQuery
     */
    public function getOffers()
    {
        return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('pv_order_offers', ['order_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OrderQuery(get_called_class());
    }


}
