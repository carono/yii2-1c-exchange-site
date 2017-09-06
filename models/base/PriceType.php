<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "price_type".
 *
 * @property integer $id
 * @property string $accounting_id
 * @property string $name
 * @property string $currency
 *
 * @property \app\models\Price[] $prices
 * @property \app\models\PvOrderOffer[] $pvOrderOffers
 */
class PriceType extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\PriceType    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PriceType not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%price_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accounting_id', 'name', 'currency'], 'string', 'max' => 255],
            [['accounting_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'accounting_id' => Yii::t('models', 'Accounting ID'),
            'name' => Yii::t('models', 'Name'),
            'currency' => Yii::t('models', 'Currency'),
        ];
    }

    /**
     * @return \app\models\query\PriceQuery
     */
    public function getPrices()
    {
        return $this->hasMany(\app\models\Price::className(), ['type_id' => 'id']);
    }

    /**
     * @return \app\models\query\PvOrderOfferQuery
     */
    public function getPvOrderOffers()
    {
        return $this->hasMany(\app\models\PvOrderOffer::className(), ['price_type_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PriceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PriceTypeQuery(get_called_class());
    }


}
