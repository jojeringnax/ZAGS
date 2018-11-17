<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "owners".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $device_id
 */
class Owner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'owners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'device_id'], 'required'],
            [['user_id', 'device_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'device_id' => 'Device ID',
        ];
    }
}
