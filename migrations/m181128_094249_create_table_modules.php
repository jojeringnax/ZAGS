<?php

use yii\db\Migration;

/**
 * Class m181128_094249_create_table_modules
 */
class m181128_094249_create_table_modules extends Migration
{
    private $tableName = 'modules';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer(11),
            'name' => $this->string(16),
            'status' => $this->integer(1),
            'error' => $this->text(),
            'updated_at' => 'timestamp on update current_timestamp',
            'created_at' => $this->timestamp()->defaultExpression('current_timestamp'),
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
            echo "m181128_094249_create_table_modules cannot be reverted.\n";
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
        echo "m181128_094249_create_table_modules cannot be reverted.\n";

        return false;
    }
    */
}
