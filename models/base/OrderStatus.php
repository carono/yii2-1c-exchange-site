<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "order_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\Order[] $orders
 */
class OrderStatus extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\OrderStatus    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\OrderStatus not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
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
        ];
    }

    /**
     * @return \app\models\query\OrderQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\app\models\Order::className(), ['status_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\OrderStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OrderStatusQuery(get_called_class());
    }


}
