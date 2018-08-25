<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "cost_type".
 *
 * @property integer $id
 * @property string $accounting_id
 * @property string $name
 * @property string $currency
 *
 * @property \app\models\Cost[] $costs
 */
class CostType extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\CostType    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\CostType not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cost_type';
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
     * @return \app\models\query\CostQuery
     */
    public function getCosts()
    {
        return $this->hasMany(\app\models\Cost::class, ['type_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\CostTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CostTypeQuery(get_called_class());
    }


}
