<?php

use yii\db\Migration;

/**
 * Class m181106_191532_create_table_logs
 */
class m181106_191532_create_table_logs extends Migration
{
    private $tableName = 'logs';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'device_id' => $this->primaryKey(),
            'time' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'sender' => $this->string(40)->notNull(),
            'level' => $this->string(40)->notNull(),
            'message' => $this->string(100)->notNull()
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
            echo "m181106_191532_create_table_logs cannot be reverted.\n";
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
        echo "m181106_191532_create_table_logs cannot be reverted.\n";

        return false;
    }
    */
}
