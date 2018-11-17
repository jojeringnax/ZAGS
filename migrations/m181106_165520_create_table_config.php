<?php

use yii\db\Migration;

/**
 * Class m181106_165520_create_table_config
 */
class m181106_165520_create_table_config extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('config', [
            'wedding_price' => $this->integer(11)->defaultValue(200),
            'disabled' => $this->integer(11)->defaultValue(null),
            'device_id' => $this->primaryKey(),
            'bills' => $this->string(255)->defaultValue(null),
            'multitouch_enabled' => $this->integer(11)->defaultValue(null),
            'description' => $this->string(255)->notNull(),
            'log_level' => $this->string(45)->notNull(),
            'quiet_time_start' => $this->integer(11)->defaultValue(0)->notNull(),
            'quiet_time_end' => $this->integer(11)->defaultValue(0)->notNull(),
            'reprint_price' => $this->integer(11)->defaultValue(50)->notNull(),
            'talisman_price' => $this->integer(11)->defaultValue(200)->notNull(),
            'kinoselfie_price' => $this->integer(11)->defaultValue(200)->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable('config');
            return true;
        } catch (Exception $e) {
            echo "m181106_165520_create_table_config cannot be reverted.\n";
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
        echo "m181106_165520_create_table_config cannot be reverted.\n";

        return false;
    }
    */
}
