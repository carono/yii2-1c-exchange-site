<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pv_product_images".
 *
 * @property integer $product_id
 * @property integer $image_id
 *
 * @property \app\models\FileUpload $image
 * @property \app\models\Product $product
 */
class PvProductImage extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['image_id'=>'app\models\FileUpload','product_id'=>'app\models\Product'];


    /**
    * @inheritdoc
    * @return \app\models\PvProductImage    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\PvProductImage not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pv_product_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image_id'], 'required'],
            [['product_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\FileUpload::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Product::className(), 'targetAttribute' => ['product_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('models', 'Product ID'),
            'image_id' => Yii::t('models', 'Image ID'),
        ];
    }

    /**
     * @return \app\models\query\FileUploadQuery
     */
    public function getImage()
    {
        return $this->hasOne(\app\models\FileUpload::className(), ['id' => 'image_id']);
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
     * @return \app\models\query\PvProductImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PvProductImageQuery(get_called_class());
    }


}
