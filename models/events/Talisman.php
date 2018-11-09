<?php

namespace app\models\events;
use \app\models\Events;
use yii\db\ActiveQuery;


class Talisman extends Events
{
    const CONDITION = ['name' => 'Talisman'];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @return array|TalismanPaymentView
     */
    public function getPaymentView()
    {
        return TalismanPaymentView::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-2])->one();
    }

    /**
     * @return array|Payment
     */
    public function getPayment()
    {
        return Payment::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-1])->one();
    }
}