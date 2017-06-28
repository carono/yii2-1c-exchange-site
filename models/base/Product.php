<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $article
 * @property string $description
 * @property string $accounting_id
 * @property integer $group_id
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Offer[] $offers
 * @property \app\models\Group $group
 * @property \app\models\PvProductImage[] $pvProductImages
 * @property \app\models\FileUpload[] $images
 * @property \app\models\PvProductRequisite[] $pvProductRequisites
 * @property \app\models\Requisite[] $requisites
 */
class Product extends \yii\db\ActiveRecord
{

protected $_relationClasses = ['group_id'=>'app\models\Group'];


    /**
    * @inheritdoc
    * @return \app\models\Product    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Product not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
            [['is_active'], 'boolean'],
            [['name', 'article', 'description', 'accounting_id'], 'string', 'max' => 255],
            [['accounting_id'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Group::className(), 'targetAttribute' => ['group_id' => 'id']]
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
            'article' => Yii::t('models', 'Article'),
            'description' => Yii::t('models', 'Description'),
            'accounting_id' => Yii::t('models', 'Accounting ID'),
            'group_id' => Yii::t('models', 'Group ID'),
            'created_at' => Yii::t('models', 'Created At'),
            'updated_at' => Yii::t('models', 'Updated At'),
            'is_active' => Yii::t('models', 'Is Active'),
        ];
    }

    /**
     * @return \app\models\query\OfferQuery
     */
    public function getOffers()
    {
        return $this->hasMany(\app\models\Offer::className(), ['product_id' => 'id']);
    }

    /**
     * @return \app\models\query\GroupQuery
     */
    public function getGroup()
    {
        return $this->hasOne(\app\models\Group::className(), ['id' => 'group_id']);
    }

    /**
     * @return \app\models\query\PvProductImageQuery
     */
    public function getPvProductImages()
    {
        return $this->hasMany(\app\models\PvProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * @return \app\models\query\FileUploadQuery
     */
    public function getImages()
    {
        return $this->hasMany(\app\models\FileUpload::className(), ['id' => 'image_id'])->viaTable('pv_product_images', ['product_id' => 'id']);
    }

    /**
     * @return \app\models\query\PvProductRequisiteQuery
     */
    public function getPvProductRequisites()
    {
        return $this->hasMany(\app\models\PvProductRequisite::className(), ['product_id' => 'id']);
    }

    /**
     * @return \app\models\query\RequisiteQuery
     */
    public function getRequisites()
    {
        return $this->hasMany(\app\models\Requisite::className(), ['id' => 'requisite_id'])->viaTable('pv_product_requisite', ['product_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProductQuery(get_called_class());
    }


}
