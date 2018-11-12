<?php
/**
 * Created by PhpStorm.
 * User: Броненосец
 * Date: 12.11.2018
 * Time: 13:33
 */

namespace app\models\events;


use app\models\Events;

class Game extends Events
{

    private static $condition;


    public function __construct(array $config = [])
    {
        self::$condition = array_merge_recursive(Wedding::CONDITION, Kinoselfie::CONDITION, Talisman::CONDITION);
        parent::__construct($config);
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
            $query = self::find()->where(array_merge_recursive(WeddingEmail::CONDITION, KinoselfieEmail::CONDITION));
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
}