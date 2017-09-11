<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "catalog".
 *
 * @property integer $id
 * @property string $name
 * @property string $accounting_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Product[] $products
 */
class Catalog extends \yii\db\ActiveRecord
{

protected $_relationClasses = [];


    /**
    * @inheritdoc
    * @return \app\models\Catalog    */
    public static function findOne($condition, $raise = false)
    {
        $model = parent::findOne($condition);
        if (!$model && $raise){
            throw new \yii\web\HttpException(404,'Model app\models\Catalog not found');
        }else{
            return $model;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog}}';
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
            'created_at' => Yii::t('models', 'Created At'),
            'updated_at' => Yii::t('models', 'Updated At'),
        ];
    }

    /**
     * @return \app\models\query\ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\Product::className(), ['catalog_id' => 'id']);
    }
    public function getRelationClass($attribute)
    {
        return isset($this->_relationClasses[$attribute]) ? $this->_relationClasses[$attribute] : null;
    }

    
    /**
     * @inheritdoc
     * @return \app\models\query\CatalogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CatalogQuery(get_called_class());
    }


}
