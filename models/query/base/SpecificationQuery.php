<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\query\base;

use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for \app\models\Specification
 * @see \app\models\Specification
 */
class SpecificationQuery extends ActiveQuery
{
	/**
	 * @inheritdoc
	 * @return \app\models\Specification[]
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Specification
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}


	/**
	 * @var mixed $filter
	 * @var array $options Options for ActiveDataProvider
	 * @return ActiveDataProvider
	 */
	public function search($filter = null, $options = [])
	{
		$query = clone $this;
		$query->filter($filter);
		$sort = new Sort();
		    return new ActiveDataProvider(
		    array_merge([
		        'query' => $query,
		        'sort'  => $sort
		    ], $options)
		);
	}


	/**
	 * @var array|\yii\db\ActiveRecord $model
	 * @return $this
	 */
	public function filter($model = null)
	{
		return $this;
	}
}
