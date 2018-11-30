<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;
use yii\db\Exception;

class Payment extends Events
{
    const CONDITION = ['name' => ['Money', 'Cashless']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null, $onlyCashless = false, $onlyMoney = false)
    {
        if ($onlyMoney) {
            return parent::find()->andWhere(['name' => 'Money'])->limit($limit);
        } else if ($onlyCashless) {
            return parent::find()->andWhere(['name' => 'Cashless'])->limit($limit);
        }
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->name == 'Money' ? 'Наличный расчет' : 'Безналичный расчет';
    }

    /**
     * @param $deviceId
     * @return int|mixed
     */
    public static function getStackerForDevice($deviceId)
    {
        $result = 0;
        $lastEncashment = Encashment::getLastEncashmentForDevice($deviceId);
        $time = $lastEncashment === null ? '' : $lastEncashment->time;
        $payments = self::find(null, false, true)->andWhere(['device_id' => $deviceId])->andWhere(['between', 'time', $time, date('Y-m-d H:i:s')])->all();
        foreach ($payments as $payment) {
            $result += $payment->data;
        }
        return $result;
    }

}