<?php

namespace app\models;

use Yii;
use \app\models\base\Group as BaseGroup;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Zenwalker\CommerceML\Model\Category;

/**
 * This is the model class for table "group".
 */
class Group extends BaseGroup
{
    /**
     * Создаём группу по модели группы CommerceML
     * проверяем все дерево родителей группы, если родителя нет в базе- создаём
     *
     * @param \Zenwalker\CommerceML\Model\Group $group
     * @return Group|array|null
     */
    public static function createByML(\Zenwalker\CommerceML\Model\Group $group)
    {
        /**
         * @var \Zenwalker\CommerceML\Model\Group $parent
         */
        if (!$model = Group::findOne(['accounting_id' => $group->id])) {
            $model = new self;
            $model->accounting_id = $group->id;
        }
        $model->name = $group->name;
        if ($parent = $group->getParent()) {
            $model->parent_id = self::createByML($parent)->id;
        } else {
            $model->parent_id = null;
        }
        $model->save();
        return $model;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function formForMenu()
    {
        $item = ['label' => $this->name, 'url' => ['/site/group', 'id' => $this->id]];
        foreach ($this->groups as $subGroup) {
            $item['items'][] = $subGroup->formForMenu();
        }
        return $item;
    }

    public static function formMenuItems($parent = null)
    {
        $items = [];
        foreach (self::findAll(['parent_id' => $parent]) as $group) {
            $items[] = $group->formForMenu();
        }
        return $items;
    }
}
