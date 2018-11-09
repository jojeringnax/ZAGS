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
     * @return WeddingEmail[]
     */
    public function getEmail()
    {
        return WeddingEmail::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [$this->nonce+1,$this->nonce+2]])->one();
    }

    /**
     * @return array|WeddingPaymentView
     */
    public function getPaymentView()
    {
        return WeddingPaymentView::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-2])->one();
    }

    /**
     * @return array|Payment
     */
    public function getPayment()
    {
        return Payment::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-1])->one();
    }

    /**
     * @return array|WeddingReprint
     */
    public function getReprint()
    {
        return WeddingReprint::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce+1])->one();
    }

}