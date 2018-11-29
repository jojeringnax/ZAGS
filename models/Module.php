<?php

namespace app\models;

use function GuzzleHttp\Psr7\str;
use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property int $id
 * @property int $device_id
 * @property string $name
 * @property float $uptime_yesterday
 * @property float $uptime_today
 * @property float $uptime_month
 * @property int $status
 * @property string $error
 * @property string $update_at
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
            'updated_at' => 'Изменен',
            'status' => 'Статус',
            'error' => 'Ошибка',
        ];
    }


    /**
     * @return bool
     */
    public function setUptimesNeeded()
    {
        $uptimes = Uptime::getForCurrentMonthForModule($this->id);
        if ($uptimes === null) {
            $this->uptime_yesterday = 0;
            $this->uptime_today = 0;
            $this->uptime_month = 0;
            return false;
        }
        $sum = 0;
        $uptimeToday = 0;
        $uptimeYesterday = 0;
        foreach ($uptimes as $uptime) {
            $uptimeDay = date('Y-m-d', strtotime($uptime->created_date));
            $sum += $uptime->uptime;
            if ($uptimeDay === date('Y-m-d')) {
                $uptimeToday = $uptime->uptime;
            }
            if ($uptimeDay === date('Y-m-d', strtotime(date('Y-m-d')) - 24*3600)) {
                $uptimeYesterday = $uptime->uptime;
            }
        }
        $uptimeAvgMonth = $sum/count($uptimes);
        $this->uptime_yesterday = $uptimeYesterday;
        $this->uptime_today = $uptimeToday;
        $this->uptime_month = $uptimeAvgMonth;
        return true;
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
     * @return \yii\db\ActiveQuery
     */
    public function getUptimes()
    {
        return $this->hasMany(Uptime::className(), ['module_id' => 'id']);
    }

    /**
     * @param $device_id
     * @param $name
     * @param $uptime
     * @param $status
     * @param $error
     * @return int
     */
    public static function findOrCreateAndUpdate($device_id, $name, $uptime, $status, $error)
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
        $module->status = $status;
        $module->error = $error;
        $module->save();
        $uptimeEx = new Uptime();
        $uptimeEx->module_id = $module->id;
        $uptimeEx->uptime = $uptime;
        $uptimeEx->save();
        $module->setUptimesNeeded();
        return $result;
    }


}
