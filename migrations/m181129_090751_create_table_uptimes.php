<?php

use yii\db\Migration;

/**
 * Class m181129_090751_create_table_uptimes
 */
class m181129_090751_create_table_uptimes extends Migration
{

    private $tableName = 'uptimes';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'module_id' => $this->integer(11),
            'created_date' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'uptime' => $this->integer(11)
        ]);

        $this->addForeignKey(
            'fk-uptimes-module_id',
            $this->tableName,
            'module_id',
            'modules',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropForeignKey('fk-uptimes-module_id', $this->tableName);
            $this->dropTable($this->tableName);
            return true;
        } catch (Exception $e) {
            echo "m181129_090751_create_table_uptimes cannot be reverted.\n";
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
        echo "m181129_090751_create_table_uptimes cannot be reverted.\n";

        return false;
    }
    */
}
