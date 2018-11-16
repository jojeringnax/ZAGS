<?php

namespace app\models\events;

use \app\models\Events;
use yii\db\ActiveQuery;

class Encashment extends Events
{
    const CONDITION = ['name' => 'Encashment'];


    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @param $deviceId
     * @return ActiveQuery
     */
    public static function findAllEncashmentForDevice($deviceId)
    {
        return self::find()->andWhere(['device_id' => $deviceId]);
    }

    /**
     * @param $id
     * @return array|bool|null
     */
    public static function getEncashmentsWithTotalForDevice($id)
    {
        $i = 0;
        $totalForEncashment = 0;
        $paymentsAndEncashments = Events::find()->where(array_merge(['device_id' => $id], array_merge_recursive(Encashment::CONDITION, Payment::CONDITION)))->orderBy('time ASC')->all();
        if ($paymentsAndEncashments === null) {return false;}
        foreach ($paymentsAndEncashments as $event) {
            if($event->name == self::CONDITION['name']) {
                $event->data = $totalForEncashment;
                $resultArray[] = $event;
                $i++;
                $totalForEncashment = 0;
            } else {
                $totalForEncashment += $event->data;
            }
        }
        return isset($resultArray) ? $resultArray : [];
    }
}