<?php


class m170626_103131_init extends \yii\db\Migration
{
    use \carono\yii2migrate\traits\MigrationTrait;

    public function newTables()
    {
        return [
            '{{%catalog}}' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
            ],
            '{{%group}}' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование группы'),
                'parent_id' => self::foreignKey('{{%group}}'),
                'accounting_id' => self::string()->unique(),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
                'is_active' => self::boolean()->notNull()->defaultValue(true),
            ],
            '{{%warehouse}}' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование склада'),
                'accounting_id' => self::string()->unique(),
            ],
            '{{%requisite}}' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
            ],
            '{{%property}}' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
            ],
            '{{%property_value}}' => [
                'id' => self::primaryKey(),
                'property_id' => self::foreignKey('{{%property}}'),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
            ],
            '{{%product}}' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование товара'),
                'article' => self::string()->comment('Артикул'),
                'description' => self::string()->comment('Описание товара'),
                'accounting_id' => self::string()->unique(),
                'group_id' => self::foreignKey('{{%group}}'),
                'catalog_id' => self::foreignKey('{{%catalog}}'),
                'is_active' => self::boolean()->notNull()->defaultValue(true),
                'images' => self::pivot('{{%file_upload}}', 'image_id'),
                'requisite' => self::pivot('{{%requisite}}')->columns(['value' => self::string(1024),]),
                'properties' => self::pivot('{{%property}}')->columns(['property_value_id' => self::foreignKey('{{%property_value}}')]),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
            ],
            '{{%price_type}}' => [
                'id' => self::primaryKey(),
                'accounting_id' => self::string()->unique(),
                'name' => self::string()->comment('Наименование типа цены'),
                'currency' => self::string()->comment('Валюта'),
            ],
            '{{%price}}' => [
                'id' => self::primaryKey(),
                'performance' => self::string(),
                'value' => self::decimal(10, 2)->comment('Цена за единицу'),
                'currency' => self::string()->comment('Валюта'),
                'rate' => self::float()->comment('Коэффициент'),
                'type_id' => self::foreignKey('{{%price_type}}'),
            ],
            '{{%specification}}' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique()
            ],
            '{{%offer}}' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
                'product_id' => self::foreignKey('{{%product}}'),
                'remnant' => self::decimal(10, 3)->comment('Остаток (количество)'),
                'warehouses' => self::pivot('{{%warehouse}}'),
                'prices' => self::pivot('{{%price}}'),
                'specifications' => self::pivot('{{%specification}}')->columns(['value' => self::string()]),
                'is_active' => self::boolean()->notNull()->defaultValue(true)
            ],
            '{{%order_status}}' => [
                'id' => self::primaryKey(),
                'name' => self::string()
            ],
            '{{%order}}' => [
                'id' => self::primaryKey(),
                'user_id' => self::integer(),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
                'status_id' => self::foreignKey('{{%order_status}}'),
                'sum' => self::decimal(10, 2),
                'offers' => self::pivot('{{%offer}}')->columns([
                    'count' => self::decimal(10, 3),
                    'sum' => self::decimal(10, 2),
                    'price_type_id' => self::foreignKey('{{%price_type}}')
                ])
            ]
        ];
    }

    public function safeUp()
    {
        $this->upNewTables();
        $statuses = [
            ['name' => 'Согласован'],
            ['name' => 'Не согласован'],
            ['name' => 'Закрыт'],
        ];
        foreach ($statuses as $status) {
            $this->insert('{{%order_status}}', $status);
        }
    }

    public function safeDown()
    {
        $this->downNewTables();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170626_103131_init cannot be reverted.\n";

        return false;
    }
    */
}
