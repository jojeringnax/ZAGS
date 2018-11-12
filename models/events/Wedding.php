<?php

namespace app\models\events;

use \app\models\Events;
use yii\db\ActiveQuery;

class Wedding extends Events
{
    const CONDITION = ['name' => ['Game', 'Wedding']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @return array|null|WeddingEmail
     */
    public function getEmail()
    {
        $email = WeddingEmail::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [$this->nonce+1,$this->nonce+2]])->andWhere(['<', 'time', date('Y-m-d H:i:s',strtotime($this->time) + 24*3600)])->one();
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
        return WeddingPaymentView::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-2])->andWhere(['<', 'time', date('Y-m-d H:i:s',strtotime($this->time) - 24*3600)])->one();
    }

    /**
     * @return array|null|Payment
     */
    public function getPayment()
    {
        $payment = Payment::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [0, $this->nonce-1]])->andWhere(['<', 'time', date('Y-m-d H:i:s',strtotime($this->time) - 30)])->one();
        return $payment;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        $payment = $this->getPayment();
        return $payment !== null ? $payment->name : null;
    }

    /**
     * @return array|WeddingReprint
     */
    public function getReprint()
    {
        return WeddingReprint::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce+1])->andWhere(['<', 'time', date('Y-m-d H:i:s',strtotime($this->time) + 24*3600)])->one();
    }

}