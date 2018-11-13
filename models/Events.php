<?php

namespace app\models;
use app\models\events\Kinoselfie;
use app\models\events\Payment;
use app\models\events\Talisman;
use app\models\events\Wedding;
use yii\db\Exception;


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


    /**
     * @param null|string $timeFrom
     * @param null|string $timeTo
     * @param $deviceId integer
     * @return null
     * @throws Exception
     */
    public static function getEventsForTime($deviceId, $timeFrom = null, $timeTo = null)
    {
        if($timeFrom === null || $timeTo === null) {
            throw(new Exception('Need to choose time'));
        }
        /* @var $events Events[] */
        $events = self::find()
            ->where(array_merge_recursive(Wedding::CONDITION, Payment::CONDITION, Talisman::CONDITION, Kinoselfie::CONDITION))
            ->andWhere(['between', 'time', $timeFrom, $timeTo])
            ->andWhere(['device_id' => $deviceId])
            ->all();
        foreach($events as $event) {
            $resultArray[date('Y-m-d', strtotime($event->time))][] = $event;
        }
        ksort($resultArray, SORT_STRING);
        foreach ($resultArray as $data => $events) {
            $array = [];
            foreach($events as $event) {
                $array[$event->name][] = $event;
            }
            $resultArray[$data] = $array;
        }
        return isset($resultArray) ? $resultArray : null;
    }

}
