<?php


class m170627_090526_images extends \carono\yii2installer\Migration
{
    public function newColumns()
    {
        return [
            'product' => [
                'images' => self::pivot('file_upload', 'image_id'),
            ],
        ];
    }

    public function safeUp()
    {
        $this->upNewColumns();
    }

    public function safeDown()
    {
        $this->downNewColumns();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170627_090526_images cannot be reverted.\n";

        return false;
    }
    */
}
