<?php

namespace app\components;

use app\models\Catalog;
use app\models\Offer;
use app\models\Order;
use app\models\Product;
use app\models\PvOrderCatalog;
use app\models\PvOrderOffer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Basket
{
    const MAX_COUNT = 10;
    private static $_error;

    public static function totalSum()
    {
        $result = 0;
        $basket = self::show();
        foreach (Offer::find()->andWhere(['id' => self::getIds()])->all() as $product) {
            if (isset($basket[$product->id])) {
                $result += $product->sum_in_basket;
            }
        }
        return $result;
    }

    public static function shake()
    {
        $items = self::show();
        \Yii::$app->session->set('basket', []);
        return $items;
    }

    public static function getCount($id, $default = 0)
    {
        return ArrayHelper::getValue(self::show(), $id, $default);
    }

    /**
     * @return Order|bool
     */
    public static function order()
    {
        self::$_error = [];
        /**
         * @var PvOrderOffer $pv
         */
        if (!self::show()) {
            return false;
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $order = new Order();
            $order->user_id = \Yii::$app->user->getId();
            $order->sum = self::totalSum();
            $order->save();
            if (!$order->save()) {
                throw new \Exception(Html::errorSummary($order));
            }
            foreach (self::show() as $id => $count) {
                $offer = Offer::findOne($id, true);
                $pv = $order->addPivot($offer, PvOrderOffer::className());
                $pv->count = $count;
                $pv->sum = $offer->sum_in_basket;
                $pv->price_type_id = $offer->getMainPrice()->type_id;
                if (!$pv->save()) {
                    throw new \Exception(Html::errorSummary($pv));
                }
            }
            $transaction->commit();
            self::shake();
            return $order;
        } catch (\Exception $e) {
            self::$_error = $e->getMessage();
            $transaction->rollBack();
            return false;
        }
    }

    public static function getError()
    {
        return self::$_error;
    }

    public static function getIds()
    {
        return array_keys(self::show());
    }

    public static function isFilled()
    {
        return (bool)self::show();
    }

    public static function count()
    {
        $result = 0;
        foreach (self::show() as $id => $count) {
            $result += $count;
        }
        return $result;
    }

    public static function put($id, $count)
    {
        Offer::findOne($id, true);
        $basket = self::show();
        $count = abs($count);
        isset($basket[$id]) ? $basket[$id] += abs($count) : $basket[$id] = $count;
        if ($basket[$id] > self::MAX_COUNT) {
            $basket[$id] = self::MAX_COUNT;
        }
        self::storage($basket);
    }

    protected static function storage($basket)
    {
        \Yii::$app->session->set('basket', $basket);
    }

    public static function trash($id)
    {
        $basket = self::show();
        unset($basket[$id]);
        self::storage($basket);
    }

    public static function remove($id, $count = 1)
    {
        $basket = self::show();
        $count = abs($count);
        if (isset($basket[$id]) && $basket[$id] > $count) {
            $basket[$id] = \Yii::$app->formatter->asDecimal($basket[$id] - $count, 1);
        } else {
            unset($basket[$id]);
        }
        self::storage($basket);
    }

    public static function set($id, $count)
    {
        Product::findOne($id, true);
        $count = abs($count);
        if (!$count) {
            self::trash($id);
        } else {
            $basket = self::show();
            $basket[$id] = $count > self::MAX_COUNT ? self::MAX_COUNT : $count;
            self::storage($basket);
        }
    }

    public static function show()
    {
        $result = [];
        foreach (\Yii::$app->session->get('basket', []) as $id => $count) {
            if (Product::findOne(['id' => $id, 'is_active' => true])) {
                $result[$id] = $count;
            }
        }
        return $result;
    }
}