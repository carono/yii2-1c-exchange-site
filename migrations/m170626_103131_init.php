<?php


class m170626_103131_init extends \carono\yii2installer\Migration
{
    public function newTables()
    {
        return [
            'group' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование группы'),
                'parent_id' => self::foreignKey('group'),
                'accounting_id' => self::string()->unique(),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
                'is_active' => self::boolean()->notNull()->defaultValue(true),
            ],
            'warehouse' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование склада'),
                'accounting_id' => self::string()->unique(),
            ],
            'product' => [
                'id' => self::primaryKey(),
                'name' => self::string()->comment('Наименование товара'),
                'article' => self::string()->comment('Артикул'),
                'description' => self::string()->comment('Описание товара'),
                'accounting_id' => self::string()->unique(),
                'group_id' => self::foreignKey('group'),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime(),
                'is_active' => self::boolean()->notNull()->defaultValue(true),
            ],
            'price_type' => [
                'id' => self::primaryKey(),
                'accounting_id' => self::string()->unique(),
                'name' => self::string()->comment('Наименование типа цены'),
                'currency' => self::string()->comment('Валюта'),
            ],
            'price' => [
                'id' => self::primaryKey(),
                'performance' => self::string(),
                'value' => self::decimal(10, 2)->comment('Цена за единицу'),
                'currency' => self::string()->comment('Валюта'),
                'rate' => self::float()->comment('Коэффициент'),
                'type_id' => self::foreignKey('price_type'),
            ],
            'offer' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
                'price_id' => self::foreignKey('price'),
                'product_id' => self::foreignKey('product'),
                'remnant' => self::decimal(10, 3)->comment('Остаток (количество)'),
                'warehouses' => self::pivot('warehouse'),
            ],
        ];
    }

    public function safeUp()
    {
        $this->upNewTables();
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
