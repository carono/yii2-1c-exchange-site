<?php


class m170628_072900_requisite extends \carono\yii2installer\Migration
{
    public function newTables()
    {
        return [
            'requisite' => [
                'id' => self::primaryKey(),
                'name' => self::string(),
            ],
        ];
    }

    public function newColumns()
    {
        return [
            'product' => [
                'requisite' => self::pivot('requisite'),
            ],
            'pv_product_requisite' => [
                'value' => self::string(1024),
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
        echo "m170628_072900_requisite cannot be reverted.\n";

        return false;
    }
    */
}
