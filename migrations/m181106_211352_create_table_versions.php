<?php

use yii\db\Migration;

/**
 * Class m181106_211352_create_table_versions
 */
class m181106_211352_create_table_versions extends Migration
{
    private $tableName = 'versions';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'branch' => $this->string(50)->notNull(),
            'last_version' => $this->string(30)->notNull(),
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
            echo "m181106_211352_create_table_versions cannot be reverted.\n";
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
        echo "m181106_211352_create_table_versions cannot be reverted.\n";

        return false;
    }
    */
}
