<?php

use yii\db\Migration;

/**
 * Class m220415_145803_change_telephone_type
 */
class m220415_145803_change_telephone_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn (
            "user",
            "telephone",
            "bigint"
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
            "int"
        );

        echo "m220415_145803_change_telephone_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220415_145803_change_telephone_type cannot be reverted.\n";

        return false;
    }
    */
}
