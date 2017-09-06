<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "file_upload".
 *
 * @property integer $id
 * @property string $uid
 * @property integer $user_id
 * @property string $name
 * @property string $extension
 * @property string $folder
 * @property string $mime_type
 * @property integer $size
 * @property string $data
 * @property string $session
 * @property string $md5
 * @property string $slug
 * @property boolean $is_active
 * @property boolean $is_exist
 * @property resource $binary
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\PvProductImage[] $pvProductImages
 * @property \app\models\Product[] $products
 */
class FileUpload extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\FileUpload    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\FileUpload not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_upload}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'size'], 'integer'],
            [['data', 'binary'], 'string'],
            [['is_active', 'is_exist'], 'boolean'],
            [['uid'], 'string', 'max' => 64],
            [['name', 'extension', 'folder', 'mime_type', 'session', 'slug'], 'string', 'max' => 255],
            [['md5'], 'string', 'max' => 32],
            [['uid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'uid' => Yii::t('models', 'Uid'),
            'user_id' => Yii::t('models', 'User ID'),
            'name' => Yii::t('models', 'Name'),
            'extension' => Yii::t('models', 'Extension'),
            'folder' => Yii::t('models', 'Folder'),
            'mime_type' => Yii::t('models', 'Mime Type'),
            'size' => Yii::t('models', 'Size'),
            'data' => Yii::t('models', 'Data'),
            'session' => Yii::t('models', 'Session'),
            'md5' => Yii::t('models', 'Md5'),
            'slug' => Yii::t('models', 'Slug'),
            'is_active' => Yii::t('models', 'Is Active'),
            'is_exist' => Yii::t('models', 'Is Exist'),
            'binary' => Yii::t('models', 'Binary'),
            'created_at' => Yii::t('models', 'Created At'),
            'updated_at' => Yii::t('models', 'Updated At'),
        ];
    }

    /**
     * @return \app\models\query\PvProductImageQuery
     */
    public function getPvProductImages()
    {
        return $this->hasMany(\app\models\PvProductImage::className(), ['image_id' => 'id']);
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\Product::className(), ['id' => 'product_id'])->viaTable('pv_product_images', ['image_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\FileUploadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FileUploadQuery(get_called_class());
    }


}
