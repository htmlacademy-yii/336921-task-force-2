<?php

use yii\db\Migration;

/**
 * Class m220415_200444_change_avatar_field_size
 */
class m220415_200444_change_avatar_field_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn (
            "user",
            "avatar",
            $this->string()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn (
            "user",
            "avatar",
            $this->string(50)
        );
        echo "m220415_200444_change_avatar_field_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220415_200444_change_avatar_field_size cannot be reverted.\n";

        return false;
    }
    */
}
