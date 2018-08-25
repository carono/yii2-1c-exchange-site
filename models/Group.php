<?php

namespace app\models;

use app\models\query\OfferQuery;
use carono\exchange1c\interfaces\GroupInterface;
use \app\models\base\Group as BaseGroup;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "group".
 */
class Group extends BaseGroup implements GroupInterface
{
    /**
     * Создаём группу по модели группы CommerceML
     * проверяем все дерево родителей группы, если родителя нет в базе - создаём
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
            $parentModel = self::createByML($parent);
            $model->parent_id = $parentModel->id;
            unset($parentModel);
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
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function formForMenu()
    {
        $item = ['label' => $this->name, 'url' => ['/site/group', 'id' => $this->id]];
        if (!$this->hasChildren(true)) {
            return null;
        }
        foreach ($this->groups as $subGroup) {
            if ($menu = $subGroup->formForMenu()) {
                $item['items'][] = $menu;
            }
        }
        return $item;
    }

    public static function formMenuItems($parent = null)
    {
        $items = [];
        foreach (self::findAll(['parent_id' => $parent]) as $group) {
            if ($menu = $group->formForMenu()) {
                $items[] = $menu;
            }
        }
        return $items;
    }

    /**
     * @param \Zenwalker\CommerceML\Model\Group[] $groups
     * @return void
     */
    public static function createTree1c($groups)
    {
        foreach ($groups as $group) {
            self::createByML($group);
            if ($children = $group->getChildren()) {
                self::createTree1c($children);
            }
        }
    }

    /**
     * @return OfferQuery
     */
    public function getOffers()
    {
        return Offer::find()->joinWith(['product'])->andWhere(['product.group_id' => $this->id]);
    }

    /**
     * @param bool $recursive
     * @return bool
     */
    public function hasChildren($recursive = false)
    {
        if ($this->getOffers()->exists()) {
            return true;
        }
        foreach ($this->getGroups()->all() as $child) {
            if ($child->getOffers()->exists() || ($recursive && $child->hasChildren(true))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Возвращаем имя поля в базе данных, в котором хранится ID из 1с
     *
     * @return string
     */
    public static function getIdFieldName1c()
    {
        return 'accounting_id';
    }
}
