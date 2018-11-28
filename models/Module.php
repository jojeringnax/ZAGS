<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property int $device_id
 * @property string $name
 * @property float $uptime_yesterday
 * @property float $uptime_today
 * @property float $uptime_month
 * @property int $status
 * @property string $error
 * @property CurrentStatus $device
 */
class Module extends \yii\db\ActiveRecord
{
    const STATUSES = array(
        'Работает',
        'Не работает',
        'Возможно не работает',
        'Отключен'
    );

    const CREATED = 1;
    const UPDATED = 2;

    const NAMES = [
        'validator',
        'cashless',
        'printer',
        'camera',
        'dispenser'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id', 'status'], 'integer'],
            [['uptime_yesterday', 'uptime_today', 'uptime_month'], 'float'],
            [['error'], 'string'],
            [['name'], 'string', 'max' => 16],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => CurrentStatus::className(), 'targetAttribute' => ['device_id' => 'device_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'ID Терминала',
            'name' => 'Имя модуля',
            'uptime_yesterday' => 'Uptime за вчера',
            'uptime_today' => 'Uptime за сегодня',
            'uptime_month' => 'Uptime за месяц',
            'status' => 'Статус',
            'error' => 'Ошибка',
        ];
    }

    /**
     * @return mixed
     */
    public function getTextStatus()
    {
        return self::STATUSES[$this->status];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(CurrentStatus::className(), ['device_id' => 'device_id']);
    }

    /**
     * @param $device_id
     * @param $name
     * @param $uptime_yesterday
     * @param $uptime_today
     * @param $uptime_month
     * @param $status
     * @param $error
     * @return int
     */
    public static function findOrCreateAndUpdate($device_id, $name, $uptime_yesterday, $uptime_today, $uptime_month, $status, $error)
    {
        $module = self::find()->where(['device_id' => $device_id, 'name' => $name])->one();
        if ($module === null) {
            $module = new self();
            $module->device_id = $device_id;
            $module->name = $name;
            $result = self::CREATED;
        } else {
            $result = self::UPDATED;
        }
        $module->uptime_yesterday = $uptime_yesterday;
        $module->uptime_today = $uptime_today;
        $module->uptime_month = $uptime_month;
        $module->status = $status;
        $module->error = $error;
        $module->save();
        return $result;
    }
}
