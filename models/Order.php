<?php

namespace app\models;

use carono\exchange1c\interfaces\DocumentInterface;
use carono\exchange1c\interfaces\PartnerInterface;
use carono\exchange1c\interfaces\ProductInterface;
use carono\yii2installer\traits\PivotTrait;
use Yii;
use \app\models\base\Order as BaseOrder;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 */
class Order extends BaseOrder implements DocumentInterface
{
    use PivotTrait;

    /**
     * @return DocumentInterface[]
     */
    public static function findOrders1c()
    {
        return self::find()->all();
    }

    /**
     * @return ProductInterface[]
     */
    public function getProducts1c()
    {
        return $this->offers;
    }

    public function getRequisites1c()
    {
        // TODO: Implement getRequisites1c() method.
    }

    /**
     * Получаем контрагента у документа
     *
     * @return PartnerInterface
     */
    public function getPartner1c()
    {
        return User::findByUsername('admin');
    }

    public static function getFields1c()
    {
        // TODO: Implement getFields1c() method.
    }

    public function getExportFields1c()
    {
        return [
            'Ид' => 'id',
            'Номер' => 'id',
            'Дата' => Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d'),
            'Время' => Yii::$app->formatter->asTime($this->created_at, 'php:H:i:s'),
            'ХозОперация' => 'Заказ товара',
            'Роль' => 'Продавец',
            'Валюта' => 'RUB',
            'Курс' => '1',
            'Сумма' => $this->sum,
//            'Оплаты'      => [
//                'Оплата' => [
//                    'НомерДокумента'   => 'avangard' . $this->id,
//                    'НомерТранзакции ' => 'avangard' . $this->id,
//                    'ДатаОплаты'       => $this->paid_at,
//                    'СуммаОплаты'      => $this->total_sum,
//                    'СпособОплаты'     => 'Авангард',
//                    'ИдСпособаОплаты'  => 'visa',
//                ]
//            ],
        ];
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
}
