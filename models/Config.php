<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $wedding_price
 * @property integer $reprint_price
 * @property integer $disabled
 * @property integer $device_id
 * @property string $bills
 * @property integer $multitouch_enabled
 * @property string $description
 * @property string $log_level
 * @property integer $quiet_time_start
 * @property integer $quiet_time_end
 *
 */
class Config extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wedding_price', 'reprint_price', 'device_id', 'disabled', 'multitouch_enabled', 'quiet_time_start', 'quiet_time_end'], 'integer'],
            [['bills', 'description', 'log_level'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wedding_price' => 'Цена Свадьбы',
            'reprint_price' => 'Цена повторной печати',
            'disabled' => 'Отключение аппарата',
            'device_id' => 'Номер устройства',
            'bills' => 'Купюры',
            'multitouch_enabled' => 'Мультитач',
            'description' => 'Описание',
            'log_level' => 'Уровень логов',
            'quiet_time_start' => 'Начало тихого режима',
            'quiet_time_end' => 'Конец тихого режима',
        ];
    }

    /**
     * @return int
     */
    public function getToner() {
        return CurrentStatus::findOne($this->device_id)->printer_media_count;
    }
}
