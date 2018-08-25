<?php

namespace app\models;

use carono\exchange1c\interfaces\DocumentInterface;
use carono\exchange1c\interfaces\OfferInterface;
use carono\exchange1c\interfaces\PartnerInterface;
use carono\yii2migrate\traits\PivotTrait;
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
    public static function findDocuments1c()
    {
        return self::find()->andWhere(['status_id' => 2])->all();
    }

    /**
     * @return OfferInterface[]
     */
    public function getOffers1c()
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

    public function getExportFields1c($context = null)
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
            'ЗначенияРеквизитов' => [
//                [
//                    '@name' => 'ЗначениеРеквизита',
//                    '@content' => ['Наименование' => 'Метод оплаты', 'Значение' => 'Наличный расчет']
//                ],
//                [
//                    '@name' => 'ЗначениеРеквизита',
//                    '@content' => ['Наименование' => 'Заказ оплачен', 'Значение' => 'true']
//                ],
//                [
//                    '@name' => 'ЗначениеРеквизита',
//                    '@content' => ['Наименование' => 'Доставка разрешена', 'Значение' => 'true']
//                ],
                [
                    '@name' => 'ЗначениеРеквизита',
                    '@content' => ['Наименование' => 'Статус заказа', 'Значение' => 'Согласовано']
                ],
//                [
//                    '@name' => 'ЗначениеРеквизита',
//                    '@content' => ['Наименование' => 'Финальный статус', 'Значение' => 'true']
//                ],
            ]
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
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param \Zenwalker\CommerceML\CommerceML $cml
     * @param \Zenwalker\CommerceML\Model\Simple $object
     * @return mixed
     */
    public function setRaw1cData($cml, $object)
    {
        // TODO: Implement setRaw1cData() method.
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
