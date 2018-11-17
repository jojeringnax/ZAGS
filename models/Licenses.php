<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licenses".
 *
 * @property integer $id
 * @property string $license
 * @property string $last_check [datetime]
 */
class Licenses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'licenses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'license' => 'License',
            'last_check' => 'Last check',
        ];
    }
}
