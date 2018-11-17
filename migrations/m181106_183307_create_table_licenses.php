<?php

use yii\db\Migration;

/**
 * Class m181106_183307_create_table_licenses
 */
class m181106_183307_create_table_licenses extends Migration
{
    private $tableName = 'licenses';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('licenses', [
           'id' => $this->primaryKey(11),
            'license' => $this->string(255)->defaultValue(null),
            'last_check' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
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
            echo "m181106_183307_create_table_licenses cannot be reverted.\n";
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
        echo "m181106_183307_create_table_licenses cannot be reverted.\n";

        return false;
    }
    */
}
