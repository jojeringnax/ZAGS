<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $device_id
 * @property string $time [datetime]
 * @property string $sender [varchar(40)]
 * @property string $level [varchar(40)]
 * @property string $message [varchar(100)]
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id'], 'integer'], [['time'], 'date'], [['level', 'sender', 'message'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'ID устройства',
            'time' => 'Время',
            'level' => 'Уровень',
            'sender' => 'Источник',
            'message' => 'Сообщение',
        ];
    }
}
