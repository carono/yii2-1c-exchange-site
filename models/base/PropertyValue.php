<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "property_value".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $name
 * @property string $accounting_id
 *
 * @property \app\models\Property $property
 * @property \app\models\PvProductProperty[] $pvProductProperties
 */
class PropertyValue extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['property_id'=>'app\models\Property'];


    /**
    * @inheritdoc
    * @return \app\models\PropertyValue    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PropertyValue not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id'], 'integer'],
            [['name', 'accounting_id'], 'string', 'max' => 255],
            [['accounting_id'], 'unique'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Property::className(), 'targetAttribute' => ['property_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'property_id' => Yii::t('models', 'Property ID'),
            'name' => Yii::t('models', 'Name'),
            'accounting_id' => Yii::t('models', 'Accounting ID'),
        ];
    }

    /**
     * @return \app\models\query\PropertyQuery
     */
    public function getProperty()
    {
        return $this->hasOne(\app\models\Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \app\models\query\PvProductPropertyQuery
     */
    public function getPvProductProperties()
    {
        return $this->hasMany(\app\models\PvProductProperty::className(), ['property_value_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PropertyValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PropertyValueQuery(get_called_class());
    }


}
