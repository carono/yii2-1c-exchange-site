<?php


class m170628_074910_property extends \carono\yii2installer\Migration
{
    public function newTables()
    {
        return [
            'property' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
            ],
            'property_value' => [
                'id' => self::primaryKey(),
                'property_id' => self::foreignKey('property'),
                'name' => self::string(),
                'accounting_id' => self::string()->unique(),
            ],
        ];
    }

    public function newColumns()
    {
        return [
            'product' => [
                'properties' => self::pivot('property'),
            ],
            'pv_product_properties' => [
                'property_value_id' => self::foreignKey('property_value'),
            ],
        ];
    }

    public function safeUp()
    {
        $this->upNewTables();
        $this->upNewColumns();
    }

    public function safeDown()
    {
        $this->downNewColumns();
        $this->downNewTables();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170628_074910_property cannot be reverted.\n";

        return false;
    }
    */
}
