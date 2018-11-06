<?php

use yii\db\Migration;

/**
 * Class m181106_195159_create_table_users
 */
class m181106_195159_create_table_users extends Migration
{

    private $tableName = 'users';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->text(),
            'password' => $this->text(),
            'auth_key' => $this->text(),
            'access_token' => $this->text()
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
            echo "m181106_195159_create_table_users cannot be reverted.\n";
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
        echo "m181106_195159_create_table_users cannot be reverted.\n";

        return false;
    }
    */
}
