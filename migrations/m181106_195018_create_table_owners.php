<?php

use yii\db\Migration;

/**
 * Class m181106_195018_create_table_owners
 */
class m181106_195018_create_table_owners extends Migration
{
    private $tableName = 'owners';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'device_id' => $this->integer(11)
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable($this->tableName);
            return true;
        } catch (Exception $e) {
            echo "m181106_195018_create_table_owners cannot be reverted.\n";
            echo $e->getMessage();
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
        echo "m181106_195018_create_table_owners cannot be reverted.\n";

        return false;
    }
    */
}
