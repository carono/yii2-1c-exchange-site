<?php

namespace app\models\query;

use yii\data\Sort;
use yii\data\ActiveDataProvider;
/**
 * This is the ActiveQuery class for [[\app\models\Product]].
 *
 * @see \app\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{

//    public function active()
//    {
//        $this->andWhere(['active' => true]);
//        return $this;
//    }

//    public function my($user = null)
//    {
//        $this->andWhere(['user_id' => \carono\components\CurrentUser::user($user)->getId()]);
//        return $this;
//    }

    /**
     * @inheritdoc
     * @return \app\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function search($filter = null, $options = [])
    {
        $this->filter($filter);
        $sort = new Sort();
        return new ActiveDataProvider(
            [
                'query' => $this,
                'sort'  => $sort
            ]
        );
    }

    public function filter($model)
    {
		if ($model){
        }
        return $this;
    }
}
