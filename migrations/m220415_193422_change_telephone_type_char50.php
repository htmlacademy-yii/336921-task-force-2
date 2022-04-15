<?php

use yii\db\Migration;

/**
 * Class m220415_193422_change_telephone_type_char50
 */
class m220415_193422_change_telephone_type_char50 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn (
            "user",
            "telephone",
            $this->string(50)
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
        
        echo "m220415_193422_change_telephone_type_char50 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220415_193422_change_telephone_type_char50 cannot be reverted.\n";

        return false;
    }
    */
}
