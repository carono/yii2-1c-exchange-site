<?php


class m170626_103131_init extends \yii\db\Migration
{
    use \carono\yii2migrate\traits\MigrationTrait;

    public function newTables()
    {
        return [
            '{{%catalog}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'accounting_id' => $this->string()->unique(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ],
            '{{%group}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string()->comment('Наименование группы'),
                'parent_id' => $this->foreignKey('{{%group}}'),
                'accounting_id' => $this->string()->unique(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'is_active' => $this->boolean()->notNull()->defaultValue(true),
            ],
            '{{%warehouse}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string()->comment('Наименование склада'),
                'accounting_id' => $this->string()->unique(),
            ],
            '{{%requisite}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
            ],
            '{{%property}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'accounting_id' => $this->string()->unique(),
            ],
            '{{%property_value}}' => [
                'id' => $this->primaryKey(),
                'property_id' => $this->foreignKey('{{%property}}'),
                'name' => $this->string(),
                'accounting_id' => $this->string()->unique(),
            ],
            '{{%product}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string()->comment('Наименование товара'),
                'article' => $this->string()->comment('Артикул'),
                'description' => $this->string()->comment('Описание товара'),
                'accounting_id' => $this->string()->unique(),
                'group_id' => $this->foreignKey('{{%group}}'),
                'catalog_id' => $this->foreignKey('{{%catalog}}'),
                'is_active' => $this->boolean()->notNull()->defaultValue(true),
                'images' => $this->pivot('{{%file_upload}}', 'image_id')->columns([
                    'caption' => $this->string()
                ]),
                'requisite' => $this->pivot('{{%requisite}}')->columns([
                    'value' => $this->string(1024),
                ]),
                'properties' => $this->pivot('{{%property}}')->columns([
                    'property_value_id' => $this->foreignKey('{{%property_value}}'),
                    'value' => $this->string()
                ]),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ],
            '{{%price_type}}' => [
                'id' => $this->primaryKey(),
                'accounting_id' => $this->string()->unique(),
                'name' => $this->string()->comment('Наименование типа цены'),
                'currency' => $this->string()->comment('Валюта'),
            ],
            '{{%price}}' => [
                'id' => $this->primaryKey(),
                'performance' => $this->string(),
                'value' => $this->decimal(10, 2)->comment('Цена за единицу'),
                'currency' => $this->string()->comment('Валюта'),
                'rate' => $this->float()->comment('Коэффициент'),
                'type_id' => $this->foreignKey('{{%price_type}}'),
            ],
            '{{%specification}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'accounting_id' => $this->string()->unique()
            ],
            '{{%offer}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'accounting_id' => $this->string()->unique(),
                'product_id' => $this->foreignKey('{{%product}}'),
                'remnant' => $this->decimal(10, 3)->comment('Остаток (количество)'),
                'warehouses' => $this->pivot('{{%warehouse}}'),
                'prices' => $this->pivot('{{%price}}'),
                'specifications' => $this->pivot('{{%specification}}')->columns([
                    'value' => $this->string()
                ]),
                'is_active' => $this->boolean()->notNull()->defaultValue(true)
            ],
            '{{%order_status}}' => [
                'id' => $this->primaryKey(),
                'name' => $this->string()
            ],
            '{{%order}}' => [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'status_id' => $this->foreignKey('{{%order_status}}'),
                'sum' => $this->decimal(10, 2),
                'offers' => $this->pivot('{{%offer}}')->columns([
                    'count' => $this->decimal(10, 3),
                    'sum' => $this->decimal(10, 2),
                    'price_type_id' => $this->foreignKey('{{%price_type}}')
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
