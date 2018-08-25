<?php

namespace app\models;

use Yii;
use \app\models\base\Catalog as BaseCatalog;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "catalog".
 */
class Catalog extends BaseCatalog
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()')
            ]
        ];
    }
}
