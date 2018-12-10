<?php

use yii\db\Migration;

/**
 * Class m181207_091912_add_column_version_to_uptimes
 */
class m181207_091912_add_column_version_to_uptimes extends Migration
{
    private $tableName = 'uptimes';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName,'version', $this->string(12));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn($this->tableName, 'version');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181207_091912_add_column_version_to_uptimes cannot be reverted.\n";

        return false;
    }
    */
}
