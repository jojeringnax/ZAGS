<?php

use yii\db\Migration;

/**
 * Class m181106_191113_create_table_license_requests
 */
class m181106_191113_create_table_license_requests extends Migration
{
    private $tableName = 'license_requests';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'license' => $this->text()
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
            echo "m181106_191113_create_table_license_requests cannot be reverted.\n";
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
        echo "m181106_191113_create_table_license_requests cannot be reverted.\n";

        return false;
    }
    */
}
