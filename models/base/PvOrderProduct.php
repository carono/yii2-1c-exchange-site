<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pv_order_products".
 *
 * @property integer $order_id
 * @property integer $product_id
 * @property string $count
 *
 * @property \app\models\Order $order
 * @property \app\models\Product $product
 */
class PvOrderProduct extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['order_id'=>'app\models\Order','product_id'=>'app\models\Product'];


    /**
    * @inheritdoc
    * @return \app\models\PvOrderProduct    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PvOrderProduct not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pv_order_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id'], 'integer'],
            [['count'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('models', 'Order ID'),
            'product_id' => Yii::t('models', 'Product ID'),
            'count' => Yii::t('models', 'Count'),
        ];
    }

    /**
     * @return \app\models\query\OrderQuery
     */
    public function getOrder()
    {
        return $this->hasOne(\app\models\Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\app\models\Product::className(), ['id' => 'product_id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PvOrderProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PvOrderProductQuery(get_called_class());
    }


}
