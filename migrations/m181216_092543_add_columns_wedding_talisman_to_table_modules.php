<?php

use yii\db\Migration;

/**
 * Class m181216_092543_add_columns_wedding_talisman_to_table_modules
 */
class m181216_092543_add_columns_wedding_talisman_to_table_modules extends Migration
{
    private $tableName='modules';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'wedding', $this->boolean()->defaultValue(0));
        $this->addColumn($this->tableName, 'talisman', $this->boolean()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropColumn($this->tableName, 'wedding');
            $this->dropColumn($this->tableName, 'talisman');
            echo 'ok';
            return true;
        } catch (Exception $e) {
            echo "m181216_092543_add_columns_wedding_talisman_to_table_modules cannot be reverted.\n";
            echo $e->getTraceAsString();
            return false;
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181216_092543_add_columns_wedding_talisman_to_table_modules cannot be reverted.\n";

        return false;
    }
    */
}
