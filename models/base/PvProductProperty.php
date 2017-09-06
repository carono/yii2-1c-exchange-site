<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pv_product_properties".
 *
 * @property integer $product_id
 * @property integer $property_id
 * @property integer $property_value_id
 *
 * @property \app\models\Product $product
 * @property \app\models\Property $property
 * @property \app\models\PropertyValue $propertyValue
 */
class PvProductProperty extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['product_id'=>'app\models\Product','property_id'=>'app\models\Property','property_value_id'=>'app\models\PropertyValue'];


    /**
    * @inheritdoc
    * @return \app\models\PvProductProperty    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PvProductProperty not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pv_product_properties}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'property_id'], 'required'],
            [['product_id', 'property_id', 'property_value_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['property_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\PropertyValue::className(), 'targetAttribute' => ['property_value_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('models', 'Product ID'),
            'property_id' => Yii::t('models', 'Property ID'),
            'property_value_id' => Yii::t('models', 'Property Value ID'),
        ];
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\app\models\Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \app\models\query\PropertyQuery
     */
    public function getProperty()
    {
        return $this->hasOne(\app\models\Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \app\models\query\PropertyValueQuery
     */
    public function getPropertyValue()
    {
        return $this->hasOne(\app\models\PropertyValue::className(), ['id' => 'property_value_id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PvProductPropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PvProductPropertyQuery(get_called_class());
    }


}
