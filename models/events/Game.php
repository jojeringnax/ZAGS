<?php
/**
 * Created by PhpStorm.
 * User: Броненосец
 * Date: 12.11.2018
 * Time: 13:33
 */

namespace app\models\events;


use app\models\Events;
use yii\db\ActiveQuery;

class Game extends Events
{



    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public static function getCondition()
    {
        return array_merge_recursive(Wedding::CONDITION, Kinoselfie::CONDITION, Talisman::CONDITION);
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->where(self::$condition);
    }

    /**
     * @return array|null|Game
     */
    public function getEmail()
    {
        /**
         * @var $class Events
         */
        $class = $this->className().'Email';
        if ($this->className() === $this->className()) {
            $query = self::find();
        } else {
            $query = $class::find();
        }
        $email = $query->andWhere(['device_id' => $this->device_id, 'nonce' => [0, $this->nonce+1,$this->nonce+2]])->andWhere(['between', 'time', date('Y-m-d H:i:s',strtotime($this->time) + 10*60), $this->time])->one();
        return $email;
    }

    /**
     * @return null|string
     */
    public function getEmailData()
    {
        $email = $this->getEmail();
        return $email !== null ? $email->data : null;
    }

    /**
     * @return array|WeddingPaymentView
     */
    public function getPaymentView()
    {
        /**
         * @var $class Events
         */
        $class = $this->className().'PaymentView';
        return $class::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [0, $this->nonce-2]])->andWhere(['between', 'time', date('Y-m-d H:i:s',strtotime($this->time) - 60), $this->time])->one();
    }

    /**
     * @return array|null|Payment[]
     */
    public function getPayments()
    {
        $payment = Payment::find()
            ->andWhere(['nonce' => [0, $this->nonce-1, $this->nonce-2, $this->nonce-3, $this->nonce-4]])
            ->andWhere(['device_id' => $this->device_id])
            ->andWhere(['between', 'time', date('Y-m-d H:i:s',strtotime($this->time) - 120), $this->time])
            ->all();
        return $payment;
    }

    /**
     * @return array
     */
    public function getPaymentData()
    {
        $payments = $this->getPayments();
        $result = [];
        foreach ($payments as $payment) {
            $result[] = array(
              'label' => $payment->getLabel(),
              'number' => $payment->data
            );
        }
        return $result;
    }

    /**
     * @return array|WeddingReprint
     */
    public function getReprint()
    {
        /**
         * @var $class Events
         */
        $class = $this->className().'Reprint';
        return $class::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [0, $this->nonce+1]])->andWhere(['between', 'time', date('Y-m-d H:i:s',strtotime($this->time) + 30), $this->time])->one();
    }

    public function getAllGamesForDevice($deviceId)
    {
        return self::find()->andWhere(['device_id' => $deviceId]);
    }
}