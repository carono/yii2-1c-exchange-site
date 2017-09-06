<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "requisite".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\PvProductRequisite[] $pvProductRequisites
 * @property \app\models\Product[] $products
 */
class Requisite extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\Requisite    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Requisite not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%requisite}}';
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
     * @return \app\models\query\PvProductRequisiteQuery
     */
    public function getPvProductRequisites()
    {
        return $this->hasMany(\app\models\PvProductRequisite::className(), ['requisite_id' => 'id']);
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\Product::className(), ['id' => 'product_id'])->viaTable('pv_product_requisite', ['requisite_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\RequisiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RequisiteQuery(get_called_class());
    }


}
