<?php

use yii\db\Migration;

/**
 * Class m181106_182722_create_table_events
 */
class m181106_182722_create_table_events extends Migration
{
    private $tableName = 'events';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('events', [
            'device_id' => $this->integer(11),
            'time' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'name' => $this->string(40)->notNull(),
            'data' => $this->string(20)->defaultValue(0)->notNull(),
            'nonce' => $this->string(20)->defaultValue(null)
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
            echo "m181106_182722_create_table_events cannot be reverted.\n";
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
        echo "m181106_182722_create_table_events cannot be reverted.\n";

        return false;
    }
    */
}
