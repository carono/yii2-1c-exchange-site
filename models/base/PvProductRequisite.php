<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pv_product_requisite".
 *
 * @property integer $product_id
 * @property integer $requisite_id
 * @property string $value
 *
 * @property \app\models\Product $product
 * @property \app\models\Requisite $requisite
 */
class PvProductRequisite extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['product_id'=>'app\models\Product','requisite_id'=>'app\models\Requisite'];


    /**
    * @inheritdoc
    * @return \app\models\PvProductRequisite    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PvProductRequisite not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pv_product_requisite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'requisite_id'], 'required'],
            [['product_id', 'requisite_id'], 'integer'],
            [['value'], 'string', 'max' => 1024],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['requisite_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Requisite::className(), 'targetAttribute' => ['requisite_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('models', 'Product ID'),
            'requisite_id' => Yii::t('models', 'Requisite ID'),
            'value' => Yii::t('models', 'Value'),
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
     * @return \app\models\query\RequisiteQuery
     */
    public function getRequisite()
    {
        return $this->hasOne(\app\models\Requisite::className(), ['id' => 'requisite_id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\PvProductRequisiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PvProductRequisiteQuery(get_called_class());
    }


}
