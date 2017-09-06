<?php

namespace app\models\base;

use Yii;

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
class Price extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['type_id'=>'app\models\PriceType'];


    /**
    * @inheritdoc
    * @return \app\models\Price    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Price not found');
        }else{
            return $model;
        }
    }

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
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\PriceType::className(), 'targetAttribute' => ['type_id' => 'id']]
        ];
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
            'type_id' => Yii::t('models', 'Type ID'),
        ];
    }

    /**
     * @return \app\models\query\PriceTypeQuery
     */
    public function getType()
    {
        return $this->hasOne(\app\models\PriceType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \app\models\query\PvOfferPriceQuery
     */
    public function getPvOfferPrices()
    {
        return $this->hasMany(\app\models\PvOfferPrice::className(), ['price_id' => 'id']);
    }

    /**
     * @return \app\models\query\OfferQuery
     */
    public function getOffers()
    {
        return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('pv_offer_prices', ['price_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PriceQuery(get_called_class());
    }


}
