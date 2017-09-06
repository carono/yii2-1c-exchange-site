<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "specification".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\PvOfferSpecification[] $pvOfferSpecifications
 * @property \app\models\Offer[] $offers
 */
class Specification extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\Specification    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Specification not found');
        }else{
            return $model;
        }
    }

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
            'name' => Yii::t('models', 'Name'),
            'accounting_id' => Yii::t('models', 'Accounting ID'),
        ];
    }

    /**
     * @return \app\models\query\PvOfferSpecificationQuery
     */
    public function getPvOfferSpecifications()
    {
        return $this->hasMany(\app\models\PvOfferSpecification::className(), ['specification_id' => 'id']);
    }

    /**
     * @return \app\models\query\OfferQuery
     */
    public function getOffers()
    {
        return $this->hasMany(\app\models\Offer::className(), ['id' => 'offer_id'])->viaTable('pv_offer_specifications', ['specification_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\SpecificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SpecificationQuery(get_called_class());
    }


}
