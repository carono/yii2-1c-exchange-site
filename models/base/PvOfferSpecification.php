<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pv_offer_specifications".
 *
 * @property integer $offer_id
 * @property integer $specification_id
 * @property string $value
 *
 * @property \app\models\Offer $offer
 * @property \app\models\Specification $specification
 */
class PvOfferSpecification extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['offer_id'=>'app\models\Offer','specification_id'=>'app\models\Specification'];


    /**
    * @inheritdoc
    * @return \app\models\PvOfferSpecification    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PvOfferSpecification not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pv_offer_specifications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offer_id', 'specification_id'], 'required'],
            [['offer_id', 'specification_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
            [['specification_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Specification::className(), 'targetAttribute' => ['specification_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'offer_id' => Yii::t('models', 'Offer ID'),
            'specification_id' => Yii::t('models', 'Specification ID'),
            'value' => Yii::t('models', 'Value'),
        ];
    }

    /**
     * @return \app\models\query\OfferQuery
     */
    public function getOffer()
    {
        return $this->hasOne(\app\models\Offer::className(), ['id' => 'offer_id']);
    }

    /**
     * @return \app\models\query\SpecificationQuery
     */
    public function getSpecification()
    {
        return $this->hasOne(\app\models\Specification::className(), ['id' => 'specification_id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PvOfferSpecificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PvOfferSpecificationQuery(get_called_class());
    }


}
