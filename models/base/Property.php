<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "property".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\PropertyValue[] $propertyValues
 * @property \app\models\PvProductProperty[] $pvProductProperties
 * @property \app\models\Product[] $products
 */
class Property extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\Property    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Property not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property';
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
     * @return \app\models\query\PropertyValueQuery
     */
    public function getPropertyValues()
    {
        return $this->hasMany(\app\models\PropertyValue::className(), ['property_id' => 'id']);
    }

    /**
     * @return \app\models\query\PvProductPropertyQuery
     */
    public function getPvProductProperties()
    {
        return $this->hasMany(\app\models\PvProductProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\Product::className(), ['id' => 'product_id'])->viaTable('pv_product_properties', ['property_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PropertyQuery(get_called_class());
    }


}
