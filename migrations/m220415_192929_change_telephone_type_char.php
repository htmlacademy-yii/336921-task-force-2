<?php

use yii\db\Migration;

/**
 * Class m220415_192929_change_telephone_type_char
 */
class m220415_192929_change_telephone_type_char extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn (
            "user",
            "telephone",
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
            "telephone",
            $this->integer()
        );

        echo "m220415_192929_change_telephone_type_char cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220415_192929_change_telephone_type_char cannot be reverted.\n";

        return false;
    }
    */
}
