<?php

use yii\db\Migration;

/**
 * Class m181106_181933_create_table_current_status
 */
class m181106_181933_create_table_current_status extends Migration
{
    private $tableName = 'current_status';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'device_id' => $this->primaryKey(),
            'last_update' => $this->timestamp()->append('on update CURRENT_TIMESTAMP')->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'fill_wedding' => $this->integer(11)->defaultValue(null),
            'fill_talisman' => $this->integer(11)->defaultValue(null),
            'printer_media_count' => $this->integer(11)->defaultValue(null)
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
            echo "m181106_181933_create_table_current_status cannot be reverted.\n";
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
        echo "m181106_181933_create_table_current_status cannot be reverted.\n";

        return false;
    }
    */
}
