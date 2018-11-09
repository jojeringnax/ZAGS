<?php

namespace app\models;


/**
 * This is the model class for table "events".
 *
 * @property integer $device_id
 * @property string $time [datetime]
 * @property string $name [varchar(40)]
 * @property string $data [varchar(20)]
 * @property integer $nonce
 */
class Events extends \yii\db\ActiveRecord
{
    public static $labels = [
        'device_id' => 'ID устройства',
        'time' => 'Время',
        'name' => 'Событие',
        'data' => 'Данные',
        'nonce' => 'Nonce',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id'], 'integer'], [['time'], 'date'], [['name', 'data', 'nonce'], 'string']
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
            'name' => 'Событие',
            'data' => 'Данные',
            'nonce' => 'Nonce',
        ];
    }

}
