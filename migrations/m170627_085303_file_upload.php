<?php

use yii\db\Migration;

class m170627_085303_file_upload extends Migration
{
    public function safeUp()
    {
        \carono\yii2installer\InstallController::migrate('@vendor/carono/yii2-file-upload/migrations/m161228_100819_init');
    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170627_085303_file_upload cannot be reverted.\n";

        return false;
    }
    */
}
