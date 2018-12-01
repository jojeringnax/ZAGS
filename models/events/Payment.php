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
     * @return array
     * @throws Exception
     */
    public static function getStackerForDevices($deviceId)
    {
        if (empty($deviceId) || $deviceId === null) {
            throw new Exception('Need set variable');
        }
        $payments = self::find()->andWhere(['device_id' => $deviceId])->all();
        if(is_array($deviceId)) {
            if ($payments === null) {
                foreach ($deviceId as $id) {
                    $resultStacker[$id] = 0;
                    $resultProfit[$id] = 0;
                }
                return array(
                    'profit' => $resultProfit,
                    'stacker' => $resultStacker
                );
            }
            foreach ($deviceId as $id) {
                $resultProfit[$id] = 0;
                $resultStacker[$id] = 0;
                $lastEncashment = Encashment::getLastEncashmentForDevice($id);
                if ($lastEncashment === null) {
                    foreach ($payments as $payment) {
                        if ($payment->device_id === $id) {
                            if ($payment->name === 'Money')
                                $resultStacker[$id] += $payment->data;
                            $resultProfit[$id] += $payment->data;
                        }
                    }
                    continue;
                }
                $time = $lastEncashment->time;
                foreach ($payments as $payment) {
                    if ($payment->device_id === $id) {
                        if (strtotime($payment->time) <= strtotime(date('Y-m-d')) && strtotime($payment->time) >= strtotime(date('Y-m-1'))) {
                            $resultProfit[$id] += $payment->data;
                        }
                        if (strtotime($payment->time) > strtotime($time) && $payment->name === 'Money') {
                            $resultStacker[$id] += $payment->data;
                        }
                    }
                }
            }
        } else {
            if ($payments === null) {
                return array(
                    'profit' => 0,
                    'stacker' => 0
                );
            }
            $resultStacker = 0;
            $resultProfit = 0;
            $lastEncashment = Encashment::getLastEncashmentForDevice($deviceId);
            $time = $lastEncashment === null ? '' : $lastEncashment->time;
            $payments = self::find()->andWhere(['device_id' => $deviceId])->andWhere(['between', 'time', $time, date('Y-m-d H:i:s')])->all();
            foreach ($payments as $payment) {
                $resultProfit += $payment->data;
                if ($payment->name === 'Money') {
                    $resultStacker += $payment->data;
                }
            }
        }
        return array(
            'profit' => $resultProfit,
            'stacker' => $resultStacker
        );
    }

}